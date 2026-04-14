<?php
require_once 'admin2/model/Database.php';

try {
    $db = new Database();
    $pdo = $db->getConnect();
    
    // Ajouter la colonne solde à la table user si elle n'existe pas
    try {
        $pdo->exec("ALTER TABLE user ADD COLUMN solde DOUBLE NOT NULL DEFAULT 0");
        echo "Colonne 'solde' ajoutée à la table 'user'.\n";
    } catch (PDOException $e) {
        // La colonne existe  déjà
        echo "La colonne 'solde' existe déjà ou erreur : " . $e->getMessage() . "\n";
    }

    //  Créer la table retrait
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS retrait (
            idretrait INT AUTO_INCREMENT PRIMARY KEY,
            iduser INT NOT NULL,
            montant DOUBLE NOT NULL,
            date_demande DATETIME NOT NULL,
            statut VARCHAR(50) NOT NULL DEFAULT 'En attente',
            date_traitement DATETIME NULL,
            FOREIGN KEY (iduser) REFERENCES user(iduser)
        )");
        echo "Table 'retrait' créée avec succès.\n";
    } catch (PDOException $e) {
        echo "Erreur création table 'retrait' : " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "Erreur de connexion : " . $e->getMessage() . "\n";
}
?>
