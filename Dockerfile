# Gunakan image PHP dengan Apache
FROM php:8.2-apache

# Install ekstensi MySQLi (Wajib untuk koneksi database)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Aktifkan mod_rewrite (opsional, tapi bagus untuk masa depan)
RUN a2enmod rewrite

# Copy semua file website ke folder web server
COPY . /var/www/html/

# Atur hak akses agar Apache bisa baca
RUN chown -R www-data:www-data /var/www/html
