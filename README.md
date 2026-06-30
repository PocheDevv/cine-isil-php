# 🎬 Cine ISIL

Aplicación web para la gestión de una cartelera de películas, desarrollada en PHP con conexión a MySQL. Permite a los usuarios registrarse, iniciar sesión y administrar un catálogo de películas (CRUD completo), además de mostrar un carrusel con las películas mejor calificadas.

## Características

- Registro e inicio de sesión de usuarios con contraseñas hasheadas (`password_hash` / `password_verify`)
- Gestión de sesiones con protección contra fijación de sesión (`session_regenerate_id`)
- CRUD de películas: agregar, editar, eliminar y listar
- Carrusel de las 8 películas con mejor calificación en la página de inicio
- Diseño responsive con Bootstrap 4, Font Awesome y estilos propios

## Tecnologías

- PHP 8.2 (PDO para la conexión a base de datos)
- MySQL / MariaDB
- Bootstrap 4
- Font Awesome
- HTML5 / CSS3

## Requisitos

- XAMPP (o cualquier entorno con Apache, PHP y MySQL)
- PHP 8+
- MySQL/MariaDB

## Instalación

1. Clona este repositorio dentro de la carpeta `htdocs` de XAMPP:
```bash
   git clone https://github.com/PocheDevv/FINAL-ANTI.git
```
2. Inicia Apache y MySQL desde el panel de XAMPP.
3. Importa la base de datos desde phpMyAdmin usando el archivo `bd/cine_isil.sql`.
4. Verifica los datos de conexión en `funciones/funciones.php` (host, usuario y contraseña de MySQL) y ajústalos si es necesario.
5. Abre en el navegador:

## Autor

José Gabriel Rosas del Aguila — [@PocheDevv](https://github.com/PocheDevv)

Proyecto desarrollado como trabajo académico en ISIL.
