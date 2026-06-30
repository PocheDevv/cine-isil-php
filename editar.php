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
    $bd = conexion();
    
    $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
    if (!$id) {
        header('Location: peliculas.php');
        exit;
    }
    
    // Obtener película
    $stmt = $bd->prepare("SELECT * FROM movies WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$pelicula) {
        header('Location: peliculas.php');
        exit;
    }
    
    if($_POST){
        editarPelicula($bd, $_POST, $id);
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
    <title>Editar Película - Cine ISIL</title>
</head>
<body class="bg-dark text-white">
    <?php include_once('./partials/navBar.php')?>

    <div class="container mt-5 pt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 bg-secondary-dark text-white glass-panel">
                    <div class="card-header bg-warning-gradient text-dark border-0">
                        <h3 class="mb-0 font-weight-bold"><i class="fas fa-edit"></i> Editar Película: <?= e($pelicula['titulo']) ?></h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Nombre / Título</label>
                                    <input type="text" name="titulo" class="form-control custom-input" value="<?= e($pelicula['titulo']) ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Calificación (0 - 10)</label>
                                    <input type="number" step="0.1" min="0" max="10" name="rating" class="form-control custom-input" value="<?= e($pelicula['calificacion']) ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Cantidad de Premios</label>
                                    <input type="number" min="0" name="premios" class="form-control custom-input" value="<?= e($pelicula['premios']) ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Fecha de Estreno / Creación</label>
                                    <input type="date" name="fecha_estreno" class="form-control custom-input" value="<?= e($pelicula['fechaCreacion']) ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Duración (minutos)</label>
                                    <input type="number" min="0" name="duracion" class="form-control custom-input" value="<?= e($pelicula['duracion']) ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Género de la Película</label>
                                    <select name="genero_id" class="form-control custom-input" required>
                                        <?php 
                                            $generos = ["Acción", "Comedia", "Drama", "Terror", "Suspenso", "Thriller", "Sci-Fi", "Anime"];
                                            foreach($generos as $gen):
                                        ?>
                                            <option value="<?= $gen ?>" <?= $pelicula['genero'] == $gen ? 'selected' : '' ?>><?= $gen ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">URL de la Imagen / Póster (Opcional)</label>
                                <input type="url" name="imagen_url" class="form-control custom-input" value="<?= e($pelicula['imagen_url']) ?>" placeholder="https://ejemplo.com/poster.jpg">
                                <?php if (!empty($pelicula['imagen_url'])): ?>
                                    <div class="mt-2 text-center">
                                        <p class="small text-muted mb-1">Vista previa del póster actual:</p>
                                        <img src="<?= e($pelicula['imagen_url']) ?>" alt="Póster" class="rounded border border-warning" style="height: 150px; object-fit: cover;">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-warning btn-block font-weight-bold text-dark py-2 shadow-sm">
                                    <i class="fas fa-save mr-1"></i> Guardar Cambios
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
