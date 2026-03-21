<?php
require_once 'Database.php';

class UserDB {
    private $db;
    private $tablename;
    private $tableid;
    private $jointure;

    public function __construct() {
        $this->db= new Database();
        $this->tablename= 'user';
        $this->tableid= 'iduser';
        $this->jointure= "
            select 
                U.*, 
                SP.intitule as specialite, SP.montant_consultation, SP.taux
            from $this->tablename as U
            left join specialite as SP on U.idspecialite= SP.idspecialite 
        ";
    }

    public function create($idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password, $role, $photo, $statut) {
        $sql= "insert into $this->tablename set idspecialite=?, nom=?, prenom=?, sexe=?, adresse=?, telephone=?, email=?, password=?, role=?, photo=?, statut=?";
        $params= array($idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password, $role, $photo, $statut);
        $this->db->prepare($sql, $params);
    }

    public function update($id, $idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password, $role, $photo, $statut) {
        $sql= "update $this->tablename set idspecialite=?, nom=?, prenom=?, sexe=?, adresse=?, telephone=?, email=?, password=?, role=?, photo=?, statut=? where $this->tableid=?";
        $params= array($idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password, $role, $photo, $statut, $id);
        $this->db->prepare($sql, $params);
    }

    public function updatePhoto($id, $photo) {
        $sql= "update $this->tablename set photo=? where $this->tableid=?";
        $params= array($photo, $id);
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
        $sql= "$this->jointure where $this->tableid=?";
        $params= array($id);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, true);
    }

    public function readSpecialite($idspecialite) {
        $sql= "$this->jointure where idspecialite=? order by $this->tableid desc";
        $params= array($idspecialite);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }

    public function readRole($role) {
        $sql= "$this->jointure where role=? order by $this->tableid desc";
        $params= array($role);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }

    public function readAll() {
        $sql= "$this->jointure order by $this->tableid desc";
        $params= null;
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }

    public function readConnexion($email, $password) {
        $sql= "$this->jointure where email=? and password=?";
        $params= array($email, $password);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, true);
    }

    public function readConnexion2($email, $password) {
        $datas= $this->readAll();
        if($datas != null && sizeof($datas)> 0) {
            foreach($datas as $d) {
                if($email == $d->email && password_verify($password, $d->password) == true) {
                    return $d;
                }
            }
            return false;
        }
        else {
            return false;
        }
    }
}

?>