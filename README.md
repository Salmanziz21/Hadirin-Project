<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🖼️ Tampilan Aplikasi Hadirin

### 🏠 Halaman Home
![Tampilan tab tools](https://github.com/Salmanziz21/Hadirin-Project/blob/main/public/tools.png?raw=true)
![Tampilan tab prints](https://github.com/Salmanziz21/Hadirin-Project/blob/main/public/prints.png?raw=true)
![Tampilan tab info](https://github.com/Salmanziz21/Hadirin-Project/blob/main/public/info.png?raw=true)

### 👤 Halaman Input Anggota
![Tampilan Halaman Input Anggota](https://github.com/Salmanziz21/Hadirin-Project/blob/main/public/inputanggota.png?raw=true)

### 📝 Halaman Input Kegiatan
![Tampilan Halaman Input Kegiatan](https://github.com/Salmanziz21/Hadirin-Project/blob/main/public/kegiatan.png?raw=true)

### 🆔 Halaman Generate ID Anggota
![Tampilan Halaman Generate ID](https://github.com/Salmanziz21/Hadirin-Project/blob/main/public/generate.png?raw=true)

### 📷 Halaman Scan Kehadiran
![Tampilan Halaman Scan Kehadiran](https://github.com/Salmanziz21/Hadirin-Project/blob/main/public/scan1.png?raw=true)

### 📆 Halaman Print Kehadiran Harian
![Tampilan Halaman Print Kehadiran Harian](https://github.com/Salmanziz21/Hadirin-Project/blob/main/public/kehadiranharian2.png?raw=true)

### 🗓️ Halaman Print Kehadiran Bulanan
![Tampilan Halaman Print Kehadiran Bulanan](https://github.com/Salmanziz21/Hadirin-Project/blob/main/public/kehadiranbulanan1.png?raw=true)

### 🖨️ Halaman Print ID Anggota
![Tampilan Halaman Print ID Anggota](https://github.com/Salmanziz21/Hadirin-Project/blob/main/public/cetakkartuanggota.png?raw=true)


# Hadirin — Aplikasi Absensi Guru

Hadirin adalah aplikasi web absensi guru berbasis Laravel yang memudahkan pencatatan kehadiran dan pengelolaan data guru secara efisien.

---

## ✨ Fitur Utama
- Pencatatan kehadiran guru harian
- Tampilan dashboard untuk user
- Sistem database yang terstruktur

---

## 🚀 Cara Menjalankan Proyek (Tutorial Run)

Ikuti langkah-langkah berikut untuk menjalankan proyek Laravel ini di komputer lokal:

### 1. Clone Repository dari GitHub
```bash
git clone https://github.com/Salmanziz21/Hadirin-Project.git
cd Hadirin-Project
```
### 2. Install Dependency dengan Composer
```bash
composer install
```
### 3. Salin File .env
```bash
copy .env.example .env
```

### 4.Generate Application Key
```bash
php artisan key:generate

```

### 5.Buat dan Konfigurasi Database
## 1.Buat database baru di MySQL, misalnya hadirin.
## 2.Buka file .env dan ubah konfigurasi database sesuai dengan pengaturan lokal Anda:
```bash
DB_DATABASE=hadirin
DB_USERNAME=root
DB_PASSWORD=
```

### 6.  Jalankan Migrasi 
```bash
php artisan migrate

```

### 7.  Jalankan server
```bash
php artisan serve

```

### 8.  Jalankan npm
```bash
npm install
npm run dev
```










