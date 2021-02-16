<?php
$title = 'Vos commandes';
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
        <h4>Vos commandes</h4>
        <?php
        $nbrCommands = sizeof($commands);
        if($nbrCommands == 0) {
        ?>
            <p>Vous n'avez effectué aucune commande</p>
        <?php
        } else {
            for($i = 0; $i < $nbrCommands; $i++) {
        ?>
            <div class="row" style="background-color: white; width: 76.75%">
                <table cellspacing="0" cellpadding="0" width="45%">
                    <tr>
                        <td>Commande effectuée le </td>
                        <td><?= $commands[$i]->getDateCommand() ?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><?= $prices[$i] ?> €</td>
                    </tr>
                </table>
            </div>
        <?php
        for($j = 0; $j < sizeof($commands[$i]->getArticles()); $j++) {
            $article = $commands[$i]->getArticles()[$j];
            ?>
            <div class="row">
                <div class="col-3 outer-div" style="background-color: white; border-top: 1px black solid;">
                    <img class="inner-div" src="<?= $article->getPicture() ?>" alt="">
                </div>
                <div class="col-6" style="background-color: white; border-left: 1px black solid;">
                    <a href="index.php?action=article&idArticle=<?= $article->getIdArticle() ?>"><h5><?= $article->getName() ?></h5></a>
                    <h5><?= $article->getBrand() ?></h5>
                    <h5><?= $article->getPrice() ?></h5>
                    <h5>Quantité : <?= $amounts[$i][$j] ?></h5>
                </div>
            </div>
        <?php
                }
        ?>
            <br>
        <?php
            }
        }
        ?>
    </div>
</div>
<?php
$content = ob_get_clean();
require('template.php');
