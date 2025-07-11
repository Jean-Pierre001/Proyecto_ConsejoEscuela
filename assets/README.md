# Assets Folder

Esta carpeta contiene todos los recursos del proyecto, incluyendo estilos CSS, imagenes, fuentes, scripts de terceros, librerias externas, etc.

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
