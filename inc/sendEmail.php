﻿<?php

// Replace this with your own email address
$siteOwnersEmail = 'l.martin.rosello@gmail.com';


if($_POST) {

    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Ingrese su nombre.";
    }
    // Check Email
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['email'] = "Ingrese su E-Mail.";
    }
    // Check Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Ingrese su mensaje, deben ser 15 caracteres como minimo.";
    }
    // Subject
    if ($subject == '') { $subject = "Sin asunto"; }


    // Set Message
    $message .= "Nuevo mensaje de: " . $name . "<br />";
    $message .= "Dirección de email: " . $email . "<br />";
    $message .= "Mensaje: <br />";
    $message .= $contact_message;
    $message .= "<br /> ----- <br /> Este email fue enviado desde el sitio de contacto. <br />";

    // Set From: header
    $from =  $name . " <" . $email . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: ". $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


    if (!$error) {

        ini_set("sendmail_from", $siteOwnersEmail); // for windows server
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) { echo "OK"; }
        else { echo "Hubo un error, porfavor intente de nuevo."; }
        
    } # end if - no validation error

    else {

        $response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
        $response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
        $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
        
        echo $response;

    } # end if - there was a validation error

}

?>