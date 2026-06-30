<?php
session_start();
require_once('./funciones/funciones.php');
$error_login = "";

if ($_POST) {
    $bd = conexion();
    $stmt = $bd->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $_POST['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        session_regenerate_id(true); // Prevenir fijación de sesión
        $_SESSION['usuario'] = $user;
        setcookie('user_email', $user['email'], time() + 86400, "/");
        header('Location: index.php');
        exit;
    } else {
        $error_login = "El correo o la contraseña no coinciden.";
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
    <title>Login - Cine ISIL</title>
</head>
<body class="bg-dark text-white">
    <?php include_once('./partials/navBar.php') ?>

    <main class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 glass-panel p-3">
                    <div class="card-body">
                        <h3 class="text-center mb-4 font-weight-bold text-gold">
                            <i class="fas fa-user-lock"></i> Iniciar Sesión
                        </h3>
                        
                        <?php if($error_login): ?>
                            <div class="alert alert-danger border-0" style="background-color: rgba(220, 53, 69, 0.2); color: #ff8585;">
                                <i class="fas fa-exclamation-circle mr-1"></i> <?= e($error_login) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="form-group">
                                <label class="font-weight-bold">Correo Electrónico:</label>
                                <input type="email" name="email" class="form-control custom-input" 
                                       placeholder="correo@ejemplo.com"
                                       value="<?= e($_COOKIE['user_email'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Contraseña:</label>
                                <input type="password" name="password" class="form-control custom-input" 
                                       placeholder="Introduce tu contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-warning btn-block font-weight-bold py-2 mt-4 text-dark shadow-sm">
                                <i class="fas fa-sign-in-alt"></i> ENTRAR
                            </button>
                        </form>
                        <p class="mt-4 text-center mb-0 small text-muted">
                            ¿No tienes cuenta? <a href="registrarUsuario.php" class="text-warning font-weight-bold">Regístrate aquí</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once('./partials/footer.php') ?>
</body>
</html>