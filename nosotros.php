<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap 4 -->
    <link class="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="css/style.css">
    <title>Nosotros - Cine ISIL</title>
</head>
<body class="bg-dark text-white">

    <?php include_once('./partials/navBar.php')?>

    <main class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 text-center mb-5">
                <h1 class="display-4 font-weight-bold">Sobre Cine ISIL</h1>
                <p class="lead text-muted">Llevamos la magia del séptimo arte a toda nuestra comunidad educativa desde 2026.</p>
                <hr class="w-25 border-warning">
            </div>

            <div class="col-md-8 mb-5">
                <div class="accordion shadow-lg glass-panel" id="accordionCine">
                    
                    <div class="card border-0 bg-transparent">
                        <div class="card-header bg-transparent border-bottom border-secondary" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left text-white font-weight-bold p-3" type="button" data-toggle="collapse" data-target="#collapseOne" style="text-decoration:none; box-shadow:none;">
                                    <i class="fas fa-history mr-2 text-warning"></i> Nuestra Historia
                                </button>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" data-parent="#accordionCine">
                            <div class="card-body text-light" style="background-color: rgba(0,0,0,0.2);">
                                Fundada originalmente como un proyecto de programación web, Cine ISIL se ha convertido en el referente de gestión cinematográfica para estudiantes, combinando tecnología de vanguardia con la pasión por las películas.
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 bg-transparent">
                        <div class="card-header bg-transparent border-bottom border-secondary" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left text-white font-weight-bold collapsed p-3" type="button" data-toggle="collapse" data-target="#collapseTwo" style="text-decoration:none; box-shadow:none;">
                                    <i class="fas fa-bullseye mr-2 text-warning"></i> Misión
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" data-parent="#accordionCine">
                            <div class="card-body text-light" style="background-color: rgba(0,0,0,0.2);">
                                Brindar una plataforma interactiva y eficiente que permita a los amantes del cine descubrir, registrar y gestionar sus películas favoritas de manera sencilla y atractiva.
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 bg-transparent">
                        <div class="card-header bg-transparent" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left text-white font-weight-bold collapsed p-3" type="button" data-toggle="collapse" data-target="#collapseThree" style="text-decoration:none; box-shadow:none;">
                                    <i class="fas fa-star mr-2 text-warning"></i> Valores
                                </button>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordionCine">
                            <div class="card-body text-light" style="background-color: rgba(0,0,0,0.2);">
                                <ul class="mb-0 pl-3">
                                    <li class="mb-2"><strong class="text-gold">Innovación:</strong> Uso de tecnologías modernas como PDO y Bootstrap.</li>
                                    <li class="mb-2"><strong class="text-gold">Compromiso:</strong> Pasión por el orden y la gestión de datos.</li>
                                    <li class="mb-0"><strong class="text-gold">Excelencia:</strong> Calidad en cada línea de código y diseño responsivo.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <?php include_once('./partials/footer.php') ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>