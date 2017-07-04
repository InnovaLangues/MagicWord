## TOOLS
> sudo apt-get install phpmyadmin git

## LAMP
> sudo apt-get install curl apache2 php7.0 php7.0-apcu mysql-server

## COMPOSER
> sudo curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

## NODE
> curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -

> apt-get install nodejs

## APC
(selon la version de php)

## Clone project
> git clone https://github.com/InnovaLangues/MagicWord.git

## Set up permissions
> sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx var  
> sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx var  

## Install symfony dependencies
> composer install

## Create dbs
> php bin/console doctrine:database:create

> php bin/console doctrine:database:create --connection=lexicon

## Install js dependencies
> npm install

> sudo npm install -g bower grunt

> bower install

## Assets & cache & translations
> php bin/console bazinga:js-translation:dump

> php bin/console assets:install --env=prod

> php bin/console cache:clear --env=prod

## MySQL conf.
> sudo vi /etc/mysql/my.cnf

ft_min_word_len = 2

ft_stopword_file = ""

> sudo service mysql restart

## Fixtures & lexicon
> mysql -u root -proot -h localhost mw < mw_fixtures.sql

> mysql -u root -proot -h localhost lexicon < mw_lexiconsql
