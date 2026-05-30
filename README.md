# JasaWeb 🌐
<img width="1919" height="910" alt="Screenshot 2026-05-28 202509" src="https://github.com/user-attachments/assets/744bd3bc-5fe4-4695-b5b9-a46d978ef7db" />

### Website Katalog & Layanan Jasa Pembuatan Website Profesional

Platform web dinamis yang berfungsi sebagai landing page interaktif sekaligus katalog portofolio untuk mempromosikan layanan jasa pembuatan website, lengkap dengan fitur manajemen dashboard admin untuk pengelolaan proyek (*projects*) dan paket harga (*pricing packages*).

---

## 🚀 Fitur Utama
* **Landing Page Interaktif:** Tampilan modern, responsif, dan elegan untuk menarik calon klien.
* **Katalog Portofolio:** Menampilkan showcase hasil proyek/website yang telah dibuat dengan detail yang rapi.
* **Paket Harga (Pricing Packages):** Menampilkan daftar paket layanan beserta detail fitur dan harga secara transparan.
* **Dashboard Admin (Protected):** Panel administrasi khusus untuk mengelola data proyek (tambah, edit, hapus) dan daftar harga secara dinamis.
* **Integrasi GitHub Repositories:** Memudahkan admin untuk langsung menarik atau menghubungkan repositori GitHub sebagai bagian dari portofolio.

---

## 🛠️ Tech Stack
* **Backend:** Laravel 13 (PHP)
* **Frontend:** Vue.js 3 + Inertia.js (Modern SPA)
* **Language:** TypeScript & PHP
* **Styling:** Tailwind CSS
* **Database:** MySQL / SQLite
* **Authentication:** Laravel Fortify

---

## 💻 Petunjuk Instalasi Proyek (Lokal)

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek ini di komputer lokal Anda:

### 1. Prasyarat (Prerequisites)
Pastikan Anda sudah menginstal aplikasi berikut di komputer Anda:
* **PHP >= 8.3**
* **Composer**
* **Node.js & NPM**
* **MySQL** (atau DBMS pilihan Anda)

### 2. Kloning Repositori
Clone proyek ini ke folder lokal Anda:
```bash
git clone https://github.com/umamumam/JasaWeb.git
cd JasaWeb
```

### 3. Cara Cepat: Otomatis (*Quick Setup*)
Proyek ini sudah dilengkapi dengan script *setup* otomatis di `composer.json`. Jalankan perintah berikut untuk menginstal semua *dependencies*, membuat file konfigurasi `.env`, men-generate key, dan melakukan *build* aset:
```bash
composer run setup
```
*(Catatan: Pastikan Anda sudah membuat database kosong sebelum menjalankan migrasi secara otomatis, atau silakan gunakan opsi manual di bawah).*

---

### 4. Cara Manual (Direkomendasikan untuk Kontrol Penuh)

Jika Anda ingin mengaturnya satu per satu, silakan ikuti langkah manual berikut:

#### Langkah A: Instal PHP Dependencies
```bash
composer install
```

#### Langkah B: Instal Node.js (Frontend) Dependencies
```bash
npm install
```

#### Langkah C: Konfigurasi Environment File
Salin file konfigurasi `.env.example` menjadi `.env`:
```bash
# Untuk Linux / macOS / Git Bash / PowerShell
cp .env.example .env

# Untuk Windows Command Prompt (CMD)
copy .env.example .env
```

#### Langkah F: Generate Application Key
```bash
php artisan key:generate
```

#### Langkah G: Konfigurasi Database
1. Buat database baru di MySQL dengan nama `jasaweb` (atau nama lain bebas).
2. Buka file `.env` di text editor Anda, cari bagian konfigurasi database, dan sesuaikan:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=jasaweb
   DB_USERNAME=root
   DB_PASSWORD= password_mysql_kamu
   ```

#### Langkah H: Jalankan Migrasi & Database Seeder (Data Contoh)
Jalankan migrasi tabel beserta *seeder* untuk mengisi data contoh (portofolio, pricing, dan akun admin default):
```bash
php artisan migrate --seed
```

#### Langkah I: Hubungkan File Storage
Agar gambar portofolio/proyek yang di-upload admin bisa diakses publik, buat link ke storage:
```bash
php artisan storage:link
```

---

## ⚡ Menjalankan Proyek di Lokal

Setelah instalasi selesai, Anda cukup menjalankan perintah berikut di terminal untuk mengaktifkan server backend (Laravel) dan frontend (Vite) secara bersamaan:

```bash
composer run dev
```

Server lokal akan berjalan di:
* **Web App:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
* **Vite (Frontend):** Running di latar belakang

---

## 🔑 Informasi Login Admin Default

Anda dapat menggunakan akun bawaan hasil *database seeder* untuk login ke panel admin/dashboard:
* **URL Login:** [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)
* **Email:** `umam@gmail.com`
* **Password:** `12345678`

---

## 📄 Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).
