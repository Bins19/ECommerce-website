<?php


class ArticlesManager {

    private $db;

    /**
     * @return mixed
     */
    public function getDb() {
        return $this->db;
    }

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getCategories() {
        $request = $this->db->query("SELECT * FROM category");
        return $request->fetchAll();
    }

    /*public function createArticle(Article $article) {
        $request = $this->db->prepare("INSERT INTO article
                                                                    (name, description, brand, color, price, picture, category)
                                                                    VALUES(?, ?, ?, ?, ?, ?, ?) ");
        $request->execute(array($article->getName(),
                                $article->getDescription(),
                                $article->getBrand(),
                                $article->getColor(),
                                $article->getPrice(),
                                $article->getPicture(),
                                $article->getCategory()));
        // maybe hydrate id
    }*/

    public function getArticles() {
        $articles = array();
        $request = $this->db->query("SELECT * FROM article");
        $data = $request->fetchAll();
        foreach ($data as $article) {


            $request = $this->db->query("SELECT name FROM category WHERE idCategory = " . $article['category']);
            $category = $request->fetch();
            /*$array = array(
                            'idArticle' => $data['idArticle'],
                            'name' => $data['name'],
                            'description' => $data['description'],
                            'brand' => $data['brand'],
                            'color' => $data['color'],
                            'price' => $data['price'],
                            'picture' => $data['picture'],
                            'category' => $category['name']);*/
            $article['category'] = $category['name'];
            //print_r($data);
            array_push($articles, new Article($article));
        }
        //print_r($articles);
        return $articles;
    }

    public function getArticle($id) {
        $request = $this->db->query("SELECT * FROM article WHERE idArticle = " . $id);
        $data = $request->fetch();
        $request = $this->db->query("SELECT name FROM category WHERE idCategory = " . $data['category']);
        $category = $request->fetch();
        $data['category'] = $category['name'];
        return new Article($data);
    }

    public function getArticlesByCategory($idCategory) {
        $articles = array();
        $request = $this->db->query("SELECT * FROM article WHERE category = ". $idCategory);
        $data = $request->fetchAll();
        foreach ($data as $article) {

            $request = $this->db->query("SELECT name FROM category WHERE idCategory = " . $article['category']);
            $category = $request->fetch();
            /*$request = $this->db->query("SELECT name FROM category WHERE idCategory = " . $article['category']);
            $category = $request->fetch();
            /*$array = array(
                            'idArticle' => $data['idArticle'],
                            'name' => $data['name'],
                            'description' => $data['description'],
                            'brand' => $data['brand'],
                            'color' => $data['color'],
                            'price' => $data['price'],
                            'picture' => $data['picture'],
                            'category' => $category['name']);*/
            //$article['category'] = $category['name'];
            //print_r($data);
            $article['category'] = $category['name'];
            array_push($articles, new Article($article));
        }
        //print_r($articles);
        return $articles;
    }

    public function getBrands($idCategory) {
        $brands = array();
        $request = $this->db->query("SELECT DISTINCT brand FROM article WHERE category = ". $idCategory);
        $data = $request->fetchAll();
        foreach ($data as $brand) {
            array_push($brands, $brand['brand']);
        }
        //print_r($articles);
        return $brands;
    }

    public function getColors($idCategory) {
        $colors = array();
        $request = $this->db->query("SELECT DISTINCT color FROM article WHERE category = ". $idCategory);
        $data = $request->fetchAll();
        foreach ($data as $color) {
            array_push($colors, $color['color']);
        }
        //print_r($articles);
        return $colors;
    }

    private function getMaxPrice() {
        $request = $this->db->query('SELECT MAX(price) FROM article');
        $data = $request->fetch();
        return $data[0];
    }

    public function getArticlesFiltered($idCategory, $brands, $colors, $min, $max) {
        $articlesFiltered = array();
        $maxPrice = $this->getMaxPrice();
        $sql = '';
        if($min == 0 && $max == 0) {
            $min = -1;
            $max = $maxPrice;
        } elseif ($max == -1)
            $max = $maxPrice;
        if(empty($brands) && empty($colors)) {
            $sql = "SELECT * FROM article WHERE price >= " . $min . " && price <= " . $max . " && category = " . $idCategory;
        } elseif (empty($brands)) {
            $sql = "SELECT * FROM article WHERE color IN ('"
                . implode("','", $colors)
                . "') && price >= " . $min . " && price <= " . $max
                . " && category = " . $idCategory;
        } elseif (empty($colors)) {
            $sql = "SELECT * FROM article WHERE brand IN ('"
                . implode("','", $brands)
                . "') && price >= " . $min . " && price <= " . $max
                . " && category = " . $idCategory;
        } else {
            $sql = "SELECT * FROM article WHERE brand IN ('"
                . implode("','", $brands)
                . "') && color IN ('" . implode("','", $colors) . "') && price >= " . $min . " && price <= " . $max
                . " && category = " . $idCategory;
        }
        $request = $this->db->query($sql);
        $data = $request->fetchAll();
        foreach ($data as $article) {
            $request = $this->db->query("SELECT name FROM category WHERE idCategory = " . $article['category']);
            $category = $request->fetch();
            $article['category'] = $category['name'];
            array_push($articlesFiltered, new Article($article));
        }
        return $articlesFiltered;
    }

    public function getSearchedArticles($nameArticle) {
        $articles = array();
        $request = $this->db->query("SELECT * FROM article WHERE name LIKE ". "'%" . $nameArticle . "%' LIMIT 7");
        $data = $request->fetchAll();
        foreach($data as $article) {
            array_push($articles, new Article($article));
        }
        return $articles;
    }

}