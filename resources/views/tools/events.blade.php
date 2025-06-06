<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Daftar Kegiatan</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/event.css') !!}">
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
                <i class="fas fa-calendar-alt mr-2"></i>Daftar Kegiatan
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
        <form action="{{ route('event.search') }}" method="GET" class="flex items-center gap-3 bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    class="block w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent" 
                    placeholder="Cari judul kegiatan atau deskripsi..."
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

        <!-- Events List -->
        <div class="bg-white rounded-xl shadow-sm overflow-x-auto border border-gray-100">
            <!-- Table Header -->
            <div class="grid grid-cols-12 min-w-[800px] gap-4 bg-sky-50 px-6 py-3 border-b border-gray-200">
                <div class="col-span-1 font-medium text-sky-800">No</div>
                <div class="col-span-4 font-medium text-sky-800">Judul Kegiatan</div>
                <div class="col-span-3 font-medium text-sky-800">Tanggal</div>
                <div class="col-span-2 font-medium text-sky-800">Deskripsi</div>
                <div class="col-span-2 font-medium text-sky-800 text-right">Aksi</div>
            </div>

            <!-- Events Data -->
            <div class="divide-y divide-gray-100">
                @forelse($events as $index => $event)
                <div class="event-card grid grid-cols-12 min-w-[800px] gap-4 items-center px-4 md:px-6 py-4 hover:bg-sky-50/50">
                    <div class="col-span-1">
                        <div class="font-medium text-gray-700">{{ $index + 1 }}</div>
                    </div>
                    <div class="col-span-4">
                        <div class="font-medium">{{ $event->title }}</div>
                    </div>
                    <div class="col-span-3">
                        @if($event->date)
                            <div class="flex items-center gap-2">
                                <span class="badge badge-secondary">
                                    <i class="fas fa-calendar-day mr-1"></i>
                                    {{ $event->date->format('d-m-Y') }}
                                </span>
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </div>
                    <div class="col-span-2">
                        <div class="text-gray-600 truncate">
                            {{ $event->description ?: '-' }}
                        </div>
                    </div>
                    <div class="col-span-2 text-right">
                        <div class="flex justify-end space-x-2">
                            <button 
                                onclick="openEditModal({{ $event->id }}, '{{ addslashes($event->title) }}', '{{ $event->date ? $event->date->format('Y-m-d') : '' }}', '{{ addslashes($event->description) }}')"
                                class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50 transition"
                                title="Edit"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button 
                                onclick="confirmDelete({{ $event->id }})"
                                class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition"
                                title="Hapus"
                            >
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-400">
                    <i class="fas fa-calendar-times text-4xl mb-3"></i>
                    <p class="text-lg">Belum ada data kegiatan</p>
                    <p class="text-sm mt-2">Klik tombol tambah di bawah untuk menambahkan kegiatan baru</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Add Button --}}
        <button 
            onclick="openCreateModal()" 
            class="fixed bottom-6 right-6 bg-sky-600 hover:bg-sky-700 text-white p-4 rounded-full shadow-lg floating-btn"
            title="Tambah Kegiatan Baru"
        >
            <i class="fas fa-plus text-xl"></i>
        </button>

        {{-- Create/Edit Modal --}}
        <div id="modal" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 modal-enter">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 id="modal-title" class="text-xl font-semibold text-gray-800"></h2>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    @if ($errors->any())
                    <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('event.store') }}" id="modal-form">
                        @csrf
                        <input type="hidden" name="id" id="event-id"/>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kegiatan</label>
                                <input 
                                    type="text" 
                                    name="title" 
                                    id="event-title" 
                                    required 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent"
                                    placeholder="Masukkan judul kegiatan"
                                />
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                <input 
                                    type="date" 
                                    name="date" 
                                    id="event-date" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent"
                                />
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea
                                    name="description" 
                                    id="event-description" 
                                    rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent"
                                    placeholder="Masukkan deskripsi kegiatan (opsional)"
                                ></textarea>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end gap-3">
                            <button 
                                type="button" 
                                onclick="closeModal()" 
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                            >
                                Batal
                            </button>
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition flex items-center gap-2"
                            >
                                <i class="fas fa-save"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
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
                    <p class="text-gray-600 mb-6">Anda yakin ingin menghapus kegiatan ini? Data yang dihapus tidak dapat dikembalikan.</p>
                    
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
            const modal = document.getElementById('modal');
            const form = document.getElementById('modal-form');
            const title = document.getElementById('modal-title');
            const eventTitleInput = document.getElementById('event-title');
            const eventDateInput = document.getElementById('event-date');
            const eventDescInput = document.getElementById('event-description');
            const eventId = document.getElementById('event-id');

            function openCreateModal() {
                title.textContent = 'Tambah Kegiatan';
                form.action = "{{ route('event.store') }}";
                form.reset();
                eventId.value = '';
                modal.classList.remove('hidden');
            }

            function openEditModal(id, eventTitle, date, description) {
                title.textContent = 'Edit Kegiatan';
                form.action = `/events/update/${id}`;
                eventTitleInput.value = eventTitle;
                eventDateInput.value = date;
                eventDescInput.value = description;
                eventId.value = id;
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            function confirmDelete(id) {
                const form = document.getElementById('deleteForm');
                form.action = `/events/delete/${id}`;
                document.getElementById('deleteModal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }

            // Close modals when clicking outside
            window.onclick = function(event) {
                if (event.target === modal) {
                    closeModal();
                }
                if (event.target === document.getElementById('deleteModal')) {
                    closeDeleteModal();
                }
            }
        </script>
    </div>
</body>
</html>