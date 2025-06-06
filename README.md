# Website-Note-Diary---Backend-Laravel-12

Website ini untuk mencatat data keuangan masuk dan keluar, serta mencatat hal-hal lain untuk dijadikan evaluasi perbulannya.

## Tech Stack

Project ini menggunakan teknologi berikut:

-   **Laravel 12** - Framework PHP untuk backend
-   **MySQL** - Database management system
-   **Nginx** - Web server
-   **Next js** - Framewordk JS untuk frontend react js

## Tim Pengembang

-   **Krisna Wahyudi** - Full Stack Developer

## Instalasi

Untuk menjalankan proyek ini secara lokal, pastikan Anda telah menginstal lakukan hal berikut:

1. **Clone repositor**
    - Clone project dari repository dengan menggunakan perintah berikut:
    ```bash
    git clone https://github.com/Kwahyu09/Website-Note-Diary---Backend.git
    cd note-diary
    ```
2. **Install Composer Dependencies**

    - Jalankan perintah berikut untuk menginstal semua dependensi yang diperlukan:
        ```bash
        composer install
        ```

3. **Copy dan Paste File .env**

    - Salin semua data dari file `.env.example` dan tempelkan di file `.env`:
        ```bash
        cp .env.example .env
        ```

4. **Generate Project Key**

    - Jalankan perintah berikut untuk menghasilkan kunci proyek:
        ```bash
        php artisan key:generate
        ```

5. Migrasi database:
    ```bash
    php artisan migrate --seed
    ```
6. Akses aplikasi melalui browser di `http://localhost`.

## Kontribusi

Silakan buat pull request jika ingin berkontribusi atau membuka issue jika menemukan masalah.

## Thank You

and lets build great apps!

# Web-Note-Diary---Backend-Laravel-12
