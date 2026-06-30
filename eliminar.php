<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Proteger página: Redirigir si no ha iniciado sesión o si no es administrador
if (!isset($_SESSION['usuario'])) {
    header('Location: iniciarSesion.php');
    exit;
}

// Solo perfil = 1 (Administrador) tiene permisos de eliminación
if ($_SESSION['usuario']['perfil'] != 1) {
    header('Location: peliculas.php');
    exit;
}

include_once('./funciones/funciones.php');

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if ($id) {
    $bd = conexion();
    
    // Validar si la película existe antes de borrar
    $stmt = $bd->prepare("SELECT id FROM movies WHERE id = :id");
    $stmt->execute([':id' => $id]);
    if ($stmt->fetch()) {
        eliminarPelicula($bd, $id);
    }
}

header('Location: peliculas.php');
exit;
?>
