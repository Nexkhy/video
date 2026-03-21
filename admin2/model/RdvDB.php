<?php
require_once 'Database.php';

class RdvDB {
    private $db;
    private $tablename;
    private $tableid;

    public function __construct() {
        $this->db= new Database();
        $this->tablename= 'rdv';
        $this->tableid= 'idrdv';
    }

    public function create($iduser, $idmedecin, $motif, $date_rdv, $duree, $statut) {
        $sql= "insert into $this->tablename set iduser=?, idmedecin=?, motif=?, date_rdv=?, duree=?, statut=?";
        $params= array($iduser, $idmedecin, $motif, $date_rdv, $duree, $statut);
        $this->db->prepare($sql, $params);
    }

    public function update($id, $iduser, $idmedecin, $motif, $date_rdv, $duree, $statut) {
        $sql= "update $this->tablename set iduser=?, idmedecin=?, motif=?, date_rdv=?, duree=?, statut=? where $this->tableid=?";
        $params= array($iduser, $idmedecin, $motif, $date_rdv, $duree, $statut, $id);
        $this->db->prepare($sql, $params);
    }

    public function updateStatut($id, $statut) {
        $sql= "update $this->tablename set statut=? where $this->tableid=?";
        $params= array($statut, $id);
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