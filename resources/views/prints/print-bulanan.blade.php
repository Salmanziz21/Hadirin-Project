<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cetak Kehadiran Bulanan</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            @media print {
                body {
                    margin: 0;
                    padding: 0;
                    font-size: 12pt;
                    background: white;
                }
                .no-print {
                    display: none !important;
                }
                .print-header {
                    display: block !important;
                    text-align: center;
                    margin-bottom: 20px;
                }
                header {
                    display: none;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                td,
                th {
                    padding: 8px 12px;
                    border: 1px solid #e2e8f0;
                }
            }

            @page {
                size: A4 portrait;
                margin: 15mm;
            }

            .action-btn {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 16px;
                border-radius: 6px;
                font-weight: 500;
                transition: all 0.2s ease;
                cursor: pointer;
            }

            .action-btn:hover {
                transform: translateY(-1px);
            }

            @media (max-width: 640px) {
                .action-text {
                    display: none;
                }
                .action-btn {
                    padding: 8px 12px;
                }
            }
        </style>
    </head>
    <body class="w-full min-h-screen p-6 bg-gray-100">

        <!-- Header Web -->
        <header class="shadow-sm no-print">
            <div
                class="max-w-7xl mx-auto px-4 py-3 sm:py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <a
                        href="/"
                        class="inline-flex items-center gap-2 mb-6 px-4 py-2 bg-white border border-sky-200 rounded-lg shadow hover:bg-sky-50 hover:text-sky-700 transition">
                        <svg
                            class="w-5 h-5 text-sky-600"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewbox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="font-medium">Kembali</span>
                    </a>
                    <h1 class="text-2xl text-center font-bold mb-6  text-sky-700">Rekap Kehadiran Guru Bulanan</h1>
                </div>
            </div>
        </header>

        <div class="print-header hidden bg-white py-4 border-b-2 border-blue-600">
            <div class="text-center">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo Sekolah"
                    class="h-16 mx-auto mb-2">
                <h1 class="text-xl font-bold">SMK NEGERI 1 KOTA BENGKULU</h1>
                <p class="text-sm">Jl. Jati No 41, Kelurahan Padang Jati<br>Kecamatan Ratu Samban, Kota Bengkulu 38222</p>
                <h2 class="text-lg font-semibold mt-4">REKAPITULASI KEHADIRAN BULANAN GURU</h2>
                <p class="text-md font-medium text-blue-600">{{ $month }}</p>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="max-w-7xl mx-auto p-4 sm:p-6">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50 no-print">
                    <div
                        class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="text-center md:text-left">
                            <h2 class="text-xl font-semibold text-gray-800">REKAP KEHADIRAN GURU BULANAN</h2>
                            <p class="text-gray-600">SMKN 1 Kota Bengkulu</p>
                            <p class="text-md font-medium text-blue-600">{{ $month }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                onclick="window.print()"
                                class="action-btn bg-blue-600 text-white hover:bg-blue-700">
                                <i class="fas fa-print"></i>
                                <span class="action-text">Cetak</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="p-4 sm:p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nama Guru</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">NIP</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Waktu</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($attendances as $index => $attendance)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $attendance->teacher->name }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $attendance->teacher->nip }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($attendance->date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($attendance->time)->format('H:i:s') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full
                    {{ $attendance->status === 'hadir' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $attendance->status === 'izin' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $attendance->status === 'sakit' ? 'bg-purple-100 text-purple-800' : '' }}
                    {{ $attendance->status === 'tidak hadir' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-sm text-gray-500 py-4">Tidak ada data kehadiran guru bulan ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    @if($attendances->count() > 0)
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="text-sm text-gray-600">
                                Total Kehadiran Guru:
                                <span class="font-semibold">{{ $attendances->count() }}
                                    data</span>
                            </div>
                            <div class="text-sm text-gray-500">
                                Dicetak pada:
                                {{ now()->format('d-m-Y H:i:s') }}
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Script Print Behavior -->
        <script>
            function beforePrint() {
                document
                    .querySelectorAll('.hover\\:bg-gray-50')
                    .forEach(el => el.classList.remove('hover:bg-gray-50'));
                document
                    .querySelector('.print-header')
                    .classList
                    .remove('hidden');
            }

            function afterPrint() {
                document
                    .querySelectorAll('.hover\\:bg-gray-50')
                    .forEach(el => el.classList.add('hover:bg-gray-50'));
                document
                    .querySelector('.print-header')
                    .classList
                    .add('hidden');
            }

            if (window.matchMedia) {
                const mediaQueryList = window.matchMedia('print');
                mediaQueryList.addListener(mql => {
                    mql.matches
                        ? beforePrint()
                        : afterPrint();
                });
            }

            window.addEventListener('beforeprint', beforePrint);
            window.addEventListener('afterprint', afterPrint);
        </script>
    </body>
</html>
