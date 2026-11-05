#!/bin/bash

# ==============================================================================
# Script Update / Deployment STARPAS Banten untuk Server Hosting / VPS
# ==============================================================================

echo "🚀 Memulai proses update aplikasi STARPAS Banten di hosting..."

# 1. Aktifkan Maintenance Mode (opsional agar pengunjung melihat halaman pemeliharaan sementara)
php artisan down || true

# 2. Tarik kode terbaru dari repositori GitHub
echo "📥 Menarik perubahan kode dari git origin main..."
git pull origin main

# 3. Pasang dependensi PHP (mode production tanpa dev package)
echo "📦 Memperbarui dependensi Composer..."
composer install --no-dev --optimize-autoloader --no-interaction

# 4. Jalankan migrasi database
echo "🗄️ Menjalankan migrasi database..."
php artisan migrate --force

# 5. Buat symlink storage jika belum ada
echo "🔗 Memastikan tautan folder storage..."
php artisan storage:link || true

# 6. Bersihkan cache lama dan optimasi konfigurasi untuk performa tinggi
echo "⚡ Mengoptimalkan cache sistem..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 7. Nonaktifkan Maintenance Mode (Aplikasi kembali online)
php artisan up

echo "✅ Aplikasi STARPAS Banten berhasil diupdate dan siap digunakan!"

