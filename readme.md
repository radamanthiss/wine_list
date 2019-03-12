# Lis wine Application

This application run in a local environment

## Install and config wampserver
download [link](https://sourceforge.net/projects/wampserver/files/)
and init the control panel of wampp and activate de apache, mysql, php module.


# IMPORTANT RECOMMENDATIONS !!

Antes de empezar asegurarse de tener las conexiones habilitadas para poder ejecutar el xampp control y asi obtener las variables de entorno
se puede crear directamente la base de datos en localhost/phpmyadmin o usando los archivos enviados en el proyecto que son los exportados de la base de datos usada durante la realizaci�n del proyecto, si se crea una nueva base de datos en el phpmyadmin se deben modificar las variables en el archivo .env para que se puedan ejecutar todas las pruebas de manera exitosa.



cualquier duda o pregunta se puede escribir al correo ulkevinb@gmail.com o al skype startek13

## Pasos iniciales para ejecutar el proyecto
Se debe colocar el proyecto en la ruta C:/wamp64/www/ una vez colocado ahi se puede proceder a ejecutar 
las siguientes rutas

[link] (http://localhost/list_wine/models/create_database.php) permite crear la base de datos
[link] (http://localhost/list_wine/models/create_table.php) permite crear la tabla de vinos en la base de datos
[link] (http://localhost/list_wine/models/data_load.php) permite cargar inicialmente el RSS Feed
[link] (http://localhost/list_wine/models/update_wine.php) permite actualizar el listado de vinos diariamente
[link] (http://localhost/list_wine/views/index.php) vista principal del proyecto, nos lista la informacion de la tabla
[link] (http://localhost/list_wine/models/validacion.php) permite crear la cola waiters en RabbitMQ

> ### Activar Eloquent y Facades

Despues de tener configurada la ruta del proyecto se debe ir al archivo app.php que se encuentra en bootstrap/app.php y descomentar la linea // app->withEloquent, adicionalmente tambi�n descomentar la linea //$app->withFacades(); que se encuentra en el mismo archivo

> ### Configurar base de datos

Para poder configurar la conexi�n a la base de datos modificar el archivo .env, en este archivo a�adiremos las variables que necesitamos para que nuestro proyecto haga uso de MySQL y de la api de google maps. Se debe a�adir lo siguiente:


![envconfig](https://user-images.githubusercontent.com/22681704/48908313-ea850c00-ee37-11e8-8df9-0c72418af9b1.PNG)

En la variable APP__TIMEZONE, configurar la de nuestra regi�n actual. Despu�s de tener nuestro archivo .env configurado podemos hacer uso de los comandos para crear las tablas en nuestra base de datos, con el siguiente comando php artisan make:migration create_codes_table, al hacer esto el archivo se crear� en la ruta database/migrations, donde procederemos a modificar el archivo creado para configurar los campos que necesitamos en nuestra tabla. Se ve como el la siguiente imagen:

![migrations](https://user-images.githubusercontent.com/22681704/48908630-e1486f00-ee38-11e8-9930-bd6bd52d2a3a.PNG)


Tambi�n podemos establecer las relaciones entre las diferentes tablas a�adiendo un par de lineas en nuestro archivo de creacion de tabla por ejemplo para la tabla events volvemos a usar el comando para crearla desde nuestra interfaz de linea de comando, php artisan make:migration create_events_table y luego modificamos el archivo de la siguiente manera.

![relations](https://user-images.githubusercontent.com/22681704/48908838-89f6ce80-ee39-11e8-8830-417ae4ee5cc4.PNG)

Lo que se encuentra en el recuadro rojo es lo que debemos a�adir a todas las tablas que necesitemos que est�n relacionadas. Una vez tenemos todos nuestros archivos creados, procedemos a hacer uso del comando php artisan migrate. lo que nos crear� las tablas en nuestra base de datos llamada promociones, por ultimo podemos comprobar que se hayan creado las tablas ingresando en el navegador la ruta localhost/phpmyadmin como lo vemos a continuaci�n

![Database](https://media.giphy.com/media/7E8pu3FoKqwynvrr9G/giphy.gif)


> ### Configurar libreria de Maps

En la terminal de linea de comandos, procedemos a instalar una libreria que nos ayudar� a lo largo del proyecto para poder obtener las coordenadas de determinados puntos, la libreria se llama geocode, y se instala con el siguiente comando composer require "jcf/geocode":"~1.3" luego usamos composer update, y ya tendremos instalada la librer�a, por ultimo vamos al archivo bootstrap/app.php y en la secci�n de providers a�adimos $app->register(Jcf\Geocode\GeocodeServiceProvider::class); para poder utilizarlo en nuestro proyecto.

![providers](https://user-images.githubusercontent.com/22681704/48909374-181f8480-ee3b-11e8-9397-7491681329fc.PNG)



## Creaci�n archivos necesarios para el proyecto

Una vez hemos configurado las variables y librerias necesarias procedemos a crear los archivos que nos permitiran crear la api restful para poder tener cada una de los metodos necesarios del proyecto, en la carpeta app creamos los modelos que necesitamos para la l�gica, que son Code.php, Event.php, Travel.php, User.php estos nos permitiran comunicarnos a las tablas de la base de datos y traer la informaci�n que necesiten los controladores y que a su vez se comunican con el modelo.

Modelo Code.php

![code](https://user-images.githubusercontent.com/22681704/48909722-0094cb80-ee3c-11e8-8153-79d66febdc92.PNG)

Modelo Event.php

![event](https://user-images.githubusercontent.com/22681704/48909740-0e4a5100-ee3c-11e8-9063-4ca8bae8c4b8.PNG)


Aqu� vemos unos ejemplos de como quedan los modelos y las distintas funciones que usaremos en el proyecto. Una vez creamos todos los modelos, podemos proceder a crear los diferentes Controllers de la aplicaci�n, estos se ubicaran en la ruta app/Http/Controllers. Tendremos CodeController.php, EventsController.php, HomeController.php, TravelsController.php, UsersController.php, cada uno de estos controladores tendra la l�gica necesaria para comunicarse con los models, obtener informaci�n de las tablas y devolver una respuesta seg�n el tipo de petici�n ya sea POST, GET, PUT.
Aqu� vemos un ejemplo de CodeController.php, explicaremos cada funcion de cada controlador adelante.

![codecontroller](https://user-images.githubusercontent.com/22681704/48910816-ef00f300-ee3e-11e8-9fdf-f7846fe90802.PNG)


> ### Configurar rutas para los metodos

Para cada metodo que vayamos a usar para realizar peticiones, hay que configurar la ruta para poder hacer el llamado, esto se hace en el archivo que se encuentra en routes/web.php, aqu� configuramos el tipo de peticion y a que funci�n de los controladores apuntar� cada ruta.

![rutas_finales](https://user-images.githubusercontent.com/22681704/48950438-220fb900-ef09-11e8-8ed1-cfcb53bbca98.PNG)



> ## Explicacion funciones y rutas

> ### CodeController.php
Este controlador cuenta con las siguientes funciones

	+ {GET} localhost:8000/code/{id} => Funcion: getCode : Devuelve el codigo seg�n el id que se le pasa en la peticion.
	+ {GET} localhost:8000/code  => Funcion: getallCode : Devuelve todos los codigos que se encuentra en la base de datos.
	+ {POST} localhost:8000/new-code => Funcion: createNewCode : Permite generar nuevos codigos segun los parametros ingresados que son:  

![create-code](https://user-images.githubusercontent.com/22681704/48920055-98a6ab00-ee64-11e8-8048-8900d8b5fd93.PNG)

	+ {GET} localhost:8000/code-actives => Funcion: getCodesActive : Permite obtener los codigos activos en la base de datos.
	+ {POST} localhost:8000/deactive-codes => Funcion: deactiveCodes : Permite cambiar el estado de un codigo de activo a inactivo seg�n los parametros. que se le pasan:

![deactive](https://user-images.githubusercontent.com/22681704/48920158-41eda100-ee65-11e8-95d8-086c2a6e02eb.PNG)


> ### UsersController.php
  Este controlador tiene las siguientes funciones:

	+ {POST} localhost:8000/create-user => Funcion: createNewUser : permite generar un nuevo usuario seg�n los parametros que se ingresan:
![new-user](https://user-images.githubusercontent.com/22681704/48920382-947b8d00-ee66-11e8-8ede-7c08668ab28e.PNG)

	+ {GET} localhost:8000/get-origin/{id} => Funcion: getOrigin : Se usa para obtener la ubicacion actual del usuario.
	+ {POST} localhost:8000/new-origin => Funcion: updateOrigin: Permite actualizar la ubicaci�n del usuario por una nueva ingresada segun los parametros:

![new-origin](https://user-images.githubusercontent.com/22681704/48920504-4dda6280-ee67-11e8-8e1b-a09d470f8ea4.PNG)


> ### EventsController.php
 Tiene las siguientes funciones:
 
	+ {POST} localhost:8000/config-radius => Funcion: updateRadius : Permite configurar el radio en el que los codigos ser�n validos para ser usados segun los parametros que se envian en el json:
	
![update-raidus](https://user-images.githubusercontent.com/22681704/48920631-f25ca480-ee67-11e8-9d51-7f8bfdc0aff1.PNG)

	+ {POST} localhost:8000/validate-code => Funcion: validateCodeEvent : Valida el codigo y devuelve respuesta segun los parametros ingresados

![validate-code](https://user-images.githubusercontent.com/22681704/48920721-86c70700-ee68-11e8-8478-e57819b815b3.PNG)

	+ {POST} Funcion: validateCode : Es la funcion usada durante el envio de los datos desde la vista del usuario, se encarga de procesar la informacion, y devuelve las variables necesarias a la vista para que se pinte el mapa y los mensajes seg�n cada opcion ingresada.
	

> ### HomeController.php
  Tiene las siguientes funciones:
  
	+ {GET} localhost:8000/home => Funcion: inicio : Devuelve la vista principal de la aplicacion

![home](https://user-images.githubusercontent.com/22681704/48920850-71061180-ee69-11e8-9e8a-ed9109a77b8d.png)

	+ {POST} localhost:8000/principal => Funcion: recibir : Es la vista encargada de recibir por post el formulario de home y hacer validaciones para los diferentes casos como pintar el mapa, devolver mensaje exitoso de validaci�n, devolver mensaje de error etc.
	
![principal](https://user-images.githubusercontent.com/22681704/48920927-ee318680-ee69-11e8-9efd-ce1898fb7712.png)



### Logs de seguimiento

Podemos ver los diferentes logs generados al momento de hacer peticiones a la api, en la ruta storage/logs/lumen-fecha.log, aqu� se loguea las respuestas y los errores que puedan suceder al momento de invocar la api.

![log](https://user-images.githubusercontent.com/22681704/48921049-f6d68c80-ee6a-11e8-9a77-02f9b7e5e748.PNG)



