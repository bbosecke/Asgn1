#!/usr/bin/env bash

export DEBIAN_FRONTEND=noninteractive


sudo apt-get update
sudo apt-get install -y apache2
if ! [ -L /var/www ]; then
	rm -rf /var/www
	ln -fs /vagrant /var/www
fi
