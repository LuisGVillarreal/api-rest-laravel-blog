<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## API Blog

### Descripción:

La API del blog es una interfaz que permite interactuar con el sistema de un blog mediante una serie de solicitudes. Proporciona diversas funcionalidades, como el registro de usuarios, la gestión de categorías, la publicación y actualización de posts, y la obtención de información detallada sobre usuarios, categorías y posts.

Puedes ver los endpoints [aquí](https://documenter.getpostman.com/view/25432378/2s93zCY17t).

A continuación, se detallan los títulos y descripciones de las solicitudes disponibles:

---

#### Usuarios:

1. **Registro de usuario** (*POST* - `/api/register`):
   Esta solicitud permite registrar a un nuevo usuario en el sistema del blog.

2. **Inicio de sesión** (*POST* - `/api/login`):
   Esta solicitud permite a un usuario autenticarse en el sistema del blog.

3. **Obtener detalles de un usuario** (*GET* - `/api/user/detail/{id}`):
   Esta solicitud devuelve información detallada sobre un usuario específico en el sistema del blog.

4. **Obtener avatar de un usuario** (*GET* - `/api/user/avatar/{filename}`):
   Esta solicitud recupera el avatar de un usuario en el sistema del blog.

5. **Subir avatar de un usuario** (*POST* - `/api/user/upload`):
   Esta solicitud permite a un usuario cargar un avatar en el sistema del blog.

6. **Actualizar información de un usuario** (*PUT* - `/api/user/update`):
   Esta solicitud actualiza la información de un usuario específico en el sistema del blog.

---

#### Categorías:

1. **Guardar una categoría** (*POST* - `/api/category`):
   Esta solicitud guarda una nueva categoría en el sistema del blog.

2. **Actualizar una categoría** (*PUT* - `/api/category/{id}`):
   Esta solicitud actualiza el nombre de una categoría existente en el sistema del blog.

3. **Obtener detalles de una categoría** (*GET* - `/api/category/{id}`):
   Esta solicitud devuelve información detallada sobre una categoría específica en el sistema del blog.

4. **Obtener todas las categorías** (*GET* - `/api/category`):
   Esta solicitud devuelve una lista de todas las categorías disponibles en el sistema del blog.

---

#### Posts:

1. **Guardar un post** (*POST* - `/api/post`):
   Esta solicitud guarda un nuevo post en el sistema del blog.

2. **Actualizar un post** (*PUT* - `/api/post/{id}`):
   Esta solicitud actualiza los detalles de un post específico en el sistema del blog.

3. **Eliminar un post** (*DELETE* - `/api/post/{id}`):
   Esta solicitud elimina un post específico del sistema del blog.

4. **Obtener una imagen de un post** (*GET* - `/api/post/image/{filename}`):
   Esta solicitud recupera una imagen asociada a un post en el sistema del blog.

5. **Obtener detalles de un post** (*GET* - `/api/post/{id}`):
   Esta solicitud devuelve información detallada sobre un post específico en el sistema del blog.

6. **Obtener todos los posts** (*GET* - `/api/post`):
   Esta solicitud devuelve una lista de todos los posts disponibles en el sistema del blog.

7. **Obtener posts por categoría** (*GET* - `/api/post/category/{id}`):
   Esta solicitud devuelve una lista de posts asociados a una categoría específica en el sistema del blog.

8. **Obtener posts por usuario** (*GET* - `/api/post/user/{id}`):
   Esta solicitud devuelve una lista de posts asociados a un usuario específico en el sistema del blog.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
