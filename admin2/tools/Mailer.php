<?php
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $mail;

    public function __construct() {
        // Instantiation de PHPMailer avec des exceptions
        $this->mail = new PHPMailer(true); 
        //====== Configuration du serveur SMTP
        // Définir le serveur SMTP
        $this->mail->isSMTP();
        // Activer l'authentification SMTP
        $this->mail->Host = 'smtp.gmail.com'; 
        $this->mail->SMTPAuth = true;
        // Activer le chiffrement TLS
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        // Port TCP à utiliser        
        $this->mail->Port = 587;
        // L'adresse e-mail et password utilisé pour la configuration
        $this->mail->Username = 'hectorken305@gmail.com';
        $this->mail->Password = 'cwbp cnrd euhz pibj';
    }



    public function sendMail($expediteur, $destinataires, $objet, $message) {
        try {
            // Ajouter l'expéditeur
            $this->mail->setFrom($expediteur['email'], $expediteur['nom']);


            // Ajouter les destinataires
            foreach ($destinataires as $dest) {
                $this->mail->addAddress($dest['email'], $dest['nom']);
            }
            

            // Contenu de l'e-mail
            // Définir le format de l'e-mail sur HTML
            $this->mail->isHTML(true); 
            $this->mail->Subject = $objet;
            $this->mail->Body    = $message;
            $this->mail->AltBody = $message;


            // Envoyer l'e-mail
            $this->mail->send();

            return true;
        }
        catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. <br /> Erreur : {$this->mail->ErrorInfo}";
            return false;
        }
    }




    public function sendDemo() {
        $expediteur= array(
            'email' => 'mtejiogni@yahoo.fr',
            'nom' => 'TEJIOGNI MARC'
        );

        $destinataires= array(
            [
                'email' => 'mtejiogni1992@gmail.com',
                'nom' => 'TEJIOGNI MARC'
            ],
            [
                'email' => 'miguelndessa678@gmail.com',
                'nom' => 'Miguel NDESSA'
            ]
        );

        $objet= "Sujet du mail pour la demo";

        $message= 'Ceci est un message test en <b>HTML</b>.';

        $this->sendMail($expediteur, $destinataires, $objet, $message);
    }
}


//$mailer= new Mailer();
//$mailer->sendDemo();

?>