<?php
require_once 'Database.php';

class PaiementDB {
    private $db;
    private $tablename;
    private $tableid;

    public function __construct() {
        $this->db= new Database();
        $this->tablename= 'paiement';
        $this->tableid= 'idpaiement';
    }

    public function create($idconsultation, $idmode, $reference, $motif) {
        $sql= "insert into $this->tablename set idconsultation=?, idmode=?, reference=?, motif=?";
        $params= array($idconsultation, $idmode, $reference, $motif);
        $this->db->prepare($sql, $params);
    }

    public function update($id, $idconsultation, $idmode, $reference, $motif) {
        $sql= "update $this->tablename set idconsultation=?, idmode=?, reference=?, motif=? where $this->tableid=?";
        $params= array($idconsultation, $idmode, $reference, $motif, $id);
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