# temp_upload_php7
Web temp file upload look like temp.sh/transfer.sh using PHP7, HTML on Linux and Windows

<img alt="README" src="https://raw.githubusercontent.com/KhanhNguyen9872/temp_upload_php7/main/README.png" />

## DEMO
[Temp Upload](https://temp.run.goorm.io)

## Required
- Windows (XAMPP, AppServ,...)
or
- Linux (Ubuntu, Debian, Kali Linux,...)
- Apache2
- PHP7 or up

## Installation for Linux
1. Install dependent
```bash
sudo apt update -y
sudo apt install php apache2 git -y
```
2. Export apache2 path html
```bash
export path_install="/var/www/html"
```
3. Remove original html
```bash
sudo rm -rf ${path_install}
```
4. Clone this repo to /var/www/html
```bash
sudo git clone https://github.com/KhanhNguyen9872/temp_upload_php7.git ${path_install}
```
5. Grant all permission in /var/www/html
```bash
sudo chmod 777 ${path_install} -R
```
6. Setup Apache2 and PHP config
```bash
cd ${path_install}; sudo bash setup.sh
```
7. Start Apache2
```bash
sudo service apache2 start
```
8. Enjoy on your web!

## Installation for Windows
1. Download this repo [here](https://github.com/KhanhNguyen9872/temp_upload_php7/archive/refs/heads/main.zip)
2. Extract it and move all file to your website folder
3. Run setup-windows.bat and do with this tutorial
4. Start your server and enjoy