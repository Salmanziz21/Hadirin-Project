<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Kartu Anggota Guru</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/davidshimjs-qrcodejs@0.0.2/qrcode.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            },
            secondary: {
              500: '#10b981'
            }
          },
          fontFamily: {
            sans: ['Poppins', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    @media print {
      body { 
        background-color: white;
        padding: 0;
        margin: 0;
      }
      .no-print { 
        display: none !important; 
      }
      .id-card {
        page-break-inside: avoid;
        box-shadow: none !important;
        margin: 0;
        border: 1px solid #e5e7eb !important;
        break-inside: avoid;
      }
      @page {
        size: auto;
        margin: 5mm;
      }
    }
    
    .id-card {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 1px solid rgba(229, 231, 235, 0.8);
      position: relative;
      width: 100%;
      aspect-ratio: 1.6 / 1; /* Rectangular aspect ratio */
    }
    
    .id-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .card-header {
      background: linear-gradient(135deg, var(--primary-600) 0%, var(--secondary-500) 100%);
      height: 10px;
      width: 100%;
    }
    
    .card-pattern {
      position: absolute;
      top: 0;
      right: 0;
      width: 120px;
      height: 120px;
      background: radial-gradient(circle, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0) 70%);
    }
    
    .school-logo {
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
      border: 3px solid white;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .qr-container {
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 8px;
      background: white;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      width: 90px;
      height: 90px;
    }
    
    .print-optimized {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    
    .action-btn {
      transition: all 0.2s ease;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .action-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    /* Animation for cards */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .id-card {
      animation: fadeInUp 0.4s ease-out forwards;
      opacity: 0;
    }
    
    .id-card:nth-child(1) { animation-delay: 0.1s; }
    .id-card:nth-child(2) { animation-delay: 0.2s; }
    .id-card:nth-child(3) { animation-delay: 0.3s; }
    .id-card:nth-child(4) { animation-delay: 0.4s; }
    .id-card:nth-child(5) { animation-delay: 0.5s; }
    .id-card:nth-child(n+6) { animation-delay: 0.6s; }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .header-content {
        flex-direction: column;
        gap: 1rem;
      }
      .header-buttons {
        width: 100%;
        justify-content: flex-start;
      }
      .id-card {
        aspect-ratio: 1.4 / 1; /* Slightly different ratio for mobile */
      }
    }
    
    @media (max-width: 480px) {
      .user-details {
        font-size: 14px;
      }
      .qr-container {
        width: 80px;
        height: 80px;
      }
    }
  </style>
</head>
<body class="w-full min-h-screen p-4 sm:p-6 bg-gray-50">

  <!-- Header Section -->
  <header class="rounded-xl shadow-sm p-4 sm:p-6 mb-6 no-print">
    <div class="max-w-7xl mx-auto">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 header-content">
        <div class="flex items-center gap-4">
          <a href="/" class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-sm hover:bg-blue-50 text-blue-600 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="font-medium">Kembali</span>
          </a>
          <div>
            <h1 class="text-xl sm:text-2xl font-bold text-primary-800">Cetak Kartu Anggota Guru</h1>
            <p class="text-gray-600 text-sm sm:text-base">SMKN 1 Kota Bengkulu</p>
          </div>
        </div>
        <div class="flex flex-wrap gap-3 header-buttons">
          <button onclick="window.print()" class="action-btn bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
            <i class="fas fa-print"></i>
            <span>Cetak Semua</span>
          </button>
          <button onclick="printSelected()" class="action-btn bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
            <i class="fas fa-print"></i>
            <span>Cetak Terpilih</span>
          </button>
          <button onclick="selectAllCards()" class="action-btn bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span>Pilih Semua</span>
          </button>
        </div>
      </div>
      <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-gray-600">
        <div class="flex items-center gap-2">
          <i class="fas fa-calendar-alt"></i>
          <span id="print-date">{{ date('d F Y H:i') }}</span>
        </div>
        <div class="flex items-center gap-2">
          <i class="fas fa-users"></i>
          <span>Total: <span id="total-members" class="font-medium">{{ count($teachers) }}</span> guru</span>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto">
    <!-- Cards Container -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 print:grid-cols-2 print:gap-4">
      @forelse ($teachers as $teacher)
      <div class="id-card print-optimized">
        <!-- Card Pattern -->
        <div class="card-pattern"></div>
        
        <!-- Card Header -->
        <div class="card-header"></div>
        
        <!-- Card Content -->
        <div class="p-4 sm:p-5 h-full flex flex-col">
          <div class="flex-grow">
            <!-- School Logo and Name -->
            <div class="flex items-center mb-4 gap-3">
              <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="school-logo h-14 w-14 rounded-full object-cover">
              <div>
                <h3 class="text-lg font-bold text-gray-800">{{ $teacher->name }}</h3>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Guru SMKN 1 Kota Bengkulu</p>
              </div>
            </div>
            
            <div class="flex gap-4 items-start">
              <!-- QR Code -->
              <div class="flex-shrink-0">
                <div class="qr-container" id="qrcode-{{ $teacher->id }}"></div>
              </div>
              
              <!-- User Details -->
              <div class="flex-grow user-details">
                <div class="space-y-2">
                  <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">ID Anggota</p>
                    <p class="text-sm font-semibold text-gray-800 font-mono tracking-wide">{{ $teacher->user_id }}</p>
                  </div>
                  <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $teacher->nip ?? 'N/A' }}</p>
                  </div>
                  @if($teacher->gender)
                  <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</p>
                    <p class="text-sm text-gray-800">{{ $teacher->gender }}</p>
                  </div>
                  @endif
                  @if($teacher->class)
                  <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</p>
                    <p class="text-sm text-gray-800">{{ $teacher->class }}</p>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          
          <!-- Card Footer -->
          <div class="mt-auto px-3 py-2 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
            <div class="flex items-center print:hidden">
              <input type="checkbox" class="card-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500" data-user-id="{{ $teacher->id }}">
              <label class="ml-2 text-xs text-gray-500">Pilih untuk dicetak</label>
            </div>
            <p class="text-xs text-gray-500">ID: {{ $teacher->id }} | {{ date('Y') }}</p>
          </div>
        </div>
      </div>

      <script>
        // Generate QR code for this user
        document.addEventListener('DOMContentLoaded', function() {
          new QRCode(document.getElementById("qrcode-{{ $teacher->id }}"), {
            text: "{{ $teacher->user_id }}",
            width: 80,
            height: 80,
            colorDark: "#1f2937",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
          });
        });
      </script>
      @empty
      <!-- Empty State -->
      <div class="col-span-full text-center py-12">
        <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900">Tidak ada kartu anggota</h3>
        <p class="mt-1 text-sm text-gray-500">Tidak ada data guru yang tersedia untuk ditampilkan.</p>
      </div>
      @endforelse
    </div>
  </main>

  <script>
    // Check if there are any teachers
    document.addEventListener('DOMContentLoaded', function() {
      const totalMembers = parseInt(document.getElementById('total-members').textContent);
      
      // Update print date in real-time
      updatePrintDate();
      setInterval(updatePrintDate, 60000); // Update every minute
    });
    
    function updatePrintDate() {
      const now = new Date();
      const options = { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit' 
      };
      document.getElementById('print-date').textContent = now.toLocaleDateString('id-ID', options);
    }
    
    // Select all cards function (toggle)
    function selectAllCards() {
      const checkboxes = document.querySelectorAll('.card-checkbox');
      const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
      
      checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
      });
      
      // Change button text based on state
      const button = document.querySelector('[onclick="selectAllCards()"]');
      const icon = button.querySelector('i');
      icon.className = allChecked ? 'fas fa-check-circle' : 'fas fa-times-circle';
      button.querySelector('span').textContent = allChecked ? 'Pilih Semua' : 'Batal Pilih';
    }
    
    // Print selected cards function
    function printSelected() {
      const selectedIds = [];
      document.querySelectorAll('.card-checkbox:checked').forEach(checkbox => {
        selectedIds.push(checkbox.dataset.userId);
      });
      
      if (selectedIds.length === 0) {
        alert('Silakan pilih setidaknya satu kartu untuk dicetak');
        return;
      }
      
      // Store original display values
      const originalDisplays = [];
      const cards = document.querySelectorAll('.id-card');
      cards.forEach(card => {
        originalDisplays.push(card.style.display);
      });
      
      // Hide all cards first
      cards.forEach(card => {
        card.style.display = 'none';
      });
      
      // Show only selected cards
      selectedIds.forEach(id => {
        const card = document.querySelector(`.card-checkbox[data-user-id="${id}"]`)?.closest('.id-card');
        if (card) {
          card.style.display = 'block';
        }
      });
      
      // Add a small delay before printing to ensure DOM is updated
      setTimeout(() => {
        window.print();
        
        // After printing, restore original display values
        setTimeout(() => {
          cards.forEach((card, index) => {
            card.style.display = originalDisplays[index] || '';
          });
        }, 500);
      }, 200);
    }
  </script>
</body>
</html>
