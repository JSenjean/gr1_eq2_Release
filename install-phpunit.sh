#!/bin/bash
wget -O phpunit https://phar.phpunit.de/phpunit-6.phar
chmod +x phpunit
php phpunit --version

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

php composer.phar require limedeck/phpunit-detailed-printer:3.2 --dev

mkdir logTests
mkdir composer
mv ./composer.json ./composer.lock ./composer.phar composer/
