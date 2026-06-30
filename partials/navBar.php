<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
function e_nav($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top shadow">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="index.php">
             <i class="fas fa-film text-warning"></i> CINE ISIL
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCine">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarCine">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= $currentPage == 'index.php' ? 'active' : '' ?>">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item <?= $currentPage == 'peliculas.php' || $currentPage == 'agregar.php' || $currentPage == 'editar.php' ? 'active' : '' ?>">
                    <a class="nav-link" href="peliculas.php">Cartelera</a>
                </li>
                <li class="nav-item <?= $currentPage == 'nosotros.php' ? 'active' : '' ?>">
                    <a class="nav-link" href="nosotros.php">Nosotros</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <?php if(isset($_SESSION['usuario'])): ?>
                    <li class="nav-item mr-3">
                        <a class="btn btn-warning btn-sm mt-1 font-weight-bold" href="agregar.php">
                            <i class="fas fa-plus"></i> Agregar Película
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-white font-weight-bold">
                           <i class="fas fa-user-circle text-warning"></i> 
                           <?= e_nav($_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido']) ?>
                           <?php if ($_SESSION['usuario']['perfil'] == 1): ?>
                               <span class="badge badge-danger ml-1" style="font-size:0.7rem;">Admin</span>
                           <?php endif; ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger font-weight-bold" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Salir
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item <?= $currentPage == 'iniciarSesion.php' ? 'active' : '' ?>">
                        <a class="nav-link" href="iniciarSesion.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </li>
                    <li class="nav-item <?= $currentPage == 'registrarUsuario.php' ? 'active' : '' ?>">
                        <a class="nav-link text-info font-weight-bold" href="registrarUsuario.php">
                            <i class="fas fa-user-plus"></i> Registro
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>