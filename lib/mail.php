<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require '../vendor/autoload.php';
    $mail = new PHPMailer();
    $mail ->IsSMTP();
    $mail->SMTPDebug = 2;
    $mail->SMTPAuth = True;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    //crear un correo para llenar el username y password
    $mail->Username = 'eduhacks.no.reply@gmail.com';
    $mail->Password = 'correophp420';


    $mail->SetFrom('eduhacks.no.reply@gmail.com','Eduhacks');
    $mail->Subject = 'Activación de usuario - Eduhacks';
    $mail->MsgHTML('Correo');
    $address = 'detic75883@yks247.com';
    $mail->AddAddress($address,'Activacion Usuario');
    
    //Enviament
    $result = $mail->Send();
    if(!$result){
        echo 'Error: ' . $mail->ErrorInfo;
    }else{
        echo "Correu enviat";
    }