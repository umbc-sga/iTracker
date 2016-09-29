#!/usr/bin/env bash

sudo apt-get update

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
sudo apt-get install -y mysql-server curl build-essential
sudo apt-get install -y apache2 php5 php5-common libapache2-mod-php5 php5-mysql php5-curl php5-json php5-readline php5-dev php5-cli

curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
sudo apt-get install -y nodejs

sudo a2enmod rewrite

cat /var/config_files/site.conf > /etc/apache2/sites-available/000-default.conf

sudo sed -i 's/127.0.0.1/0.0.0.0/g' /etc/mysql/my.cnf

echo "DROP DATABASE IF EXISTS test" | mysql -uroot -proot
echo "CREATE USER 'devdb'@'localhost' IDENTIFIED BY 'devdb'" | mysql -uroot -proot;
echo "CREATE USER 'devroot'@'%' IDENTIFIED BY 'devroot'" | mysql -uroot -proot;
echo "CREATE DATABASE devdb" | mysql -uroot -proot;
echo "GRANT ALL ON devdb.* TO 'devdb'@'localhost'" | mysql -uroot -proot;
echo "GRANT ALL ON *.* TO 'devroot'@'%'" WITH GRANT OPTION | mysql -uroot -proot;

sudo service apache2 restart
sudo service mysql restart

php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/bin/composer

#pushd;
cd /srv/web
composer install
#popd;