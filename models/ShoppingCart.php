<?php


class ShoppingCart {

    private $idArticles;
    private $amounts;
    private $db;

    /**
     * @return mixed
     */
    public function getIdArticles() {
        return $this->idArticles;
    }

    /**
     * @param mixed $idArticles
     */
    public function setIdArticles(array $idArticles) {
        $this->idArticles = $idArticles;
    }

    /**
     * @return mixed
     */
    public function getAmounts() {
        return $this->amounts;
    }

    /**
     * @param mixed $amounts
     */
    public function setAmounts(array $amounts) {
        $this->amounts = $amounts;
    }

    public function __construct(PDO $db) {
        if(!(isset($_SESSION['idArticles']) && isset($_SESSION['amounts']))) {
            $_SESSION['idArticles'] = array();
            $_SESSION['amounts'] = array();
            $this->setIdArticles(array());
            $this->setAmounts(array());
        } else {
            $this->setIdArticles($_SESSION['idArticles']);
            $this->setAmounts($_SESSION['amounts']);
        }
        $this->db = $db;
    }

    public function getCart() {
        $articles = array();
        $db = new PDO("mysql:host=localhost; port=3307; dbname=ecommerce; charset=utf8", "root", "");
        $articlesManager = new ArticlesManager($db);
        foreach ($this->idArticles as $idArticle)
            array_push($articles, $articlesManager->getArticle($idArticle));
        return $articles;
    }

    public function putArticle($newIdArticle, $newAmount) {
        array_push($this->idArticles, $newIdArticle);
        array_push($this->amounts, $newAmount);

        $_SESSION['idArticles'] = $this->idArticles;
        $_SESSION['amounts'] = $this->amounts;
    }

    public function deleteArticle($idArticle) {
         $index = array_search($idArticle, $this->idArticles);
         unset($this->idArticles[$index]);
         unset($this->amounts[$index]);
         $this->idArticles = array_merge($this->idArticles);
         $this->amounts = array_merge($this->amounts);

         $_SESSION['idArticles'] = $this->idArticles;
         $_SESSION['amounts'] = $this->amounts;
    }

    public function postArticle($idArticle, $updatedAmount) {
        $index = array_search($idArticle, $this->idArticles);
        $this->amounts[$index] = $updatedAmount;

        $_SESSION['amounts'] = $this->amounts;
    }

}