<?php
//session_start();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css">
    <title><?= $title ?></title>
</head>
<body>
<header>
    <div class="row">
        <div class="col-2">
            <ul class="nav border-hover box-center">
                <a class="nav-link border-hover-white box-click" href="index.php">Badiane et soeurs</a>
            </ul>
        </div>
        <div class="col-1"></div>
        <div class="col-6">
            <form class="form-inline" action="index.php?action=searchArticles" method="post">
                <input class="form-control mr-sm-2" size="50px" type="search" placeholder="Rechercher" aria-label="Search" id="article" name="article">
                <button class="btn btn-outline-success my-2 " type="submit">Rechercher</button>
            </form>
        </div>
        <div class="col-1 border-hover-white box-center dropdown">
            <?php
            if (isset($_SESSION['idUser']) && isset($_SESSION['password'])) {
                ?>
                <a style="color: #007be6;" class="nav-link box-click btn dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Bonjour</a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="index.php?action=profile">Mon profil</a>
                    <a class="dropdown-item" href="index.php?action=commands">Mes commandes</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="index.php?action=signOut">Déconnexion</a>
                </div>
                <?php
            } else {
                ?>
                <a class="nav-link box-click" href="index.php?action=formSignIn">Connexion</a>
                <?php
            }
            ?>
        </div>
        <div class="col-1 border-hover-white box-center box-right">
            <a class="nav-link box-click" href="index.php?action=cart">Panier</a>
        </div>
    </div>
</header>
<div class="row">
    <div class="col-3"></div>
    <div class="col-6" id="resultSearch">

    </div>
</div>
<div class="main">
    <div style="visibility: hidden;">dddddddddd</div>
    <?= $content ?>
</div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $("#article").keyup(function () {
            $("#resultSearch").html("");
            let article = $(this).val();
            if(article != "") {
                $.ajax({
                   type: "GET",
                    url: "index.php?action=searchArticles",
                    data: "article=" + encodeURIComponent(article),
                    success: function (result) {
                        if(result != "") {
                            $("#resultSearch").append(result);
                        }
                    }
                });
            }
        })
    });
</script>
</body>
</html>
