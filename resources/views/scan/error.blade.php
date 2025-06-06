{{-- resources/views/presensi/error.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gagal Presensi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="w-full min-h-screen p-6 bg-gray-100">

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
            
        </div>

  <!-- Main Content -->
  <main class="flex-grow max-w-2xl mx-auto p-4 w-full">
    <div class="bg-white rounded-xl shadow-md p-6 text-center">
      
      <!-- Error Message Box -->
      <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
        <h2 class="text-xl font-semibold mb-2">
          {{ $message ?? 'Terjadi kesalahan saat melakukan presensi.' }}
        </h2>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-center space-x-4">
        <a href="{{ route('scan.show') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
          <i class="fas fa-qrcode mr-2"></i> Coba Lagi
        </a>
        <a href="{{ url('/') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
          <i class="fas fa-home mr-2"></i> Beranda
        </a>
      </div>
    </div>
  </main>

</body>
</html>
