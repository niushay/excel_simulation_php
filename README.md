

https://user-images.githubusercontent.com/48344449/178142180-4fcbcd44-d8c2-4813-9fea-641858dde869.mp4




1. Clone the code from Github:
* git clone https://github.com/niushay/excel_simulation
2. Create a database
3. Change the settings file in app/config/config.php:
* Change DB_HOST, DB_USER, DB_PASS, DB_NAME to your own database settings.
* Change FOLDER_NAME to the name of the folder which you clone the code
4. Change the folder name(the red one) in the .htaccess file which is in the public/.htaccess

<IfModule mod_rewrite.c>

Options -Multiviews

RewriteEngine On

RewriteBase /{YOUR_FOLDER_NAME} /public

RewriteCond %{REQUEST_FILENAME} !-d

RewriteCond %{REQUEST_FILENAME} !-f

RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]

</IfModule>

5. Run XAMPP or another web server
6. Locate the folder in the htdocs folder of XAMPP
7. Open the browser and enter the URL
* Default: http://localhost/{YOUR-FOLDER-NAME}
