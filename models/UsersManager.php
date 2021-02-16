<?php


class UsersManager {

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

    private function putUser(User $user) {
        $request = $this->db->prepare("INSERT INTO user 
                                                                (mail, password)
                                                                VALUES(?, ?)");
        $request->execute(array($user->getMail(), $user->getPassword()));
        // maybe hydrate id
    }

    public function getUser($id) {
        $request = $this->db->query("SELECT * FROM user WHERE idUser = " . $id);
        $data = $request->fetch();
        return new User($data);
    }

    public function postUser(User $user) {
        $request = $this->db->prepare("UPDATE user SET 
                                                                mail = ?, 
                                                                password = ?,
                                                                firstName = ?,
                                                                lastName = ?, 
                                                                street = ?, 
                                                                zipCode = ?,
                                                                city = ?,
                                                                country = ?,
                                                                phone = ?
                                                            WHERE idUser = ?");
        $request->execute(array($user->getMail(),
                                $user->getPassword(),
                                $user->getFirstName(),
                                $user->getLastName(),
                                $user->getStreet(),
                                $user->getZipCode(),
                                $user->getCity(),
                                $user->getCountry(),
                                $user->getPhone(),
                                $user->getIdUser()));
        // maybe hydrate
    }

    public function signIn(User $user) {
        $request = $this->db->prepare("SELECT idUser, password FROM user WHERE mail = ?");
        $request->execute(array($user->getMail()));
        $data = $request->fetch();
        $pass = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $isPasswordCorrect = password_verify($user->getPassword(), $data['password']);
        print_r($isPasswordCorrect);
        $result = null;
        if($isPasswordCorrect) {
            $result['idUser'] = $data['idUser'];
            $result['password'] = $data['password'];
        }
        return $result;
    }

    public function signUp(User $user) {
        $request = $this->db->prepare("INSERT INTO user
                                                                (mail, password) 
                                                                VALUES(?, ?)");
        $pass = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        return $request->execute(array($user->getMail(), $pass));
    }
}