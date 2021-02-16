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
                <a class="nav-link active" href="#"></a>
            </li>
        </nav>
    </div>
    <div class="col-10">
        <h4>Articles</h4>
        <?php
        $size = count($articles);
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
                    <a class="col-4 border-hover-black outer-div" href="index.php?action=article&idArticle=<?= $articles[$i]->getIdArticle() ?>">
                        <div class="inner-div">
                            <img src="<?= $articles[$i]->getPicture() ?>"/>
                            <h6><?= $articles[$i]->getName() ?></h6>
                            <h6><?= $articles[$i]->getPrice() ?> €</h6>
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
