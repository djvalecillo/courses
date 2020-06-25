# CoursesApp

Pequeña application de ejemplo realizada con laravel 7 y Vue para manejo del frontend, en ella cuentas con manejo de cursos y estudiantes.

## Requerimientos
-   PHP >= 7.2.5
-   BCMath PHP Extension
-   Ctype PHP Extension
-   Fileinfo PHP extension
-   JSON PHP Extension
-   Mbstring PHP Extension
-   OpenSSL PHP Extension
-   PDO PHP Extension
-   Tokenizer PHP Extension
-   XML PHP Extension

- Nodejs && npm

## Instalaciòn

 - **Clonar el repositorio**

    ```$ git clone https://github.com/djvalecillo/courses.git```

 - **Intalar las dependencias del proyecto**

    ```$ composer install```

   ``` $ npm install```

 - **Generar un archivo .env**

    ```
    $ copy .env.example .env
    ```



 - **Generar una key para el proyecto**

	```
	$ php artisan key:generate
	```

 - **Crear una base de datos**

	Este procedimiento será diferente dependiendo de la base de datos que tengas. Dentro del proyecto se encuentran archivos para levantar contenedores docker entre ellos un servicio mysql que provee una tabla de nombre: **courses**, user: **root**, password: **rootpwd**, host: **bd** 

 - **Migrar y poblar la base de datos**
 
   ```$ php artisan migrate --seed```

 - **Correr pruebas automatizadas**

	```$ php artisan tests```

 - **Ingreso al sistema:**

	Los seeders generan una catidad de datos de prueba, entre ellos los necesarios para ingresar al sistema. asi 		que luego de correr el comando puede entrar al sistema con los siguientes datos:

	**email:** admin@example.com
	**password:** password
