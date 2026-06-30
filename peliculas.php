<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include_once('./funciones/funciones.php');
    $bd = conexion(); // Conexión a cine_isil
    
    // Obtener filtros del GET
    $buscar = trim($_GET['buscar'] ?? '');
    $genero = trim($_GET['genero'] ?? '');
    
    // Consulta dinámica de películas
    $sql = "SELECT * FROM movies WHERE 1=1";
    $params = [];
    
    if ($buscar !== '') {
        $sql .= " AND titulo LIKE :buscar";
        $params[':buscar'] = "%$buscar%";
    }
    
    if ($genero !== '') {
        $sql .= " AND genero = :genero";
        $params[':genero'] = $genero;
    }
    
    $sql .= " ORDER BY id DESC";
    $stmt = $bd->prepare($sql);
    $stmt->execute($params);
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Obtener todos los géneros únicos para el filtro
    $stmtGen = $bd->query("SELECT DISTINCT genero FROM movies WHERE genero IS NOT NULL AND genero != '' ORDER BY genero ASC");
    $generosDisponibles = $stmtGen->fetchAll(PDO::FETCH_COLUMN);
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
    <title>Cartelera - Cine ISIL</title>
</head>
<body class="bg-dark text-white">

    <?php include_once('./partials/navBar.php')?>

    <main class="container py-5 mt-5">
        <!-- Encabezado -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 font-weight-bold mb-2">Cartelera Comunidad</h1>
                <p class="lead text-muted">Explora y gestiona las películas compartidas por los amantes del cine en nuestra comunidad.</p>
            </div>
            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="agregar.php" class="btn btn-warning btn-lg shadow-sm font-weight-bold">
                        <i class="fas fa-plus"></i> Nueva Película
                    </a>
                <?php else: ?>
                    <a href="iniciarSesion.php" class="btn btn-outline-warning font-weight-bold">
                        Inicia Sesión para Agregar
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <hr class="border-secondary mb-5">

        <!-- Buscador y Filtros -->
        <div class="card border-0 glass-panel mb-5 shadow">
            <div class="card-body p-4">
                <form method="GET" class="form-row align-items-end">
                    <div class="form-group col-md-5 mb-3 mb-md-0">
                        <label class="font-weight-bold small text-gold text-uppercase">Buscar por título</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-right-0 text-muted" style="border-color: rgba(255,255,255,0.1);">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" name="buscar" class="form-control custom-input border-left-0" 
                                   placeholder="Ej. Interstellar, Fight Club..." 
                                   value="<?= e($buscar) ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-4 mb-3 mb-md-0">
                        <label class="font-weight-bold small text-gold text-uppercase">Filtrar por Género</label>
                        <select name="genero" class="form-control custom-input">
                            <option value="">Todos los géneros</option>
                            <?php foreach ($generosDisponibles as $g): ?>
                                <option value="<?= e($g) ?>" <?= $genero === $g ? 'selected' : '' ?>><?= e($g) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-0 d-flex">
                        <button type="submit" class="btn btn-warning btn-block font-weight-bold py-2 mr-2">
                            Filtrar
                        </button>
                        <?php if ($buscar !== '' || $genero !== ''): ?>
                            <a href="peliculas.php" class="btn btn-outline-light py-2 px-3" title="Limpiar Filtros">
                                <i class="fas fa-times"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Listado en Cards -->
        <?php if (count($peliculas) > 0): ?>
            <div class="row">
                <?php foreach($peliculas as $peli): ?>
                    <?php 
                        // Resolver póster
                        $poster = !empty($peli['imagen_url']) ? $peli['imagen_url'] : 'img/cinema.jpg';
                    ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 movie-card shadow-sm">
                            <div style="position: relative; overflow: hidden;">
                                <img src="<?= e($poster) ?>" class="card-img-top" alt="<?= e($peli['titulo']) ?>" style="height:320px; object-fit:cover;">
                                <span class="badge badge-warning" style="position: absolute; top: 10px; right: 10px; font-weight:800; font-size:0.9rem; padding: 6px 10px; border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
                                    <i class="fas fa-star"></i> <?= e($peli['calificacion']) ?>
                                </span>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between p-3 bg-secondary-dark">
                                <div>
                                    <h5 class="card-title font-weight-bold mb-2 text-truncate" title="<?= e($peli['titulo']) ?>">
                                        <?= e($peli['titulo']) ?>
                                    </h5>
                                    <span class="badge badge-pill badge-dark border border-secondary text-muted" style="font-size:0.75rem;">
                                        <?= e($peli['genero']) ?>
                                    </span>
                                </div>
                                
                                <div class="mt-3 pt-3 border-top border-secondary text-muted small">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span><i class="far fa-clock mr-1"></i> <?= e($peli['duracion']) ?> min</span>
                                        <span><i class="fas fa-trophy text-warning mr-1"></i> <?= e($peli['premios']) ?></span>
                                    </div>
                                    <div>
                                        <i class="far fa-calendar-alt mr-1"></i> Estreno: <?= e($peli['fechaCreacion']) ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botones de Acción -->
                            <?php if (isset($_SESSION['usuario'])): ?>
                                <div class="card-footer bg-secondary-dark border-0 d-flex justify-content-between pt-0 pb-3">
                                    <a href="editar.php?id=<?= $peli['id'] ?>" class="btn btn-sm btn-outline-warning font-weight-bold flex-fill mr-1">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <?php if ($_SESSION['usuario']['perfil'] == 1): ?>
                                        <a href="eliminar.php?id=<?= $peli['id'] ?>" 
                                           class="btn btn-sm btn-outline-danger font-weight-bold flex-fill ml-1"
                                           onclick="return confirm('¿Estás seguro de que deseas eliminar permanentemente la película &quot;<?= e($peli['titulo']) ?>&quot;?');">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5 glass-panel">
                <i class="fas fa-film text-muted fa-4x mb-3"></i>
                <h3 class="text-muted">No se encontraron películas en la cartelera</h3>
                <p class="text-muted mb-4">Intenta ajustar los criterios de búsqueda o filtros.</p>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="agregar.php" class="btn btn-warning font-weight-bold">
                        ¡Sé el primero en agregar una!
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>

    <?php include_once('./partials/footer.php') ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>