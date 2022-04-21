<?php
        if(isset($_GET["mail"])&& isset($_GET["code"])){
            require 'database.php';
            //obtenemos el codigo del user
            $mailcode=getcodeuser($_GET["mail"]);
            if($mailcode==$_GET["code"]){
                //hacemos el update para activarlo
                $activo=updateActiveUser($_GET["mail"]);
                //alerts
                if($activo){
                    echo '<script language="javascript">';
                            echo 'alert("Se ha activado su usuario correctamente.")';
                            echo '</script>';
                }else{
                    echo '<script language="javascript">';
                    echo 'alert("Algo salió mal)';
                    echo '</script>';
                }
            }else{
                //redirigir al login
                echo '<script language="javascript">';
                echo 'alert("No existe el codigo especificado en la base de datos.")';
                echo '</script>';
                header("Location: ../index.php");
                exit();
            } 

        }else{
            header("Location: ../index.php");
            exit();

        }
