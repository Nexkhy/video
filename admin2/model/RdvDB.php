<?php
require_once 'Database.php';

class RdvDB {
    private $db;
    private $tablename;
    private $tableid;
    private $jointure;

    public function __construct() {
        $this->db= new Database();
        $this->tablename= 'rdv';
        $this->tableid= 'idrdv';
        $this->jointure = "
            select 
                R.*, 
                PA.nom as nom_patient, PA.prenom as prenom_patient, PA.email as email_patient, PA.photo as photo_patient,
                ME.nom as nom_medecin, ME.prenom as prenom_medecin, ME.email as email_medecin, ME.photo as photo_medecin
            from $this->tablename as R
            inner join user as PA on R.iduser = PA.iduser
            inner join user as ME on R.idmedecin = ME.iduser
        ";
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
        $sql= $this->jointure . " where R.$this->tableid=?";
        $params= array($id);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, true);
    }

    public function readMedecin($idmedecin) {
        $sql= $this->jointure . " where R.idmedecin=? order by R.date_rdv desc";
        $params= array($idmedecin);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }

    public function readPatient($iduser) {
        $sql= $this->jointure . " where R.iduser=? order by R.date_rdv desc";
        $params= array($iduser);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }

    public function readAll() {
        $sql= $this->jointure . " order by R.$this->tableid desc";
        $params= null;
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }
}

?>