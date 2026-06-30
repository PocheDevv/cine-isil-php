<?php
require_once('./funciones/funciones.php');
$errores = [];

if ($_POST) {
    $bd = conexion();
    $resultado = registrarUsuario($bd, $_POST);
    
    if ($resultado === true) {
        header('Location: iniciarSesion.php');
        exit;
    } else {
        $errores = $resultado;
    }
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
    <title>Registro - Cine ISIL</title>
</head>
<body class="bg-dark text-white">
    <?php include_once('./partials/navBar.php') ?>

    <main class="container py-5 mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 glass-panel p-3">
                    <div class="card-body">
                        <h2 class="text-center mb-4 font-weight-bold text-gold">
                            <i class="fas fa-user-plus"></i> Crea tu Cuenta
                        </h2>
                        
                        <?php foreach($errores as $error): ?>
                            <div class="alert alert-danger border-0" style="background-color: rgba(220, 53, 69, 0.2); color: #ff8585;">
                                <i class="fas fa-exclamation-circle mr-1"></i> <?= e($error) ?>
                            </div>
                        <?php endforeach; ?>

                        <form method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Nombre:</label>
                                    <input type="text" name="nombre" class="form-control custom-input" placeholder="Tu nombre" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold">Apellido:</label>
                                    <input type="text" name="apellido" class="form-control custom-input" placeholder="Tu apellido" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Correo Electrónico:</label>
                                <input type="email" name="email" class="form-control custom-input" placeholder="correo@ejemplo.com" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Contraseña (Mín. 8 caracteres):</label>
                                <input type="password" name="password" class="form-control custom-input" placeholder="Crea una contraseña segura" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Tipo de Perfil:</label>
                                <select name="perfil" class="form-control custom-input">
                                    <option value="2">Usuario Final</option>
                                    <option value="1">Administrador</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning btn-block font-weight-bold py-2 mt-4 text-dark shadow-sm">
                                REGISTRARSE
                            </button>
                        </form>
                        <p class="mt-4 text-center mb-0 small text-muted">
                            ¿Ya tienes una cuenta? <a href="iniciarSesion.php" class="text-warning font-weight-bold">Inicia sesión aquí</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once('./partials/footer.php') ?>
</body>
</html>