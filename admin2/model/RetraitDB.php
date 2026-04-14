<?php
require_once 'Database.php';

class RetraitDB {
    private $db;
    private $tablename;
    private $tableid;

    public function __construct() {
        $this->db = new Database();
        $this->tablename = 'retrait';
        $this->tableid = 'idretrait';
    }

    public function create($iduser, $montant, $date_demande, $statut) {
        $sql = "INSERT INTO $this->tablename SET iduser=?, montant=?, date_demande=?, statut=?";
        $params = array($iduser, $montant, $date_demande, $statut);
        $this->db->prepare($sql, $params);
    }

    public function updateStatut($id, $statut, $date_traitement) {
        $sql = "UPDATE $this->tablename SET statut=?, date_traitement=? WHERE $this->tableid=?";
        $params = array($statut, $date_traitement, $id);
        $this->db->prepare($sql, $params);
    }

    public function read($id) {
        $sql = "SELECT * FROM $this->tablename WHERE $this->tableid=?";
        $params = array($id);
        $req = $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, true);
    }

    public function readUser($iduser) {
        $sql = "SELECT R.*, U.nom, U.prenom FROM $this->tablename R INNER JOIN user U ON R.iduser = U.iduser WHERE R.iduser=? ORDER BY R.date_demande DESC";
        $params = array($iduser);
        $req = $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }

    public function readAll() {
        $sql = "SELECT R.*, U.nom, U.prenom FROM $this->tablename R INNER JOIN user U ON R.iduser = U.iduser ORDER BY R.date_demande DESC";
        $params = null;
        $req = $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }
}
?>
