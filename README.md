# Aplikasi Peminjaman
---
## Cara installasi
1. Clone project ke webserver
2. Copy file `.env.example` menjadi `.env`
3. Buat `APP_KEY` dengan perintah `php artisan key:generate`
4. Atur database di file `.env`
5. Jalankan `npm run build` untuk render css dan js
6. Jalankan aplikasi dengan perintah `php artisan serve` dan akses di `localhost:8000`, atau langsung kunjungi `localhost/nama_folder_project_ini`

## Cara menambah admin
Gunakan perintah `php artisan admin:create` kemudian isikan data admin.
