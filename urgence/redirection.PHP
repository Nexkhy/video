<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $receive = $_POST['receive'];
    $message = $_POST['message'];
    $usersend=strstr($email,'@',true);
    $userreceive=strstr($receive,'@',true);

    // Inclure le fichier sendmail.php pour envoyer l'e-mail
    include 'sendmail.php';

    // Appeler la fonction pour envoyer l'e-mail
    sendEmail($email, $receive, $subject, $message,$usersend,$userreceive);
}