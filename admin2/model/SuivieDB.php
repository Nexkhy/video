<?php
require_once 'Database.php';

class SuivieDB {
    private $db;
    private $tablename;
    private $tableid;

    public function __construct() {
        $this->db= new Database();
        $this->tablename= 'suivie';
        $this->tableid= 'idsuivie';
    }

    public function create($idconsultation, $observation, $recommandations, $nature_rdv, $date_suivie, $date_prochain_rdv, $document) {
        $sql= "insert into $this->tablename set idconsultation=?, observation=?, recommandations=?, nature_rdv=?, date_suivie=?, date_prochain_rdv=?, document=?";
        $params= array($idconsultation, $observation, $recommandations, $nature_rdv, $date_suivie, $date_prochain_rdv, $document);
        $this->db->prepare($sql, $params);
    }

    public function update($id, $idconsultation, $observation, $recommandations, $nature_rdv, $date_suivie, $date_prochain_rdv, $document) {
        $sql= "update $this->tablename set idconsultation=?, observation=?, recommandations=?, nature_rdv=?, date_suivie=?, date_prochain_rdv=?, document=? where $this->tableid=?";
        $params= array($idconsultation, $observation, $recommandations, $nature_rdv, $date_suivie, $date_prochain_rdv, $document, $id);
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
        $sql= "select * from $this->tablename where $this->tableid=?";
        $params= array($id);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, true);
    }

    public function readConsultation($idconsultation) {
        $sql= "select * from $this->tablename where idconsultation=? order by $this->tableid desc";
        $params= array($idconsultation);
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