
# Proyecto Consejo Escuela

Este proyecto es un sistema de gestión escolar desarrollado en **PHP**, pensado para gestionar carpetas, usuarios, escuelas e inspectores dentro de un entorno seguro, amigable y organizado.

---
## 0. Índice

1.  [Estructura General](#estructura-general)
2.  [Librerías y Tecnologías](#librerías-y-tecnologías)
3.  [Seguridad y Autenticación](#seguridad-y-autenticación)
4.  [Flujo de Trabajo y Componentes](#flujo-de-trabajo-y-componentes)
    - [Archivos Clave y Su Función](#archivos-clave-y-su-función)
    - [Cómo Funcionan los `includes/`](#cómo-funcionan-los-includes)
5.  [Base de Datos](#base-de-datos)
6.  [Cómo Empezar](#cómo-empezar)
7.  [Assets Folder](#assets-folder)
    - [Estructura de carpetas](#estructura-de-carpetas)
    - [Cómo usar](#cómo-usar)
8.  [Características Adicionales](#características-adicionales)
9.  [🖼️ Estética y Usabilidad](#️estética-y-usabilidad)
10. [📄 Licencia](#️licencia)

---

## 1. Estructura General

```
Proyecto_ConsejoEscuela/
├── assets/                  # Recursos como imágenes, estilos CSS y librerias 
   ├── images/               # Aqui se encuentran todas las imagenes del proyecto
   ├── vendor/               # Librerias externas como TCPDF
   ├── custom/               # Archivos CSS custom para este proyecto
├── BACKUP_DATABASE/         # Scripts de respaldo de la base de datos
├── folders/                 # Contenedor físico de carpetas institucionales
├── trash/                   # Papelera lógica y física de carpetas eliminadas
├── includes/                # Módulos reutilizables: conexión, sesión, headers
   ├── modals/               # Incluyen todos los modals del sistema 
├── inspectores_back/        # Logica separada de inspectores
├── schools_back/            # Logica separada de escuela
├── *.php                    # Páginas funcionales (login, perfil, CRUD, etc.)
```

---

## 2. Librerías y Tecnologías

- **PHP 7+**
- **MySQL**
- **Bootstrap 3.4.1**
- **PDO** (consultas preparadas seguras)
- **FontAwesome + Glyphicons**
- **TCPDF**
- **HTML5 + CSS3**

---

## 3. Seguridad y Autenticación

- Uso de `password_hash()` y `password_verify()` para contraseñas.
- Gestión de sesión personalizada en `includes/session.php`.
- Control de acceso basado en tipo de usuario (`admin` y `usuario`).
- Verificación de contraseña antes de actualizar el perfil.

---

## 4. Flujo de Trabajo y Componentes

### Archivos Clave y Su Función

| Archivo                  | Descripción |
|--------------------------|-------------|
| `index.php`              | Página principal post-login. Muestra datos del usuario y mensaje de bienvenida. |
| `login.php`              | Formulario de acceso. Redirige si ya está logueado. Usa `verify.php`. |
| `verify.php`             | Valida las credenciales del login y redirige según el tipo de usuario. |
| `logout.php`             | Finaliza la sesión del usuario. |
| `create_admin.php`       | Crea manualmente un usuario administrador en la base de datos. |
| `folders.php`            | Muestra todas las carpetas creadas, con búsqueda y opción de eliminar. |
| `detailsfolders.php`     | Muestra detalles del contenido de una carpeta. |
| `delete_folder.php`      | Envía una carpeta a la papelera (`trash/`). |
| `restore_folder.php`     | Restaura carpetas desde la papelera a `folders/`. |
| `trash.php`              | Lista carpetas eliminadas, permite restaurar o borrar definitivamente. |
| `inspectors.php`         | Gestión de inspectores (nombre, institución, etc.). |
| `schools.php`            | Gestión de escuelas registradas. |
| `profile_update.php`     | Actualiza datos del usuario, incluyendo contraseña y foto. |

---

### Cómo Funcionan los `includes/`

| Archivo                  | Propósito |
|--------------------------|----------|
| `includes/conn.php`      | Conexión PDO a MySQL. Se reutiliza en todo el sistema. |
| `includes/session.php`   | Inicia sesión y controla si el usuario está logueado. |
| `includes/header.php`    | `<head>` común para todas las páginas. Incluye Bootstrap, meta tags, etc. |
| `includes/navbar.php`    | Barra de navegación superior (menu superior del sistema). |
| `includes/sidebar.php`   | Menú lateral con enlaces a módulos del sistema. |
| `includes/footer.php`    | Pie de página común. |
| `includes/scripts.php`   | Scripts JS comunes al final del `<body>` (jQuery, Bootstrap JS, etc.). |

Todas las páginas llaman a estos includes al inicio para mantener una estructura consistente y evitar repetir código.

---

## 5. Base de Datos

- Nombre de la base: `consejo`
- Tabla principal de usuarios: `users`
- Otros módulos pueden usar tablas como `folders`, `inspectors`, `schools`, etc.
- La conexión se configura en `includes/conn.php`:

```php
$pdo = new PDO("mysql:host=localhost;dbname=consejo;charset=utf8mb4", "root", "");
```

---

## 6. Cómo Empezar

1. Clona o descomprime el proyecto en tu servidor local:
   ```bash
   git clone <repositorio>
   ```
2. Crea la base de datos `consejo` en MySQL.
3. Importa los scripts SQL desde `BACKUP_DATABASE/`.
4. Edita `includes/conn.php` con tus credenciales.
5. Ejecuta `create_admin.php` para crear un usuario administrador.
6. Accede mediante `login.php` con:
   - **Email:** admin@admin
   - **Contraseña:** 123

---

# 7. Assets Folder

Esta carpeta contiene todos los recursos del proyecto, incluyendo estilos CSS, imagenes, fuentes, scripts de terceros, librerias externas, etc. Existen reglas para su correcta utilizacion

---

## Estructura de carpetas

- **assets/**  
  Contiene todos los archivos relacionados con estilos y librerias externas.

  - **vendor/**  
    Aquí se almacenan las librerías y frameworks externos, como Bootstrap, FontAwesome, etc.  
    _Ejemplo_: `tcpdf.php`

  - **custom/**  
    Estilos CSS personalizados creados específicamente para este proyecto.  
    _Ejemplo_: `login.css`, `main.css`

    - **images/**  
    Aqui se almacenan las imagenes usadas en el proyecto.  
    _Ejemplo_: `persona1.png`

---

## Cómo usar

- Para incluir librerias externas (como tcpdf), se requiere `require_once 'assets/vendor/tcpdf/';`.
- Para estilos propios, enlazar desde `assets/custom/`.
- Para incluir imagenes, enlazar desde `assets/images/`.

Ejemplo:

```html
<link rel="stylesheet" href="assets/vendor/tcpdf.php">
<link rel="stylesheet" href="assets/custom/login.css">
<img src="assets/custom/imagen.png" alt="Descripción de la imagen">

## 8. Características Adicionales

- Panel de bienvenida con nombre y rol.
- Vista de carpetas con íconos, ubicación y acciones.
- Papelera con restauración de elementos.
- Cambios de contraseña protegidos por verificación.
- Carga de foto de perfil con eliminación de la antigua.

---

## 9. Estética y Usabilidad

- Estilo limpio y responsivo usando Bootstrap.
- Íconos de carpeta (`glyphicon-folder-open`) para visualización intuitiva.
- Alertas para errores y éxitos en acciones (registro, login, edición).

---

## 10. Licencia

Este proyecto es de uso educativo. Puedes adaptarlo, mejorarlo y usarlo libremente.
