<?php
// Gère la connexion à la base de données MySQL via PDO
class Database
{
    private $dsn;
    private $username;
    private $password;
    private $pdo;


    public function __construct()
    {
        $this->dsn = 'mysql:host=mysql-princesse.alwaysdata.net;dbname=princesse_db1;port=3306;charset=utf8';
        $this->username = 'princesse_db1';
        $this->password = 'nexky237';
    }


    public function getConnect()
    {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO($this->dsn, $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (Exception $ex) {
                die('Echec de connexion : ' . $ex->getMessage());
            }
        }
        return $this->pdo;
    }


    public function prepare($sql, $params = null)
    {
        $req = $this->getConnect()->prepare($sql);
        if (is_null($params)) {
            $req->execute();
        } else {
            $req->execute($params);
        }
        return $req;
    }


    public function getDatas($req, $one = true)
    {
        $datas = null;
        if ($one == true) {
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();
        }
        return $datas;
    }
}

?>