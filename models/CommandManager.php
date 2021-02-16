<?php


class CommandManager {

    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getCommands($idUser) {
        $results = array();
        $commands = array();
        $prices = array();
        $amounts = array();
        $request = $this->db->query('SELECT idCommand, customer, DATE_FORMAT(dateCommand, \'%d/%m/%Y à %Hh%imin%ss\') AS dateCommand FROM command WHERE customer = ' . $idUser);
        $data = $request->fetchAll();
        $articlesManager = new ArticlesManager($this->db);
        foreach($data as $command) {
            array_push($commands, new Command($command));
        }
        $request = $this->db->prepare('SELECT * FROM sub_command WHERE command = ?');
        foreach($commands as $command) {
            $articlesAmounts = array();
            $totalPrice = 0;
            $request->execute(array($command->getIdCommand()));
            $data = $request->fetchAll();
            $articles = array();
            foreach($data as $article) {
                array_push($articles, $articlesManager->getArticle($article['article']));
                $totalPrice += $article['amount'] * end($articles)->getPrice();
                array_push($articlesAmounts, $article['amount']);
            }
            $command->setArticles($articles);
            array_push($prices, $totalPrice);
            array_push($amounts, $articlesAmounts);
        }
        array_push($results, $commands);
        array_push($results, $prices);
        array_push($results, $amounts);
        return $results;
    }

    public function putCommand() {
        $request = $this->db->prepare('INSERT INTO command
                                                                    (customer, dateCommand)
                                                                    VALUES(?, NOW())');
        if($request->execute(array($_SESSION['idUser'])) != false) {
            $request = $this->db->prepare('INSERT INTO sub_command
                                                                           (article, amount, command, customer)
                                                                           VALUES(?, ?, ?, ?)');
            $lastIdCommand = $this->db->lastInsertId();
            $nbrArticlesBought = sizeof($_SESSION['idArticles']);
            for($i = 0; $i < $nbrArticlesBought; $i ++) {
                $request->execute(array($_SESSION['idArticles'][$i], $_SESSION['amounts'][$i], $lastIdCommand, $_SESSION['idUser']));
            }
        } else {
            throw new Exception('Impossible d\'enregistrer la commande. Contactez l\'administrateur');
        }
    }





}