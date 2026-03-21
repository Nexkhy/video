<?php
require_once 'Database.php';

class ExamenDB {
    private $db;
    private $tablename;
    private $tableid;

    public function __construct() {
        $this->db= new Database();
        $this->tablename= 'examen';
        $this->tableid= 'idexamen';
    }

    public function create($idsuivie, $intitule, $description) {
        $sql= "insert into $this->tablename set idsuivie=?, intitule=?, description=?";
        $params= array($idsuivie, $intitule, $description);
        $this->db->prepare($sql, $params);
    }

    public function update($id, $idsuivie, $intitule, $description) {
        $sql= "update $this->tablename set idsuivie=?, intitule=?, description=? where $this->tableid=?";
        $params= array($idsuivie, $intitule, $description, $id);
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