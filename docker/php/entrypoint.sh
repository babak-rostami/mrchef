#!/bin/sh
set -e #در صورت بروز خطا، فوراً متوقف شو

# ۱. ساخت پوشه‌ها (اگر وجود ندارند)
mkdir -p /var/www/storage/framework/cache
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/logs
mkdir -p /var/www/bootstrap/cache

# ۲. تغییر مالکیت (Ownership)
# این مهم‌ترین بخش است. ما به داکر می‌گوییم فایل‌ها متعلق به کاربر www-data باشند.
# این کار جلوی خطاهای permission denied را بدون نیاز به 777 می‌گیرد.
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# ۳. تنظیم مجوزها (Permissions)
# دایرکتوری‌ها: 775 (مالک و گروه می‌توانند بنویسند، بقیه فقط بخوانند)
# فایل‌ها: 664 (مالک و گروه می‌توانند بنویسند، بقیه فقط بخوانند)
find /var/www/storage /var/www/bootstrap/cache -type d -exec chmod 775 {} \;
find /var/www/storage /var/www/bootstrap/cache -type f -exec chmod 664 {} \;

# اجرای دستور اصلی (مثل php-fpm یا artisan queue:work)
exec "$@"
