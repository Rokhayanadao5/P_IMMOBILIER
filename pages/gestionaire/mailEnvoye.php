<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';
require __DIR__ . '/PHPMailer-master/src/Exception.php';

function envoyerEmailInscription($email, $password) {
    $mail = new PHPMailer(true);
    
    try {
        // Configurer Mailtrap SMTP
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'bc8c070117e0af'; 
        $mail->Password = 'b832caf60dbad0';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        // Expéditeur et destinataire
        $mail->setFrom('admin@votresite.com', 'Admin');
        $mail->addAddress($email,  $password); 

        // Contenu de l'e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Inscription Confirmée';
        $mail->Body = "<h1>Bienvenue,$email !</h1>
        <p>Votre compte a été créé avec succès. Utilisez ce mot de passe temporaire pour vous connecter : <strong>$password</strong></p>
        <p>Nous vous conseillons de changer ce mot de passe dès que possible après votre première connexion.</p>";
        $mail->AltBody = "Bienvenue, $ $password ! Votre compte a été créé avec succès.";

        // Envoyer l'e-mail
        $mail->send();
        return "E-mail envoyé avec succès à $email";
    } catch (Exception $e) {
        return "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
}

// Exemple d'utilisation après l'inscription d'un utilisateur par l'admin
// $emailUtilisateur = 'test@example.com';
// $nomUtilisateur = 'Doe';
// $prenomUtilisateur = 'John';
// $passwordUtilisateur = 'motdepasse';
// echo envoyerEmailInscription($emailUtilisateur, $nomUtilisateur, $prenomUtilisateur, $passwordUtilisateur);

?>