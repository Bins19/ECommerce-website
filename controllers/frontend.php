<?php

    require('models/Article.php');
    require('models/ArticlesManager.php');
    require('models/User.php');
    require('models/UsersManager.php');
    require('models/ShoppingCart.php');
    require('models/Command.php');
    require('models/CommandManager.php');

    session_start();

    function listArticles() {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $articlesManager = new ArticlesManager($db);
        $categories = $articlesManager->getCategories();
        $articles = $articlesManager->getArticles();
        //print_r($articles);
        require("views/listArticlesView.php");
    }

    function article($id) {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $articlesManager = new ArticlesManager($db);
        $categories = $articlesManager->getCategories();
        $article = $articlesManager->getArticle($id);
        require("views/articleView.php");
    }

    function listArticlesByCategory($idCategory) {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $articlesManager = new ArticlesManager($db);
        $articlesByCategory = $articlesManager->getArticlesByCategory($idCategory);
        $brands = $articlesManager->getBrands($idCategory);
        $colors = $articlesManager->getColors($idCategory);
        $categories = $articlesManager->getCategories();
        require("views/listArticlesByCategoryView.php");
    }

    function listArticlesFiltered($idCategory, $POST) {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $articlesManager = new ArticlesManager($db);
        $brands = $articlesManager->getBrands($idCategory);
        $colors = $articlesManager->getColors($idCategory);
        $brandsSelected = array();
        $colorsSelected = array();
        $min = $max = 0;
        foreach ($POST as $key => $value) {
            if (in_array($key, $brands) && $value == 'on')
                array_push($brandsSelected, $key);
            if(in_array($key, $colors) && $value == 'on')
                array_push($colorsSelected, $key);
        }
        if (isset($POST['price'])) {
            $price = $POST['price'];
            switch ($price) {
                case 'fifty':
                    $min = 0;
                    $max = 50;
                    break;
                case 'hundred':
                    $min = 50;
                    $max = 100;
                    break;
                case 'three_hundred':
                    $min = 100;
                    $max = 300;
                    break;
                case 'five_hundred':
                    $min = 300;
                    $max = 500;
                    break;
                case 'infinite':
                    $min = 500;
                    $max = -1;
                    break;
                default:
                    $min = $max = 0;
                    break;
            }
        }
        $articlesFiltered = $articlesManager->getArticlesFiltered($idCategory, $brandsSelected, $colorsSelected, $min, $max);
        $categories = $articlesManager->getCategories();
        if(empty($articlesFiltered)) {
            $errorMessage = "Change tes putains de filtre";
            require("views/errorView.php");
        } else
            require('views/listArticlesFilteredView.php');
    }

    function searchArticles($nameArticle) {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $articlesManager = new ArticlesManager($db);
        $article = trim($nameArticle);
        $articles = $articlesManager->getSearchedArticles($article);
        return $articles;
    }

    function searchArticlesByPOST($nameArticle) {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $articlesManager = new ArticlesManager($db);
        $categories = $articlesManager->getCategories();
        $articles = searchArticles($nameArticle);
        require('views/listArticlesView.php');
    }

    function searchArticlesByGET($nameArticle) {
        $articles = searchArticles($nameArticle);
        foreach($articles as $article) {
            ?>
            <h6 style="margin-top: 0px; border-bottom: 1px solid #ccc">
                <a href="index.php?action=article&idArticle=<?= $article->getIdArticle() ?>"><?= $article->getName() ?></a>
            </h6>
            <?php
        }
    }

    function formSignIn() {
        require("views/signInView.php");
    }

    function signIn() {
        $array['mail'] = $_POST['email'];
        $array['password'] = $_POST['password'];
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $userManager = new UsersManager($db);
        $user = new User($array);
        $isConnected = $userManager->signIn($user);
        print_r($isConnected);
        if($isConnected != null) {
            //session_start();
            $_SESSION['idUser'] = $isConnected['idUser'];
            $_SESSION['password'] = $isConnected['password'];
            //print_r($_SESSION['idUser']);
            //print_r($_SESSION['password']);
            header('Location: index.php?action=listArticles');
        } else {
            $errorMessage = "Adresse mail ou mot de passe incorrect";
            require("views/errorView.php");
        }
    }

    function formSignUp() {
        require("views/signUpView.php");
    }

    function signUp() {
        $array['mail'] = $_POST['email'];
        $array['password'] = $_POST['password'];
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $userManager = new UsersManager($db);
        $user = new User($array);
        $affectedLines = $userManager->signUp($user);
        if($affectedLines === true) {
            signIn($user);
        } else {
            $errorMessage = "Nique toi. On veut pas de toi!";
            require("views/errorView.php");
        }
    }

    function signOut() {
        //session_start();
        $_SESSION = array();
        //session_destroy();
        header('Location: index.php?action=listArticles');
    }

    function getProfile() {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $usersManager = new UsersManager($db);
        $user = $usersManager->getUser($_SESSION['idUser']);
        require('views/profile.php');
    }

    function formUpdateUser($idUser) {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $usersManager = new UsersManager($db);
        $user = $usersManager->getUser($idUser);
        require('views/formUpdateUser.php');
    }

    function updateUser($idUser, $POST) {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $usersManager = new UsersManager($db);
        $user = $usersManager->getUser($idUser);
        $user->setMail($POST['email']);
        $user->setFirstName($POST['firstName']);
        $user->setLastName($POST['lastName']);
        $user->setStreet($POST['street']);
        $user->setZipCode($POST['zipCode']);
        $user->setCity($POST['city']);
        $user->setCountry($POST['country']);
        $user->setPhone($POST['phone']);
        $usersManager->postUser($user);
        getProfile();
    }

    function getCommands() {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $commandManager = new CommandManager($db);
        $articlesManager = new ArticlesManager($db);
        $results = $commandManager->getCommands($_SESSION['idUser']);
        $commands = $results[0];
        $prices = $results[1];
        $amounts = $results[2];
        $categories = $articlesManager->getCategories();
        require('views/commands.php');
    }

    function getTotalAmount(ShoppingCart $shoppingCart, array $articles) {
        $totalAmount = 0;
        for($i = 0; $i < sizeof($articles); $i ++) {
            $totalAmount += $articles[$i]->getPrice() * $shoppingCart->getAmounts()[$i];
        }
        return $totalAmount;
    }

    function getCart() {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $shoppingCart = new ShoppingCart($db);
        $articlesManager = new ArticlesManager($db);
        $cart = $shoppingCart->getCart();
        $categories = $articlesManager->getCategories();
        $totalAmount = getTotalAmount($shoppingCart, $cart);
        require('views/cart.php');
    }

    function addArticleToCart($idArticle, $amount) {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $shoppingCart = new ShoppingCart($db);
        $shoppingCart->putArticle($idArticle, $amount);
        getCart();
    }

    function updateCart($idArticle, $updatedAmount) {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $shoppingCart = new ShoppingCart($db);
        $shoppingCart->postArticle($idArticle, $updatedAmount);
        getCart();
    }

    function suppressArticleFromCart($idArticle) {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $shoppingCart = new ShoppingCart($db);
        $shoppingCart->deleteArticle($idArticle);
        getCart();
    }

    function formPay() {
        require('views/formPay.php');
    }

    function pay() {
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $commandManager = new CommandManager($db);
        $commandManager->putCommand();
        $_SESSION['idArticles'] = array();
        $_SESSION['amounts'] = array();
        header('Location: index.php?action=listArticles');
    }

