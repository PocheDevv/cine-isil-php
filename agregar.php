<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Proteger página: Redirigir si no ha iniciado sesión
    if (!isset($_SESSION['usuario'])) {
        header('Location: iniciarSesion.php');
        exit;
    }
    include_once('./funciones/funciones.php');
    if($_POST){
        $bd = conexion();
        registrarPelicula($bd, $_POST);
    }
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="css/style.css">
    <title>Agregar Nueva Película - Cine ISIL</title>
</head>
<body class="bg-dark text-white">
    <?php include_once('./partials/navBar.php')?>

    <div class="container mt-5 pt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 bg-secondary-dark text-white glass-panel">
                    <div class="card-header bg-warning-gradient text-dark border-0">
                        <h3 class="mb-0 font-weight-bold"><i class="fas fa-plus-circle"></i> Registrar Nueva Película</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Nombre / Título</label>
                                    <input type="text" name="titulo" class="form-control custom-input" placeholder="Ej. El Origen" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Calificación (0 - 10)</label>
                                    <input type="number" step="0.1" min="0" max="10" name="rating" class="form-control custom-input" placeholder="Ej. 8.5" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Cantidad de Premios</label>
                                    <input type="number" min="0" name="premios" class="form-control custom-input" placeholder="Ej. 3">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Fecha de Estreno / Creación</label>
                                    <input type="date" name="fecha_estreno" class="form-control custom-input" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Duración (minutos)</label>
                                    <input type="number" min="0" name="duracion" class="form-control custom-input" placeholder="Ej. 120">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Género de la Película</label>
                                    <select name="genero_id" class="form-control custom-input" required>
                                        <option value="" disabled selected>Selecciona un género...</option>
                                        <option value="Acción">Acción</option>
                                        <option value="Comedia">Comedia</option>
                                        <option value="Drama">Drama</option>
                                        <option value="Terror">Terror</option>
                                        <option value="Suspenso">Suspenso</option>
                                        <option value="Thriller">Thriller</option>
                                        <option value="Sci-Fi">Ciencia Ficción</option>
                                        <option value="Anime">Anime</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">URL de la Imagen / Póster (Opcional)</label>
                                <input type="url" name="imagen_url" class="form-control custom-input" placeholder="https://ejemplo.com/poster.jpg o dejar vacío">
                                <small class="text-muted">Si no colocas una URL, se asignará un póster por defecto de nuestra base de datos.</small>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-warning btn-block font-weight-bold text-dark py-2 shadow-sm">
                                    <i class="fas fa-save mr-1"></i> Guardar Película
                                </button>
                                <a href="peliculas.php" class="btn btn-outline-light btn-block py-2">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('./partials/footer.php') ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>