<?php
// Si entran a esta página sin pasar por el formulario, los devolvemos al inicio
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$tituloPagina = 'Resultado del Registro - UTP';
$errores = [];

// Texto sin etiquetas, sin espacios de más (ni al inicio, ni al final, ni repetidos)
function limpiarTexto($valor) {
    $valor = trim(strip_tags($valor));
    return preg_replace('/\s+/', ' ', $valor);
}

$nombre         = limpiarTexto($_POST['nombre'] ?? '');
$apellido       = limpiarTexto($_POST['apellido'] ?? '');
$identificacion = limpiarTexto($_POST['identificacion'] ?? '');
$fechaTexto     = trim($_POST['fecha_nacimiento'] ?? '');
$sexo           = trim($_POST['sexo'] ?? '');

if ($nombre === '')         $errores[] = 'El nombre es obligatorio.';
if ($apellido === '')       $errores[] = 'El apellido es obligatorio.';
if ($identificacion === '') $errores[] = 'La identificación es obligatoria.';

// "sofía" -> "Sofía". Uso mb_ porque strtolower/ucwords se llevan mal con las tildes
$nombre         = mb_convert_case($nombre, MB_CASE_TITLE, 'UTF-8');
$apellido       = mb_convert_case($apellido, MB_CASE_TITLE, 'UTF-8');
$identificacion = strtoupper($identificacion);

if ($sexo !== 'Hombre' && $sexo !== 'Mujer') {
    $errores[] = 'Seleccione el sexo.';
}

// Fecha de nacimiento y edad (entre 18 y 70)
$edad = null;
$fechaNac = DateTime::createFromFormat('Y-m-d', $fechaTexto);

if (!$fechaNac || $fechaNac->format('Y-m-d') !== $fechaTexto) {
    $errores[] = 'La fecha de nacimiento no es válida.';
} else {
    $hoy = new DateTime('today');
    if ($fechaNac > $hoy) {
        $errores[] = 'La fecha de nacimiento no puede ser futura.';
    } else {
        $edad = $fechaNac->diff($hoy)->y;
        if ($edad < 18 || $edad > 70) {
            $errores[] = "La edad ($edad años) debe estar entre 18 y 70 años.";
        }
    }
}

// Foto: extensión permitida y su tipo real tienen que coincidir
$permitidas = [
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png'  => 'image/png',
    'gif'  => 'image/gif',
    'webp' => 'image/webp',
];
$extension = '';
$mime = '';
$foto = $_FILES['foto'] ?? null;

if ($foto === null || $foto['error'] === UPLOAD_ERR_NO_FILE) {
    $errores[] = 'Debe seleccionar una fotografía.';
} elseif ($foto['error'] !== UPLOAD_ERR_OK) {
    $errores[] = 'Ocurrió un problema al subir la fotografía. Intente de nuevo.';
} else {
    $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

    if (!isset($permitidas[$extension])) {
        $errores[] = 'La fotografía debe ser jpg, jpeg, png, gif o webp.';
    } elseif ($foto['size'] > 2 * 1024 * 1024) {
        $errores[] = 'La fotografía no puede pesar más de 2 MB.';
    } else {
        // No nos fiamos del nombre: miramos el contenido real del archivo
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($foto['tmp_name']);
        if ($mime !== $permitidas[$extension]) {
            $errores[] = 'El archivo no es una imagen válida.';
        }
    }
}

// Solo guardamos si todo lo anterior salió bien
$rutaFoto = '';
if (empty($errores)) {
    // Nombre aleatorio para que nadie pueda pisar o adivinar otro archivo
    $nombreFoto = bin2hex(random_bytes(8)) . '.' . $extension;
    $rutaFoto = __DIR__ . '/uploaded_files/' . $nombreFoto;

    if (!move_uploaded_file($foto['tmp_name'], $rutaFoto)) {
        $errores[] = 'No se pudo guardar la fotografía en el servidor.';
    }
}

include 'includes/header.php';
?>

<main class="flex-grow-1 py-4">
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

            <?php if (!empty($errores)): ?>

                <div class="alert alert-danger">
                    <h2 class="h5">No se pudo completar el registro</h2>
                    <ul class="mb-0">
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <a href="index.php" class="btn btn-secondary">Volver al formulario</a>

            <?php else: ?>

                <?php
                // La carpeta uploaded_files está bloqueada para el navegador,
                // así que la foto se muestra leyéndola desde PHP
                $fotoMostrar = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($rutaFoto));
                ?>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 text-center">
                        <h1 class="h4 text-success mb-3">Aspirante registrado correctamente</h1>

                        <img src="<?php echo $fotoMostrar; ?>" alt="Fotografía del aspirante"
                             class="img-thumbnail mb-3" style="max-width: 180px;">

                        <ul class="list-group text-start mb-3">
                            <li class="list-group-item"><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></li>
                            <li class="list-group-item"><strong>Apellido:</strong> <?php echo htmlspecialchars($apellido); ?></li>
                            <li class="list-group-item"><strong>Identificación:</strong> <?php echo htmlspecialchars($identificacion); ?></li>
                            <li class="list-group-item"><strong>Fecha de nacimiento:</strong> <?php echo $fechaNac->format('d/m/Y'); ?></li>
                            <li class="list-group-item"><strong>Edad:</strong> <?php echo $edad; ?> años</li>
                            <li class="list-group-item"><strong>Sexo:</strong> <?php echo htmlspecialchars($sexo); ?></li>
                        </ul>

                        <a href="index.php" class="btn btn-primary">Registrar otro aspirante</a>
                    </div>
                </div>

            <?php endif; ?>

            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>