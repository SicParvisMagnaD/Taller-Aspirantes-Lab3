# 📝 Laboratorio #3 - Registro de Aspirantes con PHP

Este repositorio contiene el taller que desarrollé en el Laboratorio #3: un formulario de registro de aspirantes hecho con HTML5 y Bootstrap, que se procesa en el servidor con PHP. El formulario recibe los datos, los valida, los deja con un formato uniforme y guarda la fotografía del aspirante sin usar base de datos.

Temas que se practicaron:

- Estructura de un documento HTML5 y etiquetas semánticas (`<header>`, `<main>`, `<section>`, `<footer>`)
- Formularios HTML y sus elementos
- Bootstrap v5.3.8
- Modularización con `include` (menú, migas de pan y pie de página)
- Manejo de formularios con GET y POST
- Validaciones y seguridad en PHP
- Subida de archivos

---

## 🌐 Tecnologías utilizadas

- PHP
- HTML5
- Bootstrap v5.3.8
- Apache (a través de WampServer)
- WampServer

---

## ⚙️ Requisitos

Se necesita un entorno local con servidor web y soporte para PHP. En mi caso trabajé con **WampServer**, que reúne Apache, MySQL y PHP en una sola instalación para Windows (en este taller MySQL no se usa).

📌 **Nota:** el proyecto necesita PHP 7.1 o superior con las extensiones `mbstring` y `fileinfo` activas. WampServer las trae habilitadas por defecto.

**Editor de Código:**
- Visual Studio Code

---

## 📁 Estructura del proyecto

```
Taller-Aspirantes/
├── includes/
│   ├── header.php      → metadatos, navbar y migas de pan dinámicas
│   └── footer.php      → pie de página con año dinámico
├── uploaded_files/
│   ├── .gitkeep        → para que Git conserve la carpeta vacía
│   └── .htaccess       → bloquea el acceso desde el navegador
├── index.php           → formulario de registro
├── procesar.php        → validación, formato y guardado de la foto
└── README.md
```

---

## ✅ Qué hace cada archivo

**`includes/header.php`**
Abre el HTML con los metadatos (`charset`, `viewport`, `description`, `author`, `robots` y `theme-color`), carga Bootstrap 5.3.8 y dibuja la barra de navegación. Las migas de pan cambian solas según la página: con `basename($_SERVER['PHP_SELF'])` detecta si estamos en `index.php` o en `procesar.php`.

**`includes/footer.php`**
Pie de página con el eslogan institucional, enlaces rápidos y el copyright con el año actual usando `date('Y')`. Cierra las etiquetas `</body>` y `</html>` que el header deja abiertas.

**`index.php`**
Contiene el formulario dentro de `<main><section>`. Usa `method="POST"` y `enctype="multipart/form-data"` para que la imagen pueda viajar al servidor. Todos los campos son obligatorios y llevan `placeholder`.

**`procesar.php`**
Recibe los datos del formulario y hace lo siguiente:

1. Limpia los textos con `trim()` y `strip_tags()`.
2. Pone nombre y apellido en formato título (por ejemplo, `sofía` pasa a `Sofía`) y la identificación en mayúsculas.
3. Calcula la edad a partir de la fecha de nacimiento y comprueba que esté entre 18 y 70 años.
4. Valida la fotografía: extensión permitida (`jpg`, `jpeg`, `png`, `gif`, `webp`), tamaño máximo de 2 MB y tipo real del archivo.
5. Guarda la foto en `uploaded_files/` con un nombre aleatorio.
6. Muestra el resultado, o la lista de errores si algo falló. Todo lo que se imprime pasa por `htmlspecialchars()`.

---

## 🔒 Seguridad

| Riesgo | Cómo se controla |
|---|---|
| Código HTML o JavaScript en los campos (XSS) | `strip_tags()` al recibir y `htmlspecialchars()` al mostrar |
| Archivo malicioso con extensión de imagen | Se revisa el contenido real con `finfo`, no solo el nombre |
| Subir archivos como `.php` | Solo se aceptan extensiones de imagen de una lista permitida |
| Acceder a las fotos desde el navegador | `.htaccess` con `Require all denied` en `uploaded_files/` |
| Sobrescribir o adivinar archivos | El nombre se reemplaza por uno aleatorio con `random_bytes()` |
| Entrar a `procesar.php` sin formulario | Si el método no es POST, redirige a `index.php` |

---

## 📋 Cumplimiento de la rúbrica

| Requerimiento | Dónde se cumple |
|---|---|
| Interfaz con Bootstrap y etiquetas semánticas | `index.php`, `procesar.php` y `includes/` |
| Formulario dentro de `<main><section>` | `index.php` |
| Menú y migas de pan modulares con `include` | `includes/header.php` |
| Edad entre 18 y 70 años | `procesar.php` |
| Nombre y apellido en formato título | `procesar.php` |
| Foto guardada sin base de datos | `procesar.php` → `uploaded_files/` |
| Carpeta de fotos inaccesible desde el navegador | `uploaded_files/.htaccess` |
| Footer con año dinámico | `includes/footer.php` |

---

## 📊 Estadísticas

| Creado | Watchers | Visitors |
|---|---|---|
| 01-10-2026 | 0 | 1 |

---

## 🛠️ Cómo usar este repositorio

1. Clona el repositorio y colócalo dentro de la carpeta `www` de WampServer (o `htdocs` si usas XAMPP):

```bash
git clone https://github.com/SicParvisMagnaD/Taller-Aspirantes.git
```

2. Con el servidor activo, accede desde el navegador a:

   `http://localhost/Taller-Aspirantes/` o `http://127.0.0.1/Taller-Aspirantes/`

3. Para comprobar que la carpeta de fotos está protegida, registra un aspirante y luego intenta abrir `http://localhost/Taller-Aspirantes/uploaded_files/` en el navegador. Debe aparecer **403 Forbidden**.

📌 Si la carpeta de fotos sí se abre, revisa que `AllowOverride` esté en `All` en la configuración de Apache, porque sin eso el `.htaccess` se ignora.

---

## 👤 Autor

**Javier Vallarino**<br>
Estudiante de Licenciatura en Ciberseguridad<br>

Universidad Tecnológica de Panamá <br>
Facultad de Sistemas Computacionales<br>
Grupo: 1S3122<br>
Unidad: Diseño Web con HTML5 y CSS3 / Programación de Aplicaciones Web<br>
II Semestre<br>

📧 Email: javier.vallarino@utp.ac.pa<br>
🌐 GitHub: [SicParvisMagnaD](https://github.com/SicParvisMagnaD)