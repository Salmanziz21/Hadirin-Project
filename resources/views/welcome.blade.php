<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/style.css') !!}">
    <title>Hadirin</title>

</head>

<body class="bg-gray-50">

    <!-- header -->
    <div class="w-full rounded-b-4xl bg-gradient-to-r from-blue-600 to-cyan-500 p-6 pb-16 shadow-md">

        {{-- Brand --}}
        <div class="flex justify-between items-center">
            <div class="text-white font-bold text-xl tracking-wider flex items-center">
                <i class="fas fa-user-check mr-2"></i> HADIRIN
            </div>
            {{-- Icons --}}
            <div class="inline-flex space-x-3">
                <div class="w-8 h-8 bg-yellow-300 bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class=" text-white text-sm"></i>
                </div>
                <div class="w-8 h-8 bg-green-500 bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class=" text-white text-sm"></i>
                </div>
            </div>
        </div>

        {{-- Profile --}}
        <div class="w-full my-4 text-white text-center">
            <div class="mx-auto w-24 h-24 bg-white bg-opacity-20 rounded-full p-1 shadow-inner">
                <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-full h-full rounded-full object-cover border-2 border-white border-opacity-30">
            </div>
            <p class="text-xl tracking-wider mt-3 font-medium">SMKN 1</p>
            <p class="text-2xl font-bold">Kota Bengkulu</p>
        </div>

        {{-- Tabs --}}
        <div class="w-full grid place-items-center px-4 pt-6">
            <div class="inline-flex flex-wrap gap-4 md:gap-8 justify-center">
                <button id="b1" onclick="switchTab(1)" class="tab-button active text-white text-lg px-4 py-2 font-medium">
                    <i class="fas fa-tools mr-2"></i>Tools
                </button>
                <button id="b2" onclick="switchTab(2)" class="tab-button text-white text-lg px-4 py-2 font-medium opacity-70">
                    <i class="fas fa-print mr-2"></i>Prints
                </button>
                <button id="b3" onclick="switchTab(3)" class="tab-button text-white text-lg px-4 py-2 font-medium opacity-70">
                    <i class="fas fa-info-circle mr-2"></i>Info
                </button>
            </div>
        </div>
    </div>

    <!-- content -->
    <div class="w-full h-fit px-6 py-8 -mt-10">
        <!-- tab1 -->
        <div id="tab1" class="grid grid-cols-2 gap-5 popIn">
            <a href="/teachers" class="card-hover shadow-lg rounded-xl h-40 bg-white flex flex-col items-center justify-center text-blue-600 border border-gray-100">
                <div class="w-16 h-16 mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                </div>
                <p class="text-center font-medium text-sm md:text-base">Input Anggota</p>
                <p class="text-xs text-gray-500 mt-1">Tambahkan data anggota baru</p>
            </a>
            
            <a href="/events" class="card-hover shadow-lg rounded-xl h-40 bg-white flex flex-col items-center justify-center text-blue-600 border border-gray-100">
                <div class="w-16 h-16 mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-plus text-blue-600 text-xl"></i>
                </div>
                <p class="text-center font-medium text-sm md:text-base">Input Kegiatan</p>
                <p class="text-xs text-gray-500 mt-1">Buat jadwal kegiatan baru</p>
            </a>
            
            <a href="/generate" class="card-hover shadow-lg rounded-xl h-40 bg-white flex flex-col items-center justify-center text-blue-600 border border-gray-100">
                <div class="w-16 h-16 mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-id-card text-blue-600 text-xl"></i>
                </div>
                <p class="text-center font-medium text-sm md:text-base">Generate ID</p>
                <p class="text-xs text-gray-500 mt-1">Buat kartu anggota</p>
            </a>
            
            <a href="/scan" class="card-hover shadow-lg rounded-xl h-40 bg-white flex flex-col items-center justify-center text-blue-600 border border-gray-100">
                <div class="w-16 h-16 mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-qrcode text-blue-600 text-xl"></i>
                </div>
                <p class="text-center font-medium text-sm md:text-base">Scan Kehadiran</p>
                <p class="text-xs text-gray-500 mt-1">Presensi anggota</p>
            </a>
        </div>

        <!-- tab2 -->
        <div id="tab2" class="grid grid-cols-2 gap-5 popIn hidden">
            <a href="/print/harian" class="card-hover shadow-lg rounded-xl h-40 bg-white flex flex-col items-center justify-center text-blue-600 border border-gray-100 col-span-2">
                <div class="w-16 h-16 mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                </div>
                <p class="text-center font-medium text-sm md:text-base">Kehadiran Harian</p>
                <p class="text-xs text-gray-500 mt-1">Cetak laporan harian</p>
            </a>
            
            <a href="/print/bulanan" class="card-hover shadow-lg rounded-xl h-40 bg-white flex flex-col items-center justify-center text-blue-600 border border-gray-100">
                <div class="w-16 h-16 mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-export text-blue-600 text-xl"></i>
                </div>
                <p class="text-center font-medium text-sm md:text-base">Kehadiran Bulanan</p>
                <p class="text-xs text-gray-500 mt-1">Cetak laporan bulanan</p>
            </a>
            
            <a href="/card-print" class="card-hover shadow-lg rounded-xl h-40 bg-white flex flex-col items-center justify-center text-blue-600 border border-gray-100">
                <div class="w-16 h-16 mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-id-badge text-blue-600 text-xl"></i>
                </div>
                <p class="text-center font-medium text-sm md:text-base">Cetak ID Anggota</p>
                <p class="text-xs text-gray-500 mt-1">Cetak semua kartu anggota</p>
            </a>
        </div>

        <!-- tab3 -->
        <div id="tab3" class="popIn hidden">
            <div class="card-hover shadow-lg rounded-xl bg-white p-6 border border-gray-100">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1">Informasi Aplikasi</h3>
                    <p class="text-blue-600 font-medium">SMKN 1 Kota Bengkulu</p>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-blue-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-800">Versi Aplikasi 1.0.0</p>
                            <p class="text-xs text-gray-500">Terakhir diperbarui: 6 Juni 2025</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-shield text-blue-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-800">Hak Akses</p>
                            <p class="text-xs text-gray-500">Digunakan oleh guru piket</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-headset text-blue-600 text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-800">Bantuan</p>
                            <p class="text-xs text-gray-500">Hubungi tim IT untuk pertanyaan</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-500">© 2025 Hadirin App - SMKN 1 Kota Bengkulu</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        switchTab(1);

        function switchTab(idTab) {
            for (let a = 1; a <= 3; a++) {
                const btn = document.getElementById('b' + a);
                const tab = document.getElementById('tab' + a);
                
                if (idTab == a) {
                    btn.classList.add('active');
                    btn.classList.remove('opacity-70');
                    tab.classList.remove('hidden');
                } else {
                    btn.classList.remove('active');
                    btn.classList.add('opacity-70');
                    tab.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>