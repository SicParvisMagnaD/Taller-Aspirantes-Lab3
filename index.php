<?php
$tituloPagina = 'Registro de Aspirantes - UTP';
include 'includes/header.php';
?>

<main class="flex-grow-1 py-4">
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">

                <h1 class="h4 text-center fw-bold mb-3">Formulario de Registro de Aspirantes</h1>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <form action="procesar.php" method="POST" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label for="nombre" class="form-label fw-semibold">Nombre (Requerido):</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                       placeholder="Ej: Sofía" required>
                            </div>

                            <div class="mb-3">
                                <label for="apellido" class="form-label fw-semibold">Apellido (Requerido):</label>
                                <input type="text" class="form-control" id="apellido" name="apellido"
                                       placeholder="Ej: Pérez" required>
                            </div>

                            <div class="mb-3">
                                <label for="identificacion" class="form-label fw-semibold">Identificación (Requerido):</label>
                                <input type="text" class="form-control" id="identificacion" name="identificacion"
                                       placeholder="Ej: 8-123-4567" required>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_nacimiento" class="form-label fw-semibold">Fecha de Nacimiento (Requerido):</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                       max="<?php echo date('Y-m-d'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <span class="form-label fw-semibold d-block">Sexo (Requerido):</span>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="sexo" id="sexo_h" value="Hombre" required>
                                        <label class="btn btn-outline-secondary w-100" for="sexo_h">Hombre</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="sexo" id="sexo_m" value="Mujer">
                                        <label class="btn btn-outline-secondary w-100" for="sexo_m">Mujer</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="foto" class="form-label fw-semibold">
                                    Fotografía del Aspirante (png, jpg, jpeg, gif, webp):
                                </label>
                                <input type="file" class="form-control" id="foto" name="foto"
                                       accept=".png,.jpg,.jpeg,.gif,.webp" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Registrar Aspirante</button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>