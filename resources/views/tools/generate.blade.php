<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate ID dan QR Code Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/generate.css') !!}">
 
</head>
<body class="w-full min-h-screen p-4 md:p-6 bg-gray-50">

    <!-- Header Section -->
    <div class="max-w-6xl mx-auto">
        <!-- Back Button -->
        <div class="flex justify-between items-center mb-6">
            <a href="/" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-sky-100 rounded-lg shadow-sm hover:bg-sky-50 hover:text-sky-700 transition-all duration-200">
                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="font-medium">Kembali</span>
            </a>
            
            <h1 class="text-2xl md:text-3xl font-bold text-sky-800">
                <i class="fas fa-id-card mr-2"></i>Generate ID & QR Code Guru
            </h1>
        </div>

        {{-- Notifications --}}
        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg shadow-sm flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg shadow-sm flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Search Form --}}
        <form action="{{ route('generate.search') }}" method="GET" class="flex items-center gap-3 bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    class="block w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent" 
                    placeholder="Cari nama guru atau NIP..."
                />
            </div>
            <button 
                type="submit" 
                class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition flex items-center gap-2"
            >
                <i class="fas fa-search"></i>
                <span class="hidden md:inline">Cari</span>
            </button>
        </form>

        <!-- Generate ID Button -->
        <form action="{{ route('generate.id.process') }}" method="POST" class="mb-6">
            @csrf
            <button 
                type="submit" 
                class="px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-lg shadow-sm transition flex items-center gap-2"
            >
                <i class="fas fa-id-card"></i>
                Generate ID Guru
            </button>
        </form>

        <!-- Teachers List with QR Codes -->
        <div class="bg-white rounded-xl shadow-sm overflow-x-auto border border-gray-100">
            <!-- Table Header -->
            <div class="grid grid-cols-12 min-w-[900px] gap-4 bg-sky-50 px-6 py-3 border-b border-gray-200">
                <div class="col-span-2 font-medium text-sky-800">NIP</div>
                <div class="col-span-3 font-medium text-sky-800">Nama Guru</div>
                <div class="col-span-2 font-medium text-sky-800">User ID</div>
                <div class="col-span-3 font-medium text-sky-800">QR Code</div>
                <div class="col-span-2 font-medium text-sky-800 text-right">Aksi</div>
            </div>

            <!-- Teachers Data -->
            <div class="divide-y divide-gray-100">
                @forelse($teachers as $teacher)
                <div class="teacher-card grid grid-cols-12 min-w-[900px] gap-4 items-center px-4 md:px-6 py-4 hover:bg-sky-50/50">
                    <div class="col-span-2">
                        <div class="font-medium text-gray-700">{{ $teacher->nip ?: '-' }}</div>
                    </div>
                    <div class="col-span-3">
                        <div class="font-medium">{{ $teacher->name }}</div>
                    </div>
                    <div class="col-span-2">
                        @if($teacher->user_id)
                            <span class="badge badge-primary font-mono">{{ $teacher->user_id }}</span>
                        @else
                            <span class="text-gray-400">Belum digenerate</span>
                        @endif
                    </div>
                    <div class="col-span-3">
                        @if($teacher->user_id)
                            <canvas id="qr-{{ $teacher->id }}" class="mx-auto md:mx-0"></canvas>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </div>
                    <div class="col-span-2 text-right">
                        <div class="flex justify-end space-x-2">
                            @if($teacher->user_id)
                                <a 
                                    id="download-{{ $teacher->id }}"
                                    download="{{ $teacher->user_id }}.png"
                                    class="text-green-500 hover:text-green-700 p-2 rounded-full hover:bg-green-50 transition"
                                    title="Download QR"
                                >
                                    <i class="fas fa-download"></i>
                                </a>
                                <button 
                                    onclick="confirmDelete({{ $teacher->id }})"
                                    class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition"
                                    title="Hapus"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-400">
                    <i class="fas fa-user-slash text-4xl mb-3"></i>
                    <p class="text-lg">Belum ada data guru</p>
                    <p class="text-sm mt-2">Silakan tambahkan guru terlebih dahulu</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Delete Confirmation Modal --}}
        <div id="deleteModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-sm mx-4 modal-enter">
                <div class="p-6 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Penghapusan</h2>
                    <p class="text-gray-600 mb-6">Anda yakin ingin menghapus data guru ini? Data yang dihapus tidak dapat dikembalikan.</p>
                    
                    <form id="deleteForm" method="POST">
                        @csrf @method('DELETE')
                        <div class="flex justify-center gap-3">
                            <button 
                                type="button" 
                                onclick="closeDeleteModal()" 
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                            >
                                Batal
                            </button>
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center gap-2"
                            >
                                <i class="fas fa-trash-alt"></i>
                                Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @foreach ($teachers as $teacher)
                    @if($teacher->user_id)
                        const qr{{ $teacher->id }} = new QRious({
                            element: document.getElementById('qr-{{ $teacher->id }}'),
                            value: "{{ $teacher->user_id }}",
                            size: 100,
                        });

                        const downloadLink{{ $teacher->id }} = document.getElementById('download-{{ $teacher->id }}');
                        downloadLink{{ $teacher->id }}.href = document.getElementById('qr-{{ $teacher->id }}').toDataURL("image/png");
                    @endif
                @endforeach
            });

            function confirmDelete(id) {
                const form = document.getElementById('deleteForm');
                form.action = `/teachers/delete/${id}`;
                document.getElementById('deleteModal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                if (event.target === document.getElementById('deleteModal')) {
                    closeDeleteModal();
                }
            }
        </script>
    </div>
</body>
</html>