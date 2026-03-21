<?php
require_once 'Database.php';

class ConsultationDB {
    private $db;
    private $tablename;
    private $tableid;
    private $jointure;

    public function __construct() {
        $this->db= new Database();
        $this->tablename= 'consultation';
        $this->tableid= 'idconsultation';
        $this->jointure= "
            select 
                C.*, 
                PA.nom as nom_patient, PA.prenom as prenom_patient, PA.sexe as sexe_patient, PA.telephone as telephone_patient, PA.email as email_patient, PA.photo as photo_patient,
                ME.nom as nom_medecin, ME.prenom as prenom_medecin, ME.sexe as sexe_medecin, ME.telephone as telephone_medecin, ME.email as email_medecin, ME.photo as photo_medecin
            from $this->tablename as C
            inner join user as PA on C.iduser= PA.iduser 
            inner join user as ME on C.idmedecin= ME.iduser  
        ";
    }

    public function create($iduser, $idmedecin, $reference, $poids, $taille, $tension, $montant, $taux, $statut, $date_consultation, $document) {
        $sql= "insert into $this->tablename set iduser=?, idmedecin=?, reference=?, poids=?, taille=?, tension=?, montant=?, taux=?, statut=?, date_consultation=?, document=?";
        $params= array($iduser, $idmedecin, $reference, $poids, $taille, $tension, $montant, $taux, $statut, $date_consultation, $document);
        $this->db->prepare($sql, $params);
    }

    public function update($id, $iduser, $idmedecin, $reference, $poids, $taille, $tension, $montant, $taux, $statut, $date_consultation, $document) {
        $sql= "update $this->tablename set iduser=?, idmedecin=?, reference=?, poids=?, taille=?, tension=?, montant=?, taux=?, statut=?, date_consultation=?, document=? where $this->tableid=?";
        $params= array($iduser, $idmedecin, $reference, $poids, $taille, $tension, $montant, $taux, $statut, $date_consultation, $document, $id);
        $this->db->prepare($sql, $params);
    }

    public function updateStatut($id, $statut) {
        $sql= "update $this->tablename set statut=? where $this->tableid=?";
        $params= array($statut, $id);
        $this->db->prepare($sql, $params);
    }

    public function updateDocument($id, $document) {
        $sql= "update $this->tablename set document=? where $this->tableid=?";
        $params= array($document, $id);
        $this->db->prepare($sql, $params);
    }

    public function delete($id) {
        $sql= "delete from $this->tablename where $this->tableid=?";
        $params= array($id);
        $this->db->prepare($sql, $params);
    }

    public function read($id) {
        $sql= "$this->jointure where $this->tableid=?";
        $params= array($id);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, true);
    }

    public function readUser($iduser) {
        $sql= "$this->jointure where iduser=? order by $this->tableid desc";
        $params= array($iduser);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }

    public function readPatient($iduser) {
        $sql= "$this->jointure where iduser=? order by $this->tableid desc";
        $params= array($iduser);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }

    public function readMedecin($idmedecin) {
        $sql= "$this->jointure where idmedecin=? order by $this->tableid desc";
        $params= array($idmedecin);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }

    public function readPatientMedecin($iduser, $idmedecin) {
        $sql= "$this->jointure where iduser=? and idmedecin=? order by $this->tableid desc";
        $params= array($iduser, $idmedecin);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }
    
    public function readAll() {
        $sql= "$this->jointure order by $this->tableid desc";
        $params= null;
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }
}

?>