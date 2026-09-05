#!/bin/sh
set -e #در صورت بروز خطا، فوراً متوقف شو

# ۱. ساخت پوشه‌ها (اگر وجود ندارند)
mkdir -p /var/www/storage/framework/cache
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/logs
mkdir -p /var/www/bootstrap/cache

# ۲. تغییر مالکیت به کاربر وب‌سرور (www-data)
# این کار باعث می‌شود فایل‌ها متعلق به وب‌سرور باشند و نیاز به 777 نباشد
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache

# ۳. تنظیم دسترسی‌های استاندارد
# پوشه‌هایی که لاراول نیاز به نوشتن دارد (775)
find /var/www/storage -type d -exec chmod 775 {} \;
find /var/www/storage -type f -exec chmod 664 {} \;
find /var/www/bootstrap/cache -type d -exec chmod 775 {} \;
find /var/www/bootstrap/cache -type f -exec chmod 664 {} \;

# پوشه public فقط نیاز به خواندن دارد (755 برای پوشه، 644 برای فایل)
# نکته: اگر در public آپلود دارید، آن زیرپوشه خاص را جداگانه مدیریت کنید
chmod -R 755 /var/www/public

# اجرای دستور اصلی
exec "$@"
