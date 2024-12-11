# MyMusic Project

MyMusic adalah aplikasi berbasis web yang memungkinkan pengguna untuk mengelola lagu, catatan, dan playlist dengan berbagai fitur seperti streaming, pencarian, dan pengunduhan.

Proyek ini terdiri dari 3 layanan utama:
1. **Next.js** - Layanan utama yang berfungsi sebagai fullstack menggunakan Next.js.
2. **Laravel** - Layanan utama yang berfungsi sebagai fullstack menggunakan Laravel
3. **FileService** - Layanan Python untuk menangani file dan pengunduhan.

"Dapat memilih salah satu antara Laravel atau NextJS sebagai Front-End"
---
## ✨ Fitur Utama
- **Manajemen Musik**: Tambah, edit, hapus, dan putar lagu dengan kontrol penuh.
- **Playlist Kustom**: Buat dan kelola playlist sesuai kebutuhan pengguna.
- **Lirik Lagu**: Sinkronisasi lirik dengan audio secara real-time.
- **Manajemen Catatan**: Fitur untuk menulis dan mengelola catatan musik.
- **Autentikasi dan Otorisasi**: Sistem login dan register dengan NextAuth.
- **Dockerized Services**: Struktur mikroservices yang siap dijalankan dengan Docker.
---
## 🚀 Teknologi yang Digunakan
1. Next.js
Framework FullStack modern berbasis React.
Menggunakan TailwindCSS untuk styling dan Prisma untuk ORM.
Mendukung server-side rendering (SSR) dan API routes.
2. Laravel
Framework FullStack PHP yang kuat.
Menggunakan Eloquent ORM untuk manajemen database.
Fitur autentikasi, middleware, dan caching.
3. FileService
Layanan berbasis Python untuk pengelolaan file.
Menggunakan Flask untuk API dan supervisord untuk proses daemon.
4. Docker
Semua layanan dapat dijalankan dalam container menggunakan Docker dan Docker Compose.
---
## ⚙️ Persiapan dan Instalasi
1. Clonning Repository
```plaintext
git clone https://github.com/misbahul-rafi/my-music.git
cd my-music
```
2. Set Up Docker
Pastikan Anda memiliki Docker dan Docker Compose yang terinstal di sistem Anda.

4. Konfigurasi File Environment
Buat file .env untuk masing-masing layanan berdasarkan
- env-example.nextjs untuk Next.js
- .env.example di folder laravel
3. Menjalankan Aplikasi
```plaintext
docker-compose up --build

```
---
## 🛠️ Penggunaan
1. Akses Aplikasi
Akses aplikasi melalui port default, biasanya di http://localhost:3000 untuk NextJS dan http://localhost:8000 untuk Laravel

3. FileService
Endpoint file service tersedia di port yang dikonfigurasi dalam docker-compose.yml.
---
## 📁 Struktur Proyek
```plaintext
MyMusic/
├─ .env.nextjs            # File environment untuk Next.js
├─ docker-compose.yml     # Konfigurasi Docker Compose
├─ fileservice/           # Layanan FileService berbasis Python
├─ init.sql               # Skrip SQL inisialisasi
├─ laravel/               # Layanan back-end berbasis Laravel
├─ nextjs/                # Aplikasi front-end berbasis Next.js
└─ README.md              # File dokumentasi proyek
```
