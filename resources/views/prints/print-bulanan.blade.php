<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Kehadiran Bulanan Guru</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              50: '#f0f9ff',
              100: '#e0f2fe',
              200: '#bae6fd',
              300: '#7dd3fc',
              400: '#38bdf8',
              500: '#0ea5e9',
              600: '#0284c7',
              700: '#0369a1',
              800: '#075985',
              900: '#0c4a6e',
            }
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
      }
      header {
        display: none;
      }
      table {
        width: 100%;
        border-collapse: collapse;
      }
      th, td {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
      }
      .hover\:bg-gray-50 {
        background-color: transparent !important;
      }
      .summary-card {
        page-break-inside: avoid;
      }
    }
    
    @page {
      size: A4 portrait;
      margin: 15mm;
    }
    
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 4px 10px;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: capitalize;
    }
    
    .attendance-row:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }
    
    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>
<body class="w-full min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 font-sans">

  <!-- Web Header -->
  <header class="no-print bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-4">
          <a href="/" class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-sm hover:bg-primary-50 hover:text-primary-700 transition-all">
            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="font-medium">Kembali</span>
          </a>
          <div>
            <h1 class="text-2xl font-bold text-primary-800">Rekap Kehadiran Bulanan Guru</h1>
            <p class="text-gray-600 mt-1">SMKN 1 Kota Bengkulu </p>
          </div>
        </div>
        <button onclick="window.print()" class="flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
          <i class="fas fa-print"></i>
          <span class="hidden sm:inline">Cetak Laporan</span>
        </button>
      </div>
    </div>
  </header>

  <!-- Print Header -->
  <div class="print-header hidden bg-white py-6 border-b-2 border-primary-600">
    <div class="max-w-4xl mx-auto text-center">
      <div class="flex justify-center items-center gap-4 mb-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="h-16">
        <div class="text-left">
          <h1 class="text-2xl font-bold text-gray-800">SMK NEGERI 1 KOTA BENGKULU</h1>
          <p class="text-sm text-gray-600">Jl. Jati No 41, Kelurahan Padang Jati, Kecamatan Ratu Samban</p>
        </div>
      </div>
      <h2 class="text-xl font-semibold text-primary-700 mt-4">REKAPITULASI KEHADIRAN BULANAN GURU</h2>
      <p class="text-lg font-medium text-gray-700 mt-1">{{ $month }}</p>
    </div>
  </div>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <!-- Summary Cards -->
    @if($attendances->count() > 0)
    <div class="no-print grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white p-4 rounded-xl shadow-sm border border-green-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-medium text-green-800 uppercase tracking-wider">Hadir</p>
            <p class="text-2xl font-bold text-green-900 mt-1">{{ $statusCounts['hadir'] ?? 0 }}</p>
          </div>
          <div class="bg-green-100 text-green-800 p-2 rounded-full">
            <i class="fas fa-check-circle text-lg"></i>
          </div>
        </div>
      </div>
      
      <div class="bg-white p-4 rounded-xl shadow-sm border border-blue-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-medium text-blue-800 uppercase tracking-wider">Izin</p>
            <p class="text-2xl font-bold text-blue-900 mt-1">{{ $statusCounts['izin'] ?? 0 }}</p>
          </div>
          <div class="bg-blue-100 text-blue-800 p-2 rounded-full">
            <i class="fas fa-envelope text-lg"></i>
          </div>
        </div>
      </div>
      
      <div class="bg-white p-4 rounded-xl shadow-sm border border-purple-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-medium text-purple-800 uppercase tracking-wider">Sakit</p>
            <p class="text-2xl font-bold text-purple-900 mt-1">{{ $statusCounts['sakit'] ?? 0 }}</p>
          </div>
          <div class="bg-purple-100 text-purple-800 p-2 rounded-full">
            <i class="fas fa-procedures text-lg"></i>
          </div>
        </div>
      </div>
      
      <div class="bg-white p-4 rounded-xl shadow-sm border border-red-100">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-medium text-red-800 uppercase tracking-wider">Tidak Hadir</p>
            <p class="text-2xl font-bold text-red-900 mt-1">{{ $statusCounts['tidak_hadir'] ?? 0 }}</p>
          </div>
          <div class="bg-red-100 text-red-800 p-2 rounded-full">
            <i class="fas fa-times-circle text-lg"></i>
          </div>
        </div>
      </div>
    </div>
    @endif

    <!-- Attendance Report -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
      <!-- Report Header -->
      <div class="px-6 py-4 border-b border-gray-100 no-print">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div>
            <h2 class="text-xl font-semibold text-gray-800">Detail Kehadiran Guru</h2>
            <p class="text-gray-600 mt-1">Total {{ $attendances->count() }} data kehadiran</p>
          </div>
          <div class="text-right">
            <p class="text-sm text-gray-500">Periode</p>
            <p class="text-md font-medium text-primary-600">{{ $month }}</p>
          </div>
        </div>
      </div>

      <!-- Attendance Table -->
      <div class="overflow-hidden">
        <div class="overflow-x-auto scrollbar-hide">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Guru</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse($attendances as $index => $attendance)
              <tr class="attendance-row transition-all hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-semibold text-gray-900">{{ $attendance->teacher->name ?? 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $attendance->teacher->nip ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ \Carbon\Carbon::parse($attendance->date)->format('d-m-Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ \Carbon\Carbon::parse($attendance->time)->format('H:i') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="status-badge
                    @if($attendance->status === 'hadir') bg-green-100 text-green-800 @endif
                    @if($attendance->status === 'izin') bg-blue-100 text-blue-800 @endif
                    @if($attendance->status === 'sakit') bg-purple-100 text-purple-800 @endif
                    @if($attendance->status === 'tidak hadir') bg-red-100 text-red-800 @endif">
                    @if($attendance->status === 'hadir') <i class="fas fa-check-circle"></i> @endif
                    @if($attendance->status === 'izin') <i class="fas fa-envelope"></i> @endif
                    @if($attendance->status === 'sakit') <i class="fas fa-procedures"></i> @endif
                    @if($attendance->status === 'tidak hadir') <i class="fas fa-times-circle"></i> @endif
                    {{ ucfirst($attendance->status) }}
                  </span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="px-6 py-4 text-center">
                  <div class="flex flex-col items-center justify-center py-8">
                    <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Tidak ada data kehadiran untuk bulan ini</p>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Print Summary -->
      @if($attendances->count() > 0)
      <div class="hidden print:block p-6 border-t border-gray-200">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div class="bg-green-50 p-3 rounded border border-green-100 text-center">
            <p class="text-sm font-medium text-green-800">Hadir</p>
            <p class="text-xl font-bold text-green-900">{{ $statusCounts['hadir'] ?? 0 }}</p>
          </div>
          <div class="bg-blue-50 p-3 rounded border border-blue-100 text-center">
            <p class="text-sm font-medium text-blue-800">Izin</p>
            <p class="text-xl font-bold text-blue-900">{{ $statusCounts['izin'] ?? 0 }}</p>
          </div>
          <div class="bg-purple-50 p-3 rounded border border-purple-100 text-center">
            <p class="text-sm font-medium text-purple-800">Sakit</p>
            <p class="text-xl font-bold text-purple-900">{{ $statusCounts['sakit'] ?? 0 }}</p>
          </div>
          <div class="bg-red-50 p-3 rounded border border-red-100 text-center">
            <p class="text-sm font-medium text-red-800">Tidak Hadir</p>
            <p class="text-xl font-bold text-red-900">{{ $statusCounts['tidak_hadir'] ?? 0 }}</p>
          </div>
        </div>
        <div class="mt-4 flex justify-between items-center">
          <p class="text-xs text-gray-500">
            Total Kehadiran: {{ $attendances->count() }} data
          </p>
          <p class="text-xs text-gray-500">
            Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
          </p>
        </div>
      </div>
      @endif
    </div>
  </main>

  <!-- Footer -->
  <footer class="no-print mt-8 py-6 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
      <p>Sistem Presensi Digital SMKN 1 Kota Bengkulu © {{ date('Y') }}</p>
    </div>
  </footer>

  <script>
    function beforePrint() {
      document.querySelector('.print-header').classList.remove('hidden');
    }

    function afterPrint() {
      document.querySelector('.print-header').classList.add('hidden');
    }

    if (window.matchMedia) {
      const mediaQueryList = window.matchMedia('print');
      mediaQueryList.addListener(mql => {
        mql.matches ? beforePrint() : afterPrint();
      });
    }

    window.addEventListener('beforeprint', beforePrint);
    window.addEventListener('afterprint', afterPrint);
  </script>
</body>
</html>
