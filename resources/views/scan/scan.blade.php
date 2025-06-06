<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Scan QR Code Presensi</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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
          }
        }
      }
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="w-full min-h-screen bg-gradient-to-br from-primary-50 to-primary-100">
  <div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header Section -->
    <header class="mb-8">
      <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <a href="/" class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-sm hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 w-fit">
          <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
          </svg>
          <span class="font-medium">Kembali</span>
        </a>
        <div class="text-center md:text-right">
          <h1 class="text-2xl md:text-3xl font-bold text-primary-800">
            <i class="fas fa-qrcode mr-2"></i>Scan QR Code Presensi
          </h1>
          <p class="text-primary-600 mt-1">Presensi mudah dengan pemindai QR Code</p>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="bg-white rounded-xl shadow-lg overflow-hidden">
      <!-- Scanner Section -->
      <div class="p-6 border-b border-gray-200">
        @if(session('error'))
          <div class="mb-6 p-4 bg-red-50 text-red-700 border-l-4 border-red-500 rounded">
            <div class="flex items-center">
              <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
              <div>
                <p class="font-medium">Gagal!</p>
                <p class="text-sm">{{ session('error') }}</p>
              </div>
            </div>
          </div>
        @endif

        <div class="mb-6">
          <h2 class="text-xl font-semibold text-gray-800 mb-2">Pemindai QR Code</h2>
          <p class="text-gray-600">Arahkan kamera ke QR Code untuk melakukan presensi</p>
        </div>

        <!-- Camera Controls -->
        <div class="mb-6">
          <label for="cameraSelect" class="block text-sm font-medium text-gray-700 mb-2">Pilih Kamera</label>
          <div class="flex flex-col sm:flex-row gap-3">
            <select id="cameraSelect" class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 bg-white">
              <option value="">-- Pilih Kamera --</option>
            </select>
            <button onclick="startScan()" id="scanButton" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center justify-center gap-2">
              <i class="fas fa-play"></i>
              <span>Mulai Scan</span>
            </button>
          </div>
        </div>

        <!-- QR Scanner Area -->
        <div class="mb-6">
          <div id="reader" class="relative border-2 border-dashed border-primary-300 rounded-xl w-full max-w-md aspect-square mx-auto overflow-hidden bg-gray-50 flex items-center justify-center">
            <div class="text-center text-gray-400 p-6">
              <i class="fas fa-camera text-5xl mb-3"></i>
              <p class="font-medium">Kamera belum diaktifkan</p>
              <p class="text-sm mt-1">Pilih kamera dan klik "Mulai Scan"</p>
            </div>
          </div>
          
          <!-- Scan Indicator -->
          <div id="scanIndicator" class="mt-4 flex justify-center">
            <div class="inline-flex items-center px-4 py-2 bg-primary-100 text-primary-800 rounded-full text-sm font-medium">
              <i class="fas fa-info-circle mr-2"></i>
              <span id="scanStatusText">Menunggu untuk memindai</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Result Section -->
      <div class="p-6">
        <!-- Form Presensi -->
        <form id="presenceForm" method="POST" action="{{ route('scan.process') }}" class="hidden">
          @csrf
          <input type="hidden" name="user_id" id="user_id">

          <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <i class="fas fa-user-check mr-2 text-primary-600"></i>
              Form Presensi
            </h3>
            
            <div class="mb-4">
              <label for="statusSelect" class="block text-sm font-medium text-gray-700 mb-2">Status Kehadiran</label>
              <select name="status" id="statusSelect" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 bg-white">
                <option value="hadir" selected>Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="tidak hadir">Tidak Hadir</option>
              </select>
            </div>
          </div>

          <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-colors duration-200">
            <i class="fas fa-check"></i>
            <span>Simpan Presensi</span>
          </button>
        </form>

        <!-- Scan Result Placeholder -->
        <div id="resultPlaceholder" class="text-center py-8">
          <div class="inline-block p-4 bg-primary-50 rounded-full mb-4">
            <i class="fas fa-qrcode text-3xl text-primary-600"></i>
          </div>
          <h3 class="text-lg font-medium text-gray-700 mb-1">Hasil Scan akan muncul di sini</h3>
          <p class="text-gray-500">Silakan scan QR Code untuk mengisi presensi</p>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="mt-8 text-center text-sm text-gray-500">
      <p>Sistem Presensi Digital © {{ date('Y') }}</p>
    </footer>
  </div>

  <script>
    let html5QrCode;
    let isScanning = false;
    let scanInProgress = false;

    // Camera detection
    Html5Qrcode.getCameras().then(devices => {
      const select = document.getElementById("cameraSelect");
      if (devices.length === 0) {
        select.innerHTML = '<option value="" disabled>Tidak ada kamera yang ditemukan</option>';
        document.getElementById('scanButton').disabled = true;
      } else {
        devices.forEach((device, index) => {
          const option = document.createElement("option");
          option.value = device.id;
          option.text = device.label || `Kamera ${index + 1}`;
          select.appendChild(option);
        });
      }
    }).catch(err => {
      console.error("Gagal mendapatkan kamera:", err);
      document.getElementById("cameraSelect").innerHTML = '<option value="" disabled>Gagal mengakses kamera</option>';
      document.getElementById('scanButton').disabled = true;
    });

    function startScan() {
      const camId = document.getElementById("cameraSelect").value;
      if (!camId) {
        showAlert('error', 'Pilih kamera terlebih dahulu');
        return;
      }

      if (isScanning) {
        stopScan();
        setTimeout(() => startScanning(camId), 500);
      } else {
        startScanning(camId);
      }
    }

    function startScanning(camId) {
      const readerElement = document.getElementById("reader");
      readerElement.innerHTML = "";

      html5QrCode = new Html5Qrcode("reader");
      isScanning = true;
      scanInProgress = false;

      // Update UI
      document.getElementById('scanButton').innerHTML = '<i class="fas fa-stop"></i><span>Stop Scan</span>';
      document.getElementById('scanButton').classList.remove('bg-primary-600', 'hover:bg-primary-700');
      document.getElementById('scanButton').classList.add('bg-amber-600', 'hover:bg-amber-700');
      document.getElementById('scanStatusText').textContent = 'Memindai QR Code...';
      document.getElementById("presenceForm").classList.add("hidden");
      document.getElementById("resultPlaceholder").classList.remove("hidden");
      
      const containerWidth = readerElement.offsetWidth;
      const qrboxSize = Math.min(300, containerWidth - 40);

      html5QrCode.start(
        camId,
        { 
          fps: 10, 
          qrbox: { width: qrboxSize, height: qrboxSize }, 
          aspectRatio: 1.0,
          experimentalFeatures: {
            useBarCodeDetectorIfSupported: true
          }
        },
        decodedText => handleScanSuccess(decodedText),
        errorMessage => {}
      ).catch(err => {
        console.error("Gagal memulai scanner:", err);
        showAlert('error', 'Gagal memulai kamera');
        resetScannerUI();
      });
    }

    function stopScan() {
      if (html5QrCode && isScanning) {
        html5QrCode.stop().then(() => {
          isScanning = false;
          resetScannerUI();
        }).catch(err => {
          console.error("Gagal menghentikan scanner:", err);
        });
      }
    }

    function resetScannerUI() {
      document.getElementById("reader").innerHTML = `
        <div class="text-center text-gray-400 p-6">
          <i class="fas fa-camera text-5xl mb-3"></i>
          <p class="font-medium">Kamera belum diaktifkan</p>
          <p class="text-sm mt-1">Pilih kamera dan klik "Mulai Scan"</p>
        </div>
      `;
      
      document.getElementById('scanButton').innerHTML = '<i class="fas fa-play"></i><span>Mulai Scan</span>';
      document.getElementById('scanButton').classList.remove('bg-amber-600', 'hover:bg-amber-700');
      document.getElementById('scanButton').classList.add('bg-primary-600', 'hover:bg-primary-700');
      document.getElementById('scanStatusText').textContent = 'Menunggu untuk memindai';
    }

    function handleScanSuccess(decodedText) {
      if (scanInProgress) return;
      scanInProgress = true;

      // Show success UI
      document.getElementById('scanStatusText').textContent = 'QR Code berhasil dipindai';
      document.getElementById('scanStatusText').parentElement.classList.remove('bg-primary-100', 'text-primary-800');
      document.getElementById('scanStatusText').parentElement.classList.add('bg-green-100', 'text-green-800');
      
      // Update result UI
      document.getElementById("resultPlaceholder").classList.add("hidden");
      document.getElementById("user_id").value = decodedText;
      document.getElementById("presenceForm").classList.remove("hidden");

      // Scroll to form
      document.getElementById("presenceForm").scrollIntoView({ behavior: 'smooth' });

      stopScan();
    }

    function showAlert(type, message) {
      const alertDiv = document.createElement('div');
      alertDiv.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 flex items-start ${type === 'error' ? 'bg-red-50 text-red-700 border-l-4 border-red-500' : 'bg-green-50 text-green-700 border-l-4 border-green-500'}`;
      alertDiv.innerHTML = `
        <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'} text-xl mr-3 mt-1"></i>
        <div>
          <p class="font-medium">${type === 'error' ? 'Error' : 'Success'}</p>
          <p class="text-sm">${message}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="ml-4 text-gray-500 hover:text-gray-700">
          <i class="fas fa-times"></i>
        </button>
      `;
      document.body.appendChild(alertDiv);
      
      setTimeout(() => {
        alertDiv.remove();
      }, 5000);
    }

    window.addEventListener('beforeunload', () => {
      if (html5QrCode && isScanning) {
        html5QrCode.stop();
      }
    });
  </script>
</body>
</html>
