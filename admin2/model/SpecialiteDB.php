<?php
require_once 'Database.php';

class SpecialiteDB {
    private $db;
    private $tablename;
    private $tableid;

    public function __construct() {
        $this->db= new Database();
        $this->tablename= 'specialite';
        $this->tableid= 'idspecialite';
    }

    public function create($intitule, $montant_consultation, $taux) {
        $sql= "insert into  $this->tablename set intitule=?, montant_consultation=?, taux=?";
        $params= array($intitule, $montant_consultation, $taux);
        $this->db->prepare($sql, $params);
    }

    public function update($id, $intitule, $montant_consultation, $taux) {
        $sql= "update $this->tablename set intitule=?, montant_consultation=?, taux=? where $this->tableid=?";
        $params= array($intitule, $montant_consultation, $taux, $id);
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