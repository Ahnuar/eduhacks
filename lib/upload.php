<?php
    $session=isset($_COOKIE['PHPSESSID']);
    if($session && isset($_POST['Cname'])  && isset($_POST['Cdescription']) && isset($_POST['Chashtag']) && isset($_POST['Cflag'])){
        session_start();
        if(isset($_SESSION['Usuari'])){
            require 'database.php';
            //insertar el challenge
            insertchallenges($_POST['Cname'],$_POST['Cdescription'],$_POST['Cflag']);
            //id del reto
            $idreto=getidretos($_POST['Cname']);

            $array = $_POST['Chashtag'];
            $hashtagarray =  explode ( ' ', $array);
            inserthastag($hashtagarray,$idreto);
        }

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if ($_FILES["fileToUpload"]["size"] > 500000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
        }
        
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
          // if everything is ok, try to upload file
          } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            } else {
              echo "Sorry, there was an error uploading your file.";
            }
          }
















        header("Location: challengs.php");        
        exit();
    }else{
     
      header("Location: challengs.php");        
        exit();
    }