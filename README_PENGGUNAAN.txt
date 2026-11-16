CARA MENJALANKAN PROJECT KURSUSKU

1. Install dan buka XAMPP.
2. Start Apache dan MySQL.
3. Copy folder project ini ke:
   C:\xampp\htdocs\kursusku
4. Buka phpMyAdmin:
   http://localhost/phpmyadmin
5. Import database:
   database/kursusku.sql
6. Buka website:
   http://localhost/kursusku/index.php

ALUR FITUR:
- Register akun di register.php
- Login di login.php
- Setelah login, navbar menampilkan foto profil + nama depan.
- Klik profil untuk membuka menu Dashboard dan Logout.
- Buka courses.php lalu pilih kursus.
- Klik Beli / Berlangganan di course-details.php.
- Transaksi masuk ke tabel transactions.
- Riwayat kursus tampil di dashboard.php.

CATATAN:
- File yang dipakai adalah .php, bukan .html.
- File .html di project ini hanya redirect ke versi .php.
- Database memakai nama: kursusku
- User database default XAMPP: root tanpa password.
