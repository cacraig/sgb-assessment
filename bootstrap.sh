#!/usr/bin/env bash

apt-get update
apt-get install -y apache2
apt-get install -y php5 git php5-curl php5-cli
apt-get install -y libapache2-mod-php5
apt-get install -y curl
a2enmod rewrite
service apache2 restart

# Symlink project to default webroot.
if ! [ -L /var/www ]; then
  rm -rf /var/www
  ln -fs /vagrant /var/www
fi

# Clear any existing conf files.
sudo rm /etc/apache2/sites-available/*
sudo rm /etc/apache2/sites-enabled/*

# Inject project apache2 conf file.
sudo cp /vagrant/conf/sgb-apache.conf /etc/apache2/sites-available

# enable this conf file.
sudo a2ensite sgb-apache

# Setup composer, and install dependencies.
cd /vagrant
curl -sS https://getcomposer.org/installer | php
php composer.phar update
php composer.phar install

service apache2 restart

