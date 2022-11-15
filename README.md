# temp_upload_php7
Web temp file upload using PHP7, HTML on Linux

## Required
- Linux (Ubuntu, Debian, Kali Linux,...)
- Apache2
- PHP7 or up

## Installation
1. Install dependent
```bash
sudo apt update -y
sudo apt install php apache2 git -y
```
2. Remove original html file
```bash
sudo rm -rf /var/www/html
```
3. Clone this repo to /var/www/html
```bash
sudo git clone https://github.com/KhanhNguyen9872/temp_upload_php7.git /var/www/html
```
4. Grant all permission in /var/www/html
```bash
sudo chmod 777 /var/www/html -R
```
5. Start Apache2
```bash
sudo service apache2 start
```
6. Enjoy on your web!