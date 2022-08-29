# VAT-Calculaor
--------------------
composer install
open mariadb command console
create new db => CREATE DATABASE db_name;
---------------------
update  DATABASE_URL in .env (check port also)
---------------------

run in cmd project folder

php bin/console doctrine:migrations:migrate

accepect 'yes'

-----------------------

run project

symfony server:start

----All Done---
