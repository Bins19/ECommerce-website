<?php
$title = "Votre panier";
ob_start();
?>
<div class="row">
    <div class="col-2">
        <nav class="nav flex-column nav-tabs">
            <li class="nav-item">
                <strong class="nav-link active" style="background-color: #131921; color: white;">Catégories</strong>
            </li>
            <?php
            foreach ($categories as $category) {
                ?>
                <li class="nav-item">
                    <a class="nav-link active" href="index.php?action=listArticlesByCategory&idCategory=<?= $category['idCategory'] ?>"><?= $category['name'] ?></a> <!-- articles selon catégorie -->
                </li>
                <?php
            }
            ?>
        </nav>
    </div>
    <div class="col-10">
        <h4>Votre panier</h4>
        <?php
        $nbrArticles = sizeof($cart);
        if($nbrArticles == 0) {
            ?>
            <p>Il n'y aucun article dans votre panier</p>
            <?php
        } else {
            for($i = 0; $i < sizeof($cart); $i ++) {
                ?>
                <div class="row">
                    <div class="col-3 outer-div" style="background-color: white;">
                        <img class="inner-div" src="<?= $cart[$i]->getPicture() ?>" alt="">
                    </div>
                    <div class="col-6" style="background-color: white; border-left: 1px black solid;">
                        <table cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td><h5><?= $cart[$i]->getName() ?></h5></td>
                                <td><strong><?= $cart[$i]->getPrice() ?> €</strong></td>
                            </tr>
                        </table>
                        <h6><?= $cart[$i]->getCategory() ?></h6>
                        <h5>Sous-total : <?= $cart[$i]->getPrice() * $shoppingCart->getAmounts()[$i] ?> €</h5>
                        <form action="index.php?action=updateCart&idArticle=<?= $shoppingCart->getIdArticles()[$i] ?>" method="post">
                            <label for="amount">Quantité : </label>
                            <select name="amount" id="amount">
                                <?php
                                for($j = 1; $j < 4; $j++){
                                    print_r($j);
                                    echo $shoppingCart->getAmounts()[$i];
                                    if($j == $shoppingCart->getAmounts()[$i]) {
                                ?>
                                        <option value="<?= $j ?>" selected><?= $j ?></option>
                                <?php
                                    } else {
                                ?>
                                        <option value="<?= $j ?>"><?= $j ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <script src="public/js/script.js">
                                var id = <?= $shoppingCart->getIdArticles()[$i] ?>;
                            </script>
                            <button class="btn btn-outline-primary" type="submit">Modifier</button>
                        </form>
                        <a class="btn btn-outline-danger" href="index.php?action=suppressArticleFromCart&idArticle=<?= $shoppingCart->getIdArticles()[$i] ?>" role="button">Supprimer</a>
                    </div>
                </div><br>
                <?php
            }
            ?>
            <div class="row" style="background-color: white;">
                <div class="col-6">
                    <h4>Récapitulatif</h4>
                    <h4>Total : <?= $totalAmount ?> €</h4>
                    <a class="btn btn-outline-success" role="button" href="index.php?action=formPay">Valider votre panier</a>
                </div>
            </div>

            <?php
        }
        ?>
    </div>

</div>
<?php
$content = ob_get_clean();
require('template.php');
