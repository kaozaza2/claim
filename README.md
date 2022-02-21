# Claim system

สำหรับใช้แจ้งซ่อม/ย้ายอุปกรณ์ต่างๆในสำนักงาน

# Installation (Local)

 **สิ่งที่ต้องใช้**
 * Xampp (php 8.0 or newer)
 * NodeJS
 
 **วิธีลง (Windows)**
 * คัดลอกไฟล์ทั้งหมดลงในโฟล์เดอร์ xampp/htdocs
   * ถ้ามีไฟล์อยู่ในนั้นอยู่แล้ว ให้ลบทั้งหมดก่อนแล้วค่อยคัดลอกลง
 * เปิด xampp-control
   * start Apache
   * start MySQL
 * เปิด [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   * กดที่ New ด้านซ้าย
   * ใส่ชื่อ Database แล้วเลือก utf8mb4_unicode_ci
   * กด Create
 * เปิด xampp-control คลิกที่ Shell
 * รันคำสั่ง
   ```shell
   $ cd htdocs
   $ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
   $ php composer-setup.php --filename=composer
   $ php -r "unlink('composer-setup.php');"
   ```
 * รันคำสั่ง
   ```shell
   $ copy .env.example .env
   $ php composer install
   $ php artisan key:generate
   $ npm install
   $ npm run production
   ```
 * เปิดไฟล์ .env แล้วตั้งค่า Database
   ```ini
   DB_CONNECTION=mysql # ประเภท Database
   DB_HOST=127.0.0.1 # ที่อยู่ Database
   DB_PORT=3306
   DB_DATABASE=laravel # ชื่อ Database
   DB_USERNAME=root # ชื่อผู้ใช้
   DB_PASSWORD= # รหัสผ่าน
   ```
 * รันคำสั่ง
   ```shell
   $ php artisan migrate --seed
   $ php artisan storage:link
   ```
 * เปิดไฟล์ .env แล้วตั้งค่า
   ```ini
   APP_NAME=Laravel # ชื่อเว็บ
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=http://localhost # ที่อยู่เว็บไซต์
   LINE_TOKEN= # Line notify โทเค่น
   ```
 * เปิดไฟล์ xampp/apache/conf/httpd.conf แล้วตั้งค่า
   * แก้ `DocumentRoot "/xampp/htdocs"` เป็น `DocumentRoot "/xampp/htdocs/public"`
   * แก้ `<Directory "/xampp/htdocs">` เป็น `<Directory "/xampp/htdocs/public">`
 * เปิด xampp-control แล้ว stop Apache 1 ที แล้ว start ใหม่
 * ลบไฟล์ไม่จำเป็น (ไม่ทำก็ได้)
   * ลบ node_modules
   * ลบ composer
 * เข้าเว็บ [http://localhost](http://localhost) ได้เลย
