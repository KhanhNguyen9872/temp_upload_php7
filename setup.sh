#!/bin/bash
rm -rf ./.git > /dev/null 2>&1
rm -rf $HOME/.bash_history > /dev/null 2>&1
sudo="$(which sudo)"
apache2_conf="/etc/apache2/apache2.conf"
apache2_security="/etc/apache2/conf-available/security.conf"

echo "Hide Apache version from http...."
${sudo} sed -i '/ServerTokens /d' ${apache2_security} > /dev/null 2>&1
${sudo} sed -i '/ServerSignature /d' ${apache2_security} > /dev/null 2>&1
${sudo} sed -i '1 a ServerTokens Prod' ${apache2_security} > /dev/null 2>&1
${sudo} sed -i '2 a ServerSignature Off' ${apache2_security} > /dev/null 2>&1

echo "Setting up apache2 config...."
${sudo} sed -i 's/ Indexes//g' ${apache2_conf} > /dev/null 2>&1
${sudo} sed -i '/ServerName /d' ${apache2_conf} > /dev/null 2>&1
${sudo} echo "ServerName 0.0.0.0" >> ${apache2_conf} 2> /dev/null

echo "Setting up php config...."
list_php="$(${sudo} ls /etc/php 2> /dev/null)"
php_config="$(${sudo} cat ./php.ini 2> /dev/null)"
while IFS= read -r ida; do
	if [ -f /etc/php/${ida}/apache2/php.ini ] 2> /dev/null; then
		while IFS= read -r idb; do
			${sudo} sed -i "/$(printf "${idb}" | awk '{print $1}')/d" /etc/php/${ida}/apache2/php.ini > /dev/null 2>&1
			${sudo} printf "\n${idb}\n" >> /etc/php/${ida}/apache2/php.ini 2> /dev/null
		done < <(printf '%s\n' "$php_config")
	fi
done < <(printf '%s\n' "$list_php")

echo "Restart Apache2 Service...."
${sudo} service apache2 restart > /dev/null 2>&1

echo "Removing install file...."
${sudo} rm -rf ./*.sh ./*.ini ./*.md > /dev/null 2>&1

echo "Done!"