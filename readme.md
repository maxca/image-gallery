
## Start project 

``
docker-compose up -d
``
## Install node package

``
docker exec -it peerpower-test npm install 
``

## Build webpack

``
docker exec -it peerpower-test npm run dev | npm run watch 
``

## Composer install 

``
docker exec -it peerpower-test comomposer install 
``
## Migration 

``
docker exec -it peerpower-test php artisan migrate 
``


## Unit test 

``
docker exec -it peerpower-test phpunit 
``

## phpmyadmin  

``
http://localhost:8002 
``

## url project  

``
http://localhost:8407 
``