<?php
function conexion() {
    $host = 'localhost';
    $bd = 'cine_isil';
    $port = 3306;
    $usuario = 'root';
    $password = ''; // Tu contraseña de MySQL
    
    try {
        $db = new PDO("mysql:dbname=$bd;host=$host;port=$port", $usuario, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Migración dinámica de base de datos
        $check = $db->query("SHOW COLUMNS FROM `movies` LIKE 'imagen_url'");
        if ($check->rowCount() == 0) {
            $db->exec("ALTER TABLE `movies` ADD `imagen_url` VARCHAR(255) DEFAULT NULL");
            $db->exec("ALTER TABLE `movies` MODIFY `calificacion` DECIMAL(3,1) NOT NULL");
        }
        
        // Corregir nombres, calificaciones y géneros originales de las películas
        $checkTitle = $db->query("SELECT titulo FROM `movies` WHERE `id` = 1 AND `titulo` = 'Viernes 13'");
        if ($checkTitle->fetch()) {
            $db->exec("UPDATE `movies` SET `titulo` = 'Shutter Island', `calificacion` = 9.7, `genero` = 'Suspenso', `imagen_url` = 'img/movie1.jpg' WHERE `id` = 1");
            $db->exec("UPDATE `movies` SET `titulo` = 'Fight Club', `calificacion` = 8.8, `genero` = 'Drama', `imagen_url` = 'img/movie2.jpg' WHERE `id` = 3");
            $db->exec("UPDATE `movies` SET `titulo` = 'Forrest Gump', `calificacion` = 8.6, `genero` = 'Drama', `imagen_url` = 'img/movie3.jpg' WHERE `id` = 4");
            $db->exec("UPDATE `movies` SET `titulo` = 'Forgotten', `calificacion` = 8.8, `genero` = 'Suspenso', `imagen_url` = 'img/movie4.jpg' WHERE `id` = 5");
            $db->exec("UPDATE `movies` SET `titulo` = 'The Dark Knight', `calificacion` = 9.2, `genero` = 'Acción', `imagen_url` = 'img/movie5.jpg' WHERE `id` = 6");
            $db->exec("UPDATE `movies` SET `titulo` = 'Inception', `calificacion` = 9.0, `genero` = 'Sci-Fi', `imagen_url` = 'img/movie6.jpg' WHERE `id` = 7");
            $db->exec("UPDATE `movies` SET `titulo` = 'Kill Bill', `calificacion` = 8.6, `genero` = 'Acción', `imagen_url` = 'img/movie7.jpg' WHERE `id` = 8");
            $db->exec("UPDATE `movies` SET `titulo` = 'Thor: El mundo Oscuro', `calificacion` = 8.5, `genero` = 'Acción', `imagen_url` = 'img/movie8.jpg' WHERE `id` = 9");
        }
        
        return $db;
    } catch (PDOException $error) {
        echo '<div style="background-color:#f8d7da;color:#721c24;padding:20px;border-radius:5px;margin:20px;text-align:center;font-family:sans-serif;">';
        echo '<h2>Error de conexión con la Base de Datos</h2>';
        echo '<p>' . htmlspecialchars($error->getMessage()) . '</p>';
        echo '<p>Por favor asegúrate de haber importado el archivo SQL y tener iniciado MySQL en XAMPP.</p>';
        echo '</div>';
        exit;
    }
}

// Helper para escapar salidas HTML (Prevenir XSS)
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

function registrarPelicula($bd, $datos) {
    $sql = "INSERT INTO movies (titulo, calificacion, premios, fechaCreacion, duracion, genero, imagen_url) 
            VALUES (:titulo, :calificacion, :premios, :fecha, :duracion, :genero, :imagen_url)";
    
    $query = $bd->prepare($sql);
    
    $query->bindValue(':titulo', $datos['titulo']);
    $query->bindValue(':calificacion', $datos['rating']); 
    $query->bindValue(':premios', $datos['premios'] ?: 0);
    $query->bindValue(':fecha', $datos['fecha_estreno']);
    $query->bindValue(':duracion', $datos['duracion'] ?: 0);
    $query->bindValue(':genero', $datos['genero_id']); 
    $query->bindValue(':imagen_url', !empty($datos['imagen_url']) ? $datos['imagen_url'] : null);
    
    $query->execute();
    header('Location: peliculas.php');
    exit;
}

function editarPelicula($bd, $datos, $id) {
    $sql = "UPDATE movies SET 
            titulo = :titulo, 
            calificacion = :calificacion, 
            premios = :premios, 
            fechaCreacion = :fecha, 
            duracion = :duracion, 
            genero = :genero, 
            imagen_url = :imagen_url 
            WHERE id = :id";
            
    $query = $bd->prepare($sql);
    
    $query->bindValue(':titulo', $datos['titulo']);
    $query->bindValue(':calificacion', $datos['rating']); 
    $query->bindValue(':premios', $datos['premios'] ?: 0);
    $query->bindValue(':fecha', $datos['fecha_estreno']);
    $query->bindValue(':duracion', $datos['duracion'] ?: 0);
    $query->bindValue(':genero', $datos['genero_id']); 
    $query->bindValue(':imagen_url', !empty($datos['imagen_url']) ? $datos['imagen_url'] : null);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    
    $query->execute();
    header('Location: peliculas.php');
    exit;
}

function eliminarPelicula($bd, $id) {
    $sql = "DELETE FROM movies WHERE id = :id";
    $query = $bd->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
}

// Función para registrar a los usuarios 
function registrarUsuario($bd, $datos) {
    $errores = [];

    // Validar campos obligatorios
    foreach ($datos as $campo => $valor) {
        if (empty(trim($valor))) {
            $errores[] = "El campo " . ucfirst($campo) . " es obligatorio.";
        }
    }

    // Validar formato de email
    if (!empty($datos['email']) && !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico ingresado no tiene un formato válido.";
    }

    // Validar password mínimo 8 dígitos
    if (!empty($datos['password']) && strlen($datos['password']) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres.";
    }

    // Si no hay errores de validación, procedemos a verificar duplicados
    if (empty($errores)) {
        $stmt = $bd->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $datos['email']]);
        if ($stmt->fetch()) {
            $errores[] = "El correo electrónico ya se encuentra registrado.";
            return $errores;
        }

        $sql = "INSERT INTO users (nombre, apellido, email, password, perfil) 
                VALUES (:nom, :ape, :em, :pass, :perf)";
        $query = $bd->prepare($sql);
        
        $query->execute([
            ':nom' => $datos['nombre'],
            ':ape' => $datos['apellido'],
            ':em' => $datos['email'],
            ':pass' => password_hash($datos['password'], PASSWORD_DEFAULT),
            ':perf' => $datos['perfil']
        ]);
        return true; 
    }
    return $errores; // Retorna array con errores si falló
}
?>