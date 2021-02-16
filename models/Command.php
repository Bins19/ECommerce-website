<?php


class Command {

    private $idCommand;
    private $customer;
    private $dateCommand;
    private $articles;

    /**
     * @return mixed
     */
    public function getIdCommand()
    {
        return $this->idCommand;
    }

    /**
     * @param mixed $idCommand
     */
    public function setIdCommand($idCommand)
    {
        $this->idCommand = $idCommand;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $idCustomer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getDateCommand()
    {
        return $this->dateCommand;
    }

    /**
     * @param mixed $dateCommand
     */
    public function setDateCommand($dateCommand)
    {
        $this->dateCommand = $dateCommand;
    }

    /**
     * @return mixed
     */
    public function getArticles() {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     */
    public function setArticles(array $articles) {
        $this->articles = $articles;
    }

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function __construct(array $data) {
        $this->hydrate($data);
    }

}