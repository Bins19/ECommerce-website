<?php


class SubCommandManager {

    private $db;

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    public function __construct(PDO $db) {
        $this->db = $db;
    }


}