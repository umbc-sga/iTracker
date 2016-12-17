#!/usr/bin/env bash

sudo apt-get update

# MySQL setup, user:pass = root:root
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'

#Install MySQL and the essentials
sudo apt-get install -y mysql-server curl build-essential
sudo apt-get install -y apache2 php5 php5-common libapache2-mod-php5 php5-mysql php5-curl php5-json php5-readline php5-dev php5-cli

# Install nodeJS 6.x
curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
sudo apt-get install -y nodejs

# Enable url rewrite
sudo a2enmod rewrite

# Copy site config over
cat /var/config_files/site.conf > /etc/apache2/sites-available/000-default.conf

# Make MySQL listen on all interfaces
sudo sed -i 's/127.0.0.1/0.0.0.0/g' /etc/mysql/my.cnf

# Create devdb:devdb user and devroot:devroot user
echo "DROP DATABASE IF EXISTS test" | mysql -uroot -proot
echo "CREATE USER 'devdb'@'localhost' IDENTIFIED BY 'devdb'" | mysql -uroot -proot;
echo "CREATE USER 'devroot'@'%' IDENTIFIED BY 'devroot'" | mysql -uroot -proot;
echo "CREATE DATABASE devdb" | mysql -uroot -proot;
echo "GRANT ALL ON devdb.* TO 'devdb'@'localhost'" | mysql -uroot -proot;
echo "GRANT ALL ON *.* TO 'devroot'@'%'" WITH GRANT OPTION | mysql -uroot -proot;

# Restart services
sudo service apache2 restart
sudo service mysql restart

# Install composer
php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/bin/composer

# Setup application
cd /srv/web
composer install

# Install node dependencies and build
npm install --no-bin-links
sudo npm install -g gulp
gulp build