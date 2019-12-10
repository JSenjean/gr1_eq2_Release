<!DOCTYPE html>
<html lang="fr">
<head>
    <title>WaterScrum</title>
    <link rel="stylesheet" href="lib/bootstrapV4.0.0.css" >
    <script src="lib/jquery.min.js"></script>
    <script src="lib/popper.min.js"></script>
    <script src="lib/bootstrap.min.js"></script>
    <script src="lib/fontAwesome.js"></script>

    <script src="lib/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="lib/bootstrapV4.1.1.css" >
    <link rel="stylesheet" href="lib/bootstrap-select.css" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="view/favicon.ico" />
</head>

<body class="container pt-5 mt-3">
<header>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]" ?>">WaterScrum</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-item nav-link" href="index.php?action=faq">FAQ</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-item nav-link" href="index.php?action=projects">Mes Projets</a>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#"> <span class="sr-only">(current)</span></a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION['username'] ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header"><?php $_SESSION['role'] == "admin" ? print 'Administrateur' : print "Administrateur"?></h6>
                            <a class="dropdown-item" href="index.php?action=profile">Profil</a>
                            <a class="dropdown-item" href="index.php?action=resetPassword&enterMailResetPassword=1">Réinitialiser le mot de passe</a>
                            <a class="dropdown-item" href="index.php?action=modPanel">Panneau d'administration</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="index.php?action=logout">Déconnexion</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
</header>
