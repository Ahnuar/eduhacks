<?php
   
       if(isset($_GET['email']) && isset($_GET['code'])){
              require 'database.php';
              $mailcode=getcodeuser($_GET["email"]);
              //$codetime=selecttime($_GET['email']);
              if($mailcode!=$_GET["code"]){//} && $codetime ){
                     header("Location: ../index.php");
                     exit();             
              }
              //enviar el codigo otra vez
       }else{
              require 'database.php';
              $mailcode=getcodeuser($_POST["email"]);
              if(isset($_POST['pwd-2']) && isset($_POST['pwd-1'])){
                     if($_POST['pwd-2']==$_POST['pwd-1']){
                            if($mailcode==$_POST["code"]){
                                   $updatepassword=passwdUpdate($_POST["code"],$_POST["email"],$_POST['pwd-1']); 
                                   //Crear alerta que se ha ejecutado            
                            }             
                     }else{
                            //Create alert que las contraseñas no coindicen
                     }
              }
              header("Location: ../index.php");
              exit(); 

       }

       
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Eduhacks</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./css/index.css">
    </head>
    <body>
       <canvas id="c"></canvas>
        
       <div class="wrapper">
            
              <div class="title-text">
              
              <div class="title login">Reset Password</div>
              </div> 
       <div class="form-inner">
                <form action="./index.php" class="login" method="POST">
                  <div class="field">
                    <input id="pwd-2" name="pwd-1" type="password" placeholder="Nueva contraseña" required>
                  </div>
                  <div class="field">
                    <input id="pwd-2" name="pwd-2" type="password" placeholder="Repita la contraseña" required>
                  </div>
                  <input id="email" name="email" type="hidden" value="<?php echo $_GET["email"] ?>">
                  <input id="codez" name="prodId" type="hidden" value="<?php echo $_GET['code'] ?>">
                  <div class="field btn">
                    <div class="btn-layer"></div>
                    <input type="submit" value="Submit">
                  </div>
                </form>
       </div>
       </div>
       <script src="./js /index.js" async defer></script>
    </body>
</html>