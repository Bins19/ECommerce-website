<?php
    $title = $article->getName();
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
            <li class="nav-item">
                <a class="nav-link active" href="#"></a>
            </li>
        </nav>
    </div>
    <div class="col-10">
        <em><h6><?= $article->getCategory() ?></h6></em>
        <div class="row">
            <div class="col-3 outer-div" style="background-color: white;">
                <img class="inner-div" src="<?= $article->getPicture() ?>" alt="">
            </div>
            <div class="col-6">
                <h5 style="font-weight: bold;"><?= $article->getName() ?></h5><br/>
                <table cellspacing="0" cellpadding="0" width="30%">
                    <tr>
                        <td width="50%"><strong>Prix</strong></td>
                        <td width="50%"><?= $article->getPrice() ?> €</td>
                    </tr>
                    <tr>
                        <td><strong>Marque</strong></td>
                        <td><?= $article->getBrand() ?></td>
                    </tr>
                    <tr>
                        <td><strong>Couleur</strong></td>
                        <td><?= $article->getColor() ?></td>
                    </tr>
                </table><br/>
                <form action="index.php?action=addArticleToCart&idArticle=<?= $article->getIdArticle() ?>" method="post">
                    <label for="amount">Quantité : </label>
                    <select name="amount" id="amount">
                        <?php
                        for($i = 1; $i < 4; $i++){
                        ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php
                        }
                        ?>
                    </select><br/>
                    <button class="btn btn-outline-primary" type="submit">Ajouter au panier</button>
                </form>
                <p>
                    <h6><strong>A propos de l'article : </strong></h6>
                    <?= $article->getDescription() ?>
                </p>
            </div>
        </div>
    </div>
</div>
<?php
    $content = ob_get_clean();
    require('template.php');