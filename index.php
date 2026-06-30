<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include_once('./funciones/funciones.php');
    $bd = conexion();
    
    // Consultar las 8 películas con mayor calificación
    $stmt = $bd->prepare("SELECT * FROM movies ORDER BY calificacion DESC, id DESC LIMIT 8");
    $stmt->execute();
    $peliculasDestacadas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Dividir las películas en grupos de 4 para los slides del carrusel
    $chunkedPeliculas = array_chunk($peliculasDestacadas, 4);
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

    <title>Inicio - Cine ISIL</title>
</head>
<body class="bg-dark text-white">

    <?php include_once('./partials/navBar.php') ?>

    <main>

        <!-- HERO -->
        <header class="hero-cine">
            <div class="text-center position-relative" style="z-index: 2; max-width: 800px; padding: 0 20px;">
                <h1 class="display-3 font-weight-bold mb-3">Mundo Cine ISIL</h1>
                <p class="lead text-light mb-4" style="font-size: 1.25rem;">
                    Gestiona tus películas favoritas, califica los últimos estrenos y vive la magia del séptimo arte en comunidad.
                </p>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="agregar.php" class="btn btn-warning btn-lg shadow-lg font-weight-bold px-4 py-3">
                        <i class="fas fa-plus mr-2"></i> Agregar Película
                    </a>
                <?php else: ?>
                    <a href="iniciarSesion.php" class="btn btn-warning btn-lg shadow-lg font-weight-bold px-4 py-3">
                        <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                    </a>
                <?php endif; ?>
            </div>
        </header>

        <!-- PELÍCULAS DESTACADAS -->
        <section class="container my-5 pb-5">
            <h2 class="text-center mb-2 font-weight-bold text-uppercase text-gold">
                Películas Destacadas
            </h2>
            <p class="text-center text-muted mb-5">Las películas mejor calificadas por nuestra comunidad de cinéfilos.</p>
 
            <div id="movieCarousel" class="carousel slide" data-ride="carousel" data-interval="6000">
                <div class="carousel-inner">
                    <?php if (count($chunkedPeliculas) > 0): ?>
                        <?php foreach ($chunkedPeliculas as $index => $grupo): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="row">
                                    <?php foreach ($grupo as $peli): ?>
                                        <?php 
                                            $poster = !empty($peli['imagen_url']) ? $peli['imagen_url'] : 'img/cinema.jpg'; 
                                        ?>
                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card shadow h-100 border-0 movie-card">
                                                <div style="position: relative; overflow: hidden;">
                                                    <img src="<?= e($poster) ?>" class="card-img-top" alt="<?= e($peli['titulo']) ?>" style="height:300px; object-fit:cover;">
                                                    <span class="badge badge-warning" style="position: absolute; top: 10px; right: 10px; font-weight:800; font-size:0.95rem; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
                                                        <i class="fas fa-star"></i> <?= e($peli['calificacion']) ?>
                                                    </span>
                                                </div>
                                                <div class="card-body text-center p-3 bg-secondary-dark">
                                                    <h5 class="card-title font-weight-bold text-truncate mb-1" title="<?= e($peli['titulo']) ?>">
                                                        <?= e($peli['titulo']) ?>
                                                    </h5>
                                                    <span class="badge badge-pill badge-dark border border-secondary text-muted" style="font-size:0.75rem;">
                                                        <?= e($peli['genero']) ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <!-- Rellenar columnas vacías para alineación si es el último grupo -->
                                    <?php 
                                        $completar = 4 - count($grupo);
                                        for ($i = 0; $i < $completar; $i++):
                                    ?>
                                        <div class="col-md-3 col-sm-6 mb-4 d-none d-md-block">
                                            <div class="card h-100 border-0 bg-transparent"></div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="carousel-item active">
                            <div class="text-center py-5 glass-panel">
                                <i class="fas fa-film text-muted fa-4x mb-3"></i>
                                <h4 class="text-muted">Aún no hay películas registradas en la base de datos.</h4>
                                <?php if (isset($_SESSION['usuario'])): ?>
                                    <a href="agregar.php" class="btn btn-warning mt-3 font-weight-bold">Agregar Película</a>
                                <?php else: ?>
                                    <a href="iniciarSesion.php" class="btn btn-warning mt-3 font-weight-bold">Iniciar Sesión para Agregar</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- CONTROLES (Solo si hay más de 4 películas) -->
                <?php if (count($peliculasDestacadas) > 4): ?>
                    <a class="carousel-control-prev" href="#movieCarousel" role="button" data-slide="prev" style="width:5%;">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#movieCarousel" role="button" data-slide="next" style="width:5%;">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                <?php endif; ?>

            </div>
        </section>

    </main>

    <?php include_once('./partials/footer.php') ?>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
