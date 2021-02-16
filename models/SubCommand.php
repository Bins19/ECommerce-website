<?php


class SubCommand {

    private $id;
    private $idArticle;
    private $amount;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdArticle() {
        return $this->idArticle;
    }

    /**
     * @param mixed $idArticle
     */
    public function setIdArticle($idArticle) {
        $this->idArticle = $idArticle;
    }

    /**
     * @return mixed
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if(method_exists($this, $method))
                $this->$method($value);
        }
    }

    public function __construct(array $data) {
        $this->hydrate($data);
    }

}