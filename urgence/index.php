<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="redirection.PHP" method="POST">
        <p><label for="subject">Entrer le sujet de l'email </label>
        <input type="text" name="subject" id="subject" ></p>
      <p><label for="email">Entrer votre adresse email</label>
        <input type="email" name="email" id="email" required></p>
        <p><label for="receive">Entrer l'adresse email du destinataire ou du receveur</label>
        <input type="email" name="receive" id="receive" required></p>
        <p><label for="message">Entrer votre message</label>
        <textarea name="message" id="message"></textarea></p>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
