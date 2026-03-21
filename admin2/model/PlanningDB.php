<?php
require_once 'Database.php';

class PlanningDB {
    private $db;
    private $tablename;
    private $tableid;

    public function __construct() {
        $this->db= new Database();
        $this->tablename= 'planning';
        $this->tableid= 'idplanning';
    }

    public function create($iduser, $jour, $heure_debut, $heure_fin) {
        $sql= "insert into  $this->tablename set iduser=?, jour=?, heure_debut=?, heure_fin=?";
        $params= array($iduser, $jour, $heure_debut, $heure_fin);
        $this->db->prepare($sql, $params);
    }

    public function update($id, $iduser, $jour, $heure_debut, $heure_fin) {
        $sql= "update $this->tablename set iduser=?, jour=?, heure_debut=?, heure_fin=? where $this->tableid=?";
        $params= array($iduser, $jour, $heure_debut, $heure_fin, $id);
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

    public function readUser($iduser) {
        $sql= "select * from $this->tablename where iduser=? order by $this->tableid desc";
        $params= array($iduser);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }

    public function readAll() {
        $sql= "select * from $this->tablename order by $this->tableid desc";
        $params= null;
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }
}

?>