<?php
require_once 'Database.php';

class AvisDB {
    private $db;
    private $tablename;
    private $tableid;

    public function __construct() {
        $this->db= new Database();
        $this->tablename= 'avis';
        $this->tableid= 'idavis';
    }

    public function create($iduser, $note, $message) {
        $sql= "insert into  $this->tablename set iduser=?, note=?, message=?";
        $params= array($iduser, $note, $message);
        $this->db->prepare($sql, $params);
    }

    public function update($id, $iduser, $note, $message) {
        $sql= "update $this->tablename set iduser=?, note=?, message=? where $this->tableid=?";
        $params= array($iduser, $note, $message, $id);
        $this->db->prepare($sql, $params);
    }

    public function delete($id) {
        $sql= "delete from $this->tablename where $this->tableid=?";
        $params= array($id);
        $this->db->prepare($sql, $params);
    }

    public function read($id) {
        $sql= "select * from $this->tablename where $this->tableid=?";
        $params= array($id);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, true);
    }

    public function readAll() {
        $sql= "select * from $this->tablename order by $this->tableid desc";
        $params= null;
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }
}

?>