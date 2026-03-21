<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


 function sendEmail($send,$receive,$subject,$content,$usersend,$userreceive){
$mail = new PHPMailer(true); // Instantation de PHPMailer avec des exceptions
    try {
    // Configuration du serveur SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Définir le serveur SMTP
    $mail->SMTPAuth = true;            // Activer l'authentification SMTP
    $mail->Username = 'jahsauveymele@gmail.com'; // Votre adresse e-mail password:oeyt wwxc tizp wieo
    $mail->Password = 'oeyt wwxc tizp wieo';      // Votre mot de passe
    $mail->SMTPSecure = 'ssl';          // Activer le chiffrement TLS
    $mail->Port = 465;                  // Port TCP à utiliser

    // Destinataires  
    $mail->setFrom("$send", "$usersend");
    $mail->addAddress("$receive", "$userreceive"); // Ajouter un destinataire

    // Contenu de l'e-mail
    $mail->isHTML(true); // Définir le format de l'e-mail sur HTML
    $mail->Subject = "$subject";
    $mail->Body    = 'BONJOUR<b>'.$content.'</b>.COMMENT VAS TU';
    $mail->AltBody = 'Ceci est un message test en texte brut.';

    // Envoyer l'e-mail
    $mail->send();
     echo '<script>'; 
    echo 'alert("votre message a étè envoyer avec succes")';
    echo '</script>';
} 
catch (Exception $e) {
    echo "Le message n'a pas pu être envoyé. <br /> Erreur : {$mail->ErrorInfo}";
}

}

?>