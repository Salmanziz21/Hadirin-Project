<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Scan QR Code</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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
            
            <h1 class="text-2xl md:text-3xl font-bold text-sky-800">
                <i class="fas fa-id-card mr-2"></i>Scan QR Code Presensi
            </h1>
        </div>

  <!-- Main -->
  <main class="flex-grow max-w-2xl mx-auto p-4 w-full">
    <div class="bg-white rounded-xl shadow p-6">

      @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-400 rounded">
          <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
      @endif

      <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-1">Pemindai QR Code</h2>
        <p class="text-gray-600">Arahkan kamera ke QR Code untuk presensi</p>
      </div>

      <!-- Kamera -->
      <div class="mb-4">
        <label for="cameraSelect" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kamera</label>
        <div class="flex gap-2">
          <select id="cameraSelect" class="flex-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <option value="">-- Pilih Kamera --</option>
          </select>
          <button onclick="startScan()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
            <i class="fas fa-play mr-2"></i> Mulai
          </button>
        </div>
      </div>

      <!-- Area QR Reader -->
      <div id="reader" class="border-4 border-blue-500 rounded-lg w-full max-w-md aspect-square mx-auto overflow-hidden bg-gray-100 flex items-center justify-center">
        <div class="text-center text-gray-500">
          <i class="fas fa-camera text-4xl mb-2"></i>
          <p>Kamera belum diaktifkan</p>
        </div>
      </div>

      <!-- Hasil -->
      <div id="result" class="p-4 mt-4 bg-blue-50 border border-blue-200 text-blue-700 rounded text-center">
        <i class="fas fa-qrcode mr-2"></i> Menunggu scan QR Code...
      </div>

      <!-- Form Presensi -->
      <form id="presenceForm" method="POST" action="{{ route('scan.process') }}" class="hidden mt-6 bg-white p-4 rounded-lg border border-gray-300 shadow">
        @csrf
        <input type="hidden" name="user_id" id="user_id">

        <div class="mb-4">
          <label for="statusSelect" class="block text-sm font-medium text-gray-700 mb-1">Status Kehadiran</label>
          <select name="status" id="statusSelect" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <option value="hadir" selected>Hadir</option>
            <option value="izin">Izin</option>
            <option value="sakit">Sakit</option>
            <option value="tidak hadir">Tidak Hadir</option>
          </select>
        </div>

        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg flex items-center justify-center">
          <i class="fas fa-check mr-2"></i> Simpan Presensi
        </button>
      </form>
    </div>
  </main>

  <script>
    let html5QrCode;
    let isScanning = false;
    let scanInProgress = false;

    Html5Qrcode.getCameras().then(devices => {
      const select = document.getElementById("cameraSelect");
      if (devices.length === 0) {
        select.innerHTML += `<option disabled>Tidak ada kamera ditemukan</option>`;
      } else {
        devices.forEach((device, index) => {
          const option = document.createElement("option");
          option.value = device.id;
          option.text = device.label || `Kamera ${index + 1}`;
          select.appendChild(option);
        });
      }
    }).catch(err => {
      document.getElementById("cameraSelect").innerHTML += `<option disabled>Gagal mengakses kamera</option>`;
      console.error("Gagal mendapatkan kamera:", err);
    });

    function startScan() {
      const camId = document.getElementById("cameraSelect").value;
      if (!camId) {
        alert("Pilih kamera terlebih dahulu");
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

      document.getElementById("result").innerHTML = `
        <i class="fas fa-spinner fa-spin mr-2"></i> Memindai...
      `;
      document.getElementById("presenceForm").classList.add("hidden");

      const containerWidth = readerElement.offsetWidth;
      const qrboxSize = Math.min(300, containerWidth - 40);

      html5QrCode.start(
        camId,
        { fps: 10, qrbox: { width: qrboxSize, height: qrboxSize }, aspectRatio: 1.0 },
        decodedText => handleScanSuccess(decodedText),
        errorMessage => {}
      ).catch(err => {
        console.error("Gagal memulai scanner:", err);
        alert("Gagal memulai kamera");
        isScanning = false;
      });
    }

    function stopScan() {
      if (html5QrCode && isScanning) {
        html5QrCode.stop().then(() => {
          isScanning = false;
          document.getElementById("reader").innerHTML = `
            <div class="text-center text-gray-500">
              <i class="fas fa-camera text-4xl mb-2"></i>
              <p>Kamera belum diaktifkan</p>
            </div>
          `;
        }).catch(err => {
          console.error("Gagal menghentikan scanner:", err);
        });
      }
    }

    function handleScanSuccess(decodedText) {
      if (scanInProgress) return;
      scanInProgress = true;

      document.getElementById("result").innerHTML = `
        <i class="fas fa-check-circle text-green-600 mr-2"></i> QR Code berhasil dipindai
      `;
      document.getElementById("user_id").value = decodedText;
      document.getElementById("presenceForm").classList.remove("hidden");

      stopScan();
    }

    window.addEventListener('beforeunload', () => {
      if (html5QrCode && isScanning) {
        html5QrCode.stop();
      }
    });
  </script>
</body>
</html>
