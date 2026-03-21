<?php
// meet.php
require_once 'config.php'; 
require_once BACKEND_PATH_SERVICE; 
// Générer un nom de salle aléatoire
$roomName = "meet_" . rand(1000, 9999);

// Créer le lien Jitsi
$jitsiLink = "https://meet.jit.si/" . $roomName;

// Rediriger automatiquement vers Jitsi dans un nouvel onglet
?>

<!DOCTYPE html>
<html>
<head>
    <title>Créer Réunion</title>
</head>
<body>
    <h2>Réunion créée !</h2>
    <p>Nom de la salle : <b><?php echo $roomName; ?></b></p>
    <p>Lien pour rejoindre : <a href="<?php echo $jitsiLink; ?>" target="_blank" >Ouvrir la réunion</a></p>
    <button onclick="window.open('<?php echo $jitsiLink; ?>','_blank')">Rejoindre maintenant</button>
  
   <?php  echo $jitsiLink;
    $expediteur= array(
            'email' => 'hectorken305@gmail.com',
            'nom' => 'hector ken'
        );

        $destinataires= array(
            [
                'email' => 'hectorken305@gmail.com',
                'nom' => 'hector ken'
            ],
            [
                'email' => 'titianchouquet@gmail.com',
                'nom' => 'titianchouquet'
            ]
        );

        $objet= "Sujet du mail pour la demo";

        $message= $jitsiLink;
        $mailer->sendMail($expediteur,$destinataires,$objet,$message); 
   ?>
</body>
</html>