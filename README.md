
# 📦 Laravel Project Setup Guide

Panduan lengkap untuk menjalankan project Laravel dari awal menggunakan Composer dan Node.js.

## 🧰 Prasyarat

Pastikan kamu sudah menginstal:

- [Composer](https://getcomposer.org/download/)
- [Node.js (disertai NPM)](https://nodejs.org/)

---

## 🚀 Langkah-Langkah Setup

### 1. Clone Project dari GitHub

```bash
git clone https://github.com/username/namaproject.git
cd namaproject
```
Ganti `username` dan `namaproject` sesuai dengan repositori GitHub kamu.

### 2. Install Dependency Laravel via Composer

```bash
composer install
```

### 3. Salin File `.env` dan Generate Key

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan bagian berikut:

```env
DB_DATABASE=namadatabase
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan dengan konfigurasi database lokal kamu (MySQL atau lainnya).

### 5. Jalankan Migrasi (jika diperlukan)

```bash
php artisan migrate
```

### 6. Install Dependency Frontend via NPM

```bash
npm install
```

### 7. Compile Asset dengan Vite

```bash
npm run dev
```

### 8. Jalankan Server Laravel

```bash
php artisan serve
```

Buka browser dan akses: [http://localhost:8000](http://localhost:8000)

---

✅ Selesai!  
Project Laravel kamu sekarang siap dijalankan di lokal 🎉
