<?php
    require("controllers/frontend.php");

    try {
        if(isset($_GET['action'])) {
            if($_GET['action'] == 'listArticles') {
                listArticles();
            } elseif ($_GET['action'] == 'article') {
                if(isset($_GET['idArticle']) && $_GET['idArticle'] > 0) {
                    article($_GET['idArticle']);
                }
            } elseif ($_GET['action'] == 'listArticlesByCategory') {
              if(isset($_GET['idCategory']) && $_GET['idCategory'] > 0) {
                  listArticlesByCategory($_GET['idCategory']);
              }
            } elseif ($_GET['action'] == 'listArticlesFiltered') {
                if (isset($_GET['idCategory']) && $_GET['idCategory'] > 0)
                    listArticlesFiltered($_GET['idCategory'], $_POST);
                else
                    throw new Exception('Aucune catégorie séléctionnée');
            } elseif($_GET['action'] == 'searchArticles') {
                if(isset($_GET['article'])) {
                    searchArticlesByGET($_GET['article']);
                } elseif(isset($_POST['article'])){
                    searchArticlesByPOST($_POST['article']);
                } else {
                    throw new Exception('Aucune entrée reçue');
                }
            } elseif ($_GET['action'] == 'formSignIn') {
                formSignIn();
            } elseif ($_GET['action'] == 'signIn') {
                if(isset($_POST['email']) && isset($_POST['password'])) {
                    signIn();
                } else
                    throw new Exception("Tous les champs ne sont pas remplis !");
            } elseif($_GET['action'] == 'profile') {
                getProfile();
            } elseif($_GET['action'] == 'formUpdateUser') {
              if(isset($_GET['idUser']) && $_GET['idUser'] > 0) {
                  formUpdateUser($_GET['idUser']);
              } else {
                  throw new Exception('Aucun utilisateur à modifier');
              }
            } elseif($_GET['action'] == 'updateUser') {
                if(isset($_GET['idUser']) && $_GET['idUser'] > 0 && isset($_POST['firstName'])) {
                    updateUser($_GET['idUser'], $_POST);
                } else {
                    throw new Exception('Aucun utilisateur à modifier');
                }
            } elseif($_GET['action'] == 'commands') {
                getCommands();
            } elseif ($_GET['action'] == 'formSignUp') {
                formSignUp();
            } elseif ($_GET['action'] == 'signUp') {
                if(isset($_POST['email']) && isset($_POST['password'])) {
                    signUp();
                } else
                    throw new Exception("Tous les champs ne sont pas remplis !");
            } elseif ($_GET['action'] == 'signOut') {
                signOut();
            } elseif ($_GET['action'] == 'cart') {
                getCart();
            } elseif ($_GET['action'] == 'addArticleToCart') {
                if(isset($_GET['idArticle']) && $_GET['idArticle'] > 0) {
                    if(isset($_POST['amount']) && $_POST['amount'] > 0) {
                        addArticleToCart($_GET['idArticle'], $_POST['amount']);
                    } else {
                        throw new Exception('La quantité doit être positive');
                    }
                } else {
                    throw new Exception('Aucun article à ajouter au panier');
                }
            } elseif($_GET['action'] == 'updateCart') {
                if(isset($_GET['idArticle']) && $_GET['idArticle'] > 0){
                    if(isset($_POST['amount']) && $_POST['amount'] > 0) {
                        updateCart($_GET['idArticle'], $_POST['amount']);
                    } else {
                        throw new Exception('Vous n\'avez pas choisi une quantité');
                    }
                } else {
                    throw new Exception('Aucun article n\'est séléctionné');
                }
            } elseif($_GET['action'] == 'suppressArticleFromCart') {
                if(isset($_GET['idArticle']) && $_GET['idArticle'] > 0){
                    suppressArticleFromCart($_GET['idArticle']);
                } else {
                    throw new Exception('Aucun article n\'est séléctionné');
                }
            } elseif ($_GET['action'] == 'formPay') {
                if(isset($_SESSION['idArticles']) && sizeof($_SESSION['idArticles']) > 0 && isset($_SESSION['amounts'])) {
                    if(isset($_SESSION['idUser']) && isset($_SESSION['password']))
                        formPay();
                    else
                        throw new Exception('Vous n\'êtes pas connectés');
                } else {
                    throw new Exception('Votre panier est vide');
                }
            } elseif ($_GET['action'] == 'pay') {
                if(isset($_SESSION['idArticles']) && sizeof($_SESSION['idArticles']) > 0 && isset($_SESSION['amounts'])) {
                    if(isset($_SESSION['idUser']) && isset($_SESSION['password']))
                        pay();
                    else
                        throw new Exception('Vous n\'êtes pas connectés');
                } else {
                    throw new Exception('Votre panier est vide');
                }
            }
        } else {
            listArticles();
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
        require("views/errorView.php");
    }
