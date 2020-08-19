#!/usr/bin/env bash

#export DEBIAN_FRONTEND=noninteractive


sudo apt-get update
sudo apt-get install -y apache2 php libapache2-mod-php php-mysql

cp /vagrant/www/index.conf /etc/apache2/sites-available/

chmod 777 /vagrant
chmod 777 /vagrant/www
chmod 777 /vagrant/www/index.conf

a2ensite index

a2dissite 000-default

service apache2 reload

echo "Welcome to webserver"
if ! [ -L /var/www ]; then
	rm -rf /var/www
	ln -fs /vagrant /var/www
fi
