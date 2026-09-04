FROM php:8.3-fpm

# --- پکیج‌های سیستمی ---
# libwebp-dev / libjpeg / libpng / libfreetype  => برای GD با پشتیبانی WebP
# ffmpeg => برای VideoUploadService (ساخت thumbnail از ویدیو و خواندن metadata)
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    zip \
    ffmpeg \
    libpq-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    && rm -rf /var/lib/apt/lists/*

# --- اکستنشن‌های PHP ---
# gd  : پردازش تصویر (با WebP) — همان چیزی که ImageUploadService به آن نیاز دارد
# ftp : درایور FTP فلای‌سیستم لاراول — هم عکس‌ها هم ویدیوها روی همین دیسک آپلود می‌شوند
# exif: خواندن اطلاعات EXIF (چرخش خودکار عکس‌های موبایل در ImageUploadService::process)
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
    pdo_pgsql \
    pgsql \
    gd \
    ftp \
    exif \
    zip

# --- اکستنشن‌های PECL ---
# redis لازم است چون کش/سشن/صف (queue-general) از همان Redis پروژه‌ی musicbot استفاده می‌کنند
RUN pecl install redis \
    && docker-php-ext-enable redis

# --- Imagick (اختیاری) ---
# کیفیت بهتر برای resize/encode تصاویر؛ ImageUploadService به‌صورت خودکار بین gd/imagick
# سوییچ می‌کند (config('images.driver')). اگر لازم نداری این بلوک را کامنت کن.
RUN apt-get update && apt-get install -y --no-install-recommends libmagickwand-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && rm -rf /var/lib/apt/lists/*

# --- تنظیمات حجم آپلود و زمان اجرا ---
# چون هم عکس هم ویدیو آپلود می‌شود، حجم را روی ۳۰۰ مگابایت نگه داشتیم؛
# اگر ویدیوهای بزرگ‌تر هم داری این عدد را در سه جا هم‌زمان باید عوض کنی:
# اینجا، nginx (client_max_body_size) و ولیدیشن VideoUploadService/FormRequest.
RUN echo "upload_max_filesize = 300M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 300M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_input_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/uploads.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www

ENTRYPOINT ["entrypoint.sh"]
