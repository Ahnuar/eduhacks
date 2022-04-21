<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require 'vendor/autoload.php';

    function crearCorreu(){
        $mail = new PHPMailer();
        $mail ->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = True;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        //crear un correo para llenar el username y password
        $mail->Username = '';
        $mail->Password = '';
        
        return $mail;
    }

    function enviarCorreu($mail,$destinatario,$username,$code){
        $mail->SetFrom('eduhacks.no.reply@gmail.com','Eduhacks');
        $mail->Subject = 'Activacion de usuario - Eduhacks';

        $mail->MsgHTML('
            <h1>Activación de usuario:</h1>
            <p>Hola'.$username.'
            Este correo es para activar tu cuenta. Pincha en el siguiente link para realizar la activación.</p>
            <a href="http://localhost/Eduhacks/lib/mailcheck.php?code='.$code.'&mail='.$destinatario.'">http://localhost/Eduhacks/lib/mailcheck.php?code='.$code.'&mail='.$destinatario.'</a>
        ');
        $address = $destinatario;
        $mail->AddAddress($address,'Activacion Usuario');
        $res = $mail->Send();
        return $res;
    }

    function enviarCorreuReset($mail,$destinatario,$code){
        $mail->SetFrom('eduhacks-No-Reply@gmail.com','Eduhcacks');
        $mail->Subject = 'Restablecer contraseña - Eduhacks';
        $mail->MsgHTML('
        <h1>Restablecer contraseña:</h1>
        <p>Hola'.$destinatario.'
        Este correo es para restablecer tu contraseña. Pincha en el siguiente link para restablecerla.</p>
        <a href="http://localhost/Eduhacks/lib/resetpassword.php?code='.$code.'&email='.$destinatario.'">http://localhost/Eduhacks/lib/resetpassword.php?code='.$code.'&mail='.$destinatario.'</a>
    ');
        $address = $destinatario;
        $mail->AddAddress($address,'Restablecer contraseña');
        $res = $mail->Send();
        return $res;    
    }