<?php
$title = "Articles";
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
                    <strong class="nav-link active" style="background-color: #131921; color: white;">Filtres</strong>
                </li>
                <form action="index.php?action=listArticlesFiltered&idCategory=<?= $idCategory ?>" method="post">
                    <div class="nav-link active">
                        Marque : <br/>
                        <?php

                        foreach ($brands as $brand) {
                            ?>
                            <input type="checkbox" name="<?= $brand ?>" id="<?= $brand ?>">
                            <label for="<?= $brand ?>"><?= $brand ?></label><br/>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="nav-link active">
                        Couleur : <br/>
                        <?php

                        foreach ($colors as $color) {
                            ?>
                            <input type="checkbox" name="<?= $color ?>" id="<?= $color ?>">
                            <label for="<?= $color ?>"><?= $color ?></label><br/>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="nav-link active">
                        Prix : <br/>
                        <input type="radio" name="price" id="fifty" value="fifty">
                        <label for="fifty">0 à 50€</label><br/>
                        <input type="radio" name="price" id="hundred" value="hundred">
                        <label for="hundred">50 à 100€</label><br/>
                        <input type="radio" name="price" id="three_hundred" value="three_hundred">
                        <label for="three_hundred">100 à 300€</label><br/>
                        <input type="radio" name="price" id="five_hundred" value="five_hundred">
                        <label for="five_hundred">300 à 500€</label><br/>
                        <input type="radio" name="price" id="infinite" value="infinite">
                        <label for="infinite">500€ et plus</label><br/>
                    </div>
                    <div class="nav-link active outer-div">
                        <button type="submit" class="btn btn-outline-primary inner-div">Filtrer</button>
                    </div>
                </form>
            </nav>
        </div>
        <div class="col-10">
            <h4><?= $articlesByCategory[0]->getCategory() ?></h4>
            <?php
            $size = count($articlesByCategory);
            //print_r($articles);
            $i = 0;
            while($i < $size) {
                ?>
                <div class="row" style="background-color: white;">
                    <?php
                    $gap = $size - $i;
                    if($gap > 3)
                        $gap = 3;
                    for($j = 0; $j < $gap; $j++) {
                        ?>
                        <a class="col-4 border-hover-black outer-div" href="index.php?action=article&idArticle=<?= $articlesByCategory[$i]->getIdArticle() ?>">
                            <div class="inner-div">
                                <img src="<?= $articlesByCategory[$i]->getPicture() ?>"/>
                                <h6><?= $articlesByCategory[$i]->getName() ?></h6>
                                <h6><?= $articlesByCategory[$i]->getPrice() ?> €</h6>
                            </div>
                        </a>

                        <?php
                        $i ++;
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php
$content = ob_get_clean();
require('template.php');
