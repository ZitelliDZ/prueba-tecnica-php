# Prueba Técnica - Desarrollador PHP
## Enunciado:
Se desea armar una API que permita:  
- Consumir PokeApi para obtener y guardar una lista de 15 Pokemones.  
- Crear y listar equipos de hasta 3 pokemones, el equipo tiene que estar vinculado a un entrenador.  
- Crear, listar y detallar entrenadores.  El detalle del entrenador deberá poseer la lista de los equipos que lidera.  
- Tratar de respetar las versiones dadas de PHP y Laravel

## Info Adicional:

PokeAPI (https://pokeapi.co/)  
Archivo con la base de datos a utilizar dump.sql

## Guía de instalación:

Crear .env con los datos de la base de datos  
Crear base de datos con el nombre que se haya puesto en el .env y correr el archivo dump.sql

Ejecutar los siguientes comandos:

* ```npm install```  
* ```composer install```  
* ```php artisan key:generate```  
* ```php artisan config:cache```  
* ```php artisan serve```  

Correr los tests con el comando:
*  ```vendor/bin/phpunit```  


