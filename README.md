# Pasos para clonar el repositorio del proyecto

1. Clonar el repositorio
```bash
git clone https://github.com/urlRepositorio <- url de prueba
```
2. Instalar dependencias
```bash
cd blog
composer install
```
3. Generar llave de seguridad
```bash
php artisan key:generate
```

4. Crear la base de datos (si es SQLite)
Crear el archivo database/database.sqlite

5. Correr las migraciones
```bash	
php artisan migrate:fresh --seed
```

6. Ingresar al sistema con los usuarios por defecto creados en el seed

Username: test@example.com
Password: secret

7. El enlace principal de la pagina es:

[URL de la web](http://localhost/laravel/todolist-one/public/)

