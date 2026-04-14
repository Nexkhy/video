<?php
// Gère toutes les opérations sur la table "user" (patients, médecins et admins)
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
                SP.intitule as specialite, 
                COALESCE(U.montant_consultation, SP.montant_consultation) as montant_consultation, 
                COALESCE(U.taux, SP.taux) as taux
            from $this->tablename as U
            left join specialite as SP on U.idspecialite= SP.idspecialite 
        ";

    }

    public function create($idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password, $role, $photo, $statut, $planning = null, $creneaux = null, $montant_consultation = null, $taux = null) {
        $sql= "insert into $this->tablename set idspecialite=?, nom=?, prenom=?, sexe=?, adresse=?, telephone=?, email=?, password=?, role=?, photo=?, statut=?, planning=?, creneaux=?, montant_consultation=?, taux=?";
        $params= array($idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password, $role, $photo, $statut, $planning, $creneaux, $montant_consultation, $taux);

        $this->db->prepare($sql, $params);
    }

    public function update($iduser, $idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password, $role, $photo, $statut, $planning = null, $creneaux = null, $montant_consultation = null, $taux = null) {
        $sql= "update $this->tablename set idspecialite=?, nom=?, prenom=?, sexe=?, adresse=?, telephone=?, email=?, password=?, role=?, photo=?, statut=?, planning=?, creneaux=?, montant_consultation=?, taux=? where $this->tableid=?";
        $params= array($idspecialite, $nom, $prenom, $sexe, $adresse, $telephone, $email, $password, $role, $photo, $statut, $planning, $creneaux, $montant_consultation, $taux, $iduser);
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

    public function updateSolde($id, $montant_a_ajouter) {
        // Pour éviter d'écraser la donnée, on ajoute  le montant au solde actuel
        // On utilise COALESCE pour gérer le cas où solde serait NULL
        $sql= "update $this->tablename set solde = COALESCE(solde, 0) + ? where $this->tableid=?";
        $params= array($montant_a_ajouter, $id);
        $this->db->prepare($sql, $params);
    }

    public function delete($id) {
        $sql= "delete from $this->tablename where $this->tableid=?";
        $params= array($id);
        $this->db->prepare($sql, $params);
    }

    public function read($id) {
        $sql= "$this->jointure where U.$this->tableid=?";
        $params= array($id);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, true);
    }


    public function readSpecialite($idspecialite) {
        $sql= "$this->jointure where U.idspecialite=? order by U.$this->tableid desc";
        $params= array($idspecialite);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, false);
    }


    public function readRole($role) {
        $sql= "$this->jointure where U.role=? order by U.$this->tableid desc";
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

    public function readByEmail($email) {
        $sql= "select * from $this->tablename where email=?";
        $params= array($email);
        $req= $this->db->prepare($sql, $params);
        return $this->db->getDatas($req, true);
    }

    public function readConnexion($email, $password) {
        $sql= "$this->jointure where U.email=? and U.password=?";
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