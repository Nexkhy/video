<?php
require_once 'Database.php';

class ModeDB {
    private $db;
    private $tablename;
    private $tableid;

    public function __construct() {
        $this->db= new Database();
        $this->tablename= 'mode';
        $this->tableid= 'idmode';
    }

    public function create($intitule) {
        $sql= "insert into  $this->tablename set intitule=?";
        $params= array($intitule);
        $this->db->prepare($sql, $params);
    }

    public function update($id, $intitule) {
        $sql= "update $this->tablename set intitule=? where $this->tableid=?";
        $params= array($intitule, $id);
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