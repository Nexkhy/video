<?php
class Database {
    private $dsn;
    private $username;
    private $password;
    private $pdo;


    public function __construct() {
        $this->dsn= 'mysql:host=localhost;dbname=ecosantedb;port=3306;charset=utf8';
        $this->username= 'root';
        $this->password= '';
    }

    
    public function getConnect() {
        if($this->pdo === null) {
            try {
                $this->pdo= new PDO($this->dsn, $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            }
            catch(Exception $ex) {
                die('Echec de connexion : ' . $ex->getMessage());
            }
        }
        return $this->pdo;
    }


    public function prepare($sql, $params= null) {
        $req= $this->getConnect()->prepare($sql);
        if(is_null($params)) {
            $req->execute();
        }
        else {
            $req->execute($params);
        }
        return $req;
    }


    public function getDatas($req, $one= true) {
        $datas= null;
        if($one == true) {
            $datas= $req->fetch();
        }
        else {
            $datas= $req->fetchAll();
        }
        return $datas; 
    }
}

?>