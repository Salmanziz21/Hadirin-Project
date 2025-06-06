<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Manajemen Guru</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/teacher.css') !!}">
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
                <i class="fas fa-chalkboard-teacher mr-2"></i>Manajemen Guru
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
        <form action="{{ route('teacher.search') }}" method="GET" class="flex items-center gap-3 bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100">
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

       <!-- Teachers List -->
<div class="bg-white rounded-xl shadow-sm overflow-x-auto border border-gray-100">
    <!-- Table Header -->
    <div class="grid grid-cols-12 min-w-[700px] gap-4 bg-sky-50 px-6 py-3 border-b border-gray-200">
        <div class="col-span-2 font-medium text-sky-800">NIP</div>
        <div class="col-span-3 font-medium text-sky-800">Nama Guru</div>
        <div class="col-span-3 font-medium text-sky-800">Jabatan</div>
        <div class="col-span-2 font-medium text-sky-800">Jenis Kelamin</div>
        <div class="col-span-2 font-medium text-sky-800 text-right">Aksi</div>
    </div>

    <!-- Teachers Data -->
    <div class="divide-y divide-gray-100">
        @forelse($teachers as $teacher)
        <div class="teacher-card grid grid-cols-12 min-w-[700px] gap-4 items-center px-4 md:px-6 py-4 hover:bg-sky-50/50">
            <div class="col-span-2">
                <div class="font-medium text-gray-700">{{ $teacher->nip ?: '-' }}</div>
            </div>
            <div class="col-span-3">
                <div class="font-medium">{{ $teacher->name }}</div>
            </div>
            <div class="col-span-3">
                <div class="text-sky-600 flex items-center">
                    @if($teacher->type)
                        <span class="bg-sky-100 text-sky-800 text-xs px-2 py-1 rounded-full">{{ $teacher->type->name }}</span>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="col-span-2">
                <div class="text-sky-600">
                    @if($teacher->gender === 'laki-laki')
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                            <i class="fas fa-mars mr-1"></i>Laki-laki
                        </span>
                    @elseif($teacher->gender === 'perempuan')
                        <span class="bg-pink-100 text-pink-800 text-xs px-2 py-1 rounded-full">
                            <i class="fas fa-venus mr-1"></i>Perempuan
                        </span>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="col-span-2 text-right">
                <div class="flex justify-end space-x-2">
                    <button 
                        onclick="openEditModal({{ $teacher->id }}, '{{ $teacher->name }}', {{ $teacher->type_id ?? 'null' }}, '{{ $teacher->gender }}', '{{ $teacher->nip }}')"
                        class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50 transition"
                        title="Edit"
                    >
                        <i class="fas fa-edit"></i>
                    </button>
                    <button 
                        onclick="confirmDelete({{ $teacher->id }})"
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
            <i class="fas fa-user-slash text-4xl mb-3"></i>
            <p class="text-lg">Belum ada data guru</p>
            <p class="text-sm mt-2">Klik tombol tambah di bawah untuk menambahkan guru baru</p>
        </div>
        @endforelse
    </div>
</div>

    {{-- Add Button --}}
    <button 
        onclick="openCreateModal()" 
        class="fixed bottom-6 right-6 bg-sky-600 hover:bg-sky-700 text-white p-4 rounded-full shadow-lg floating-btn"
        title="Tambah Guru Baru"
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

                <form method="POST" action="{{ route('teacher.store') }}" id="modal-form">
                    @csrf
                    <input type="hidden" name="id" id="teacher-id"/>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                            <input 
                                type="number" 
                                name="nip" 
                                id="teacher-nip" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent"
                                placeholder="Masukkan NIP"
                            />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="teacher-name" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent"
                                placeholder="Masukkan nama lengkap"
                            />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                            <select 
                                name="type_id" 
                                id="teacher-type" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent"
                            >
                                @foreach(\App\Models\Type::all() as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center space-x-2 border border-gray-200 rounded-lg p-3 hover:bg-sky-50 cursor-pointer">
                                    <input 
                                        type="radio" 
                                        name="gender" 
                                        value="laki-laki" 
                                        class="text-sky-600 focus:ring-sky-500"
                                    >
                                    <span class="text-gray-700">
                                        <i class="fas fa-mars text-blue-500 mr-1"></i> Laki-laki
                                    </span>
                                </label>
                                <label class="flex items-center space-x-2 border border-gray-200 rounded-lg p-3 hover:bg-sky-50 cursor-pointer">
                                    <input 
                                        type="radio" 
                                        name="gender" 
                                        value="perempuan" 
                                        class="text-sky-600 focus:ring-sky-500"
                                    >
                                    <span class="text-gray-700">
                                        <i class="fas fa-venus text-pink-500 mr-1"></i> Perempuan
                                    </span>
                                </label>
                            </div>
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
        const modal = document.getElementById('modal');
        const form = document.getElementById('modal-form');
        const title = document.getElementById('modal-title');
        const nipInput = document.getElementById('teacher-nip');
        const nameInput = document.getElementById('teacher-name');
        const typeSelect = document.getElementById('teacher-type');
        const genderRadios = document.querySelectorAll('input[name="gender"]');
        const teacherId = document.getElementById('teacher-id');

        function openCreateModal() {
            title.textContent = 'Tambah Data Guru';
            form.action = "{{ route('teacher.store') }}";
            form.reset();
            teacherId.value = '';
            modal.classList.remove('hidden');
        }

        function openEditModal(id, name, typeId, gender, nip = '') {
            title.textContent = 'Edit Data Guru';
            form.action = `/teachers/update/${id}`;
            nipInput.value = nip;
            nameInput.value = name;
            typeSelect.value = typeId;
            
            // Set gender radio
            genderRadios.forEach(radio => {
                radio.checked = (radio.value === gender);
            });
            
            teacherId.value = id;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        function confirmDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = `/teachers/delete/${id}`;
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

</body>
</html>