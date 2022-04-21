<?php
    //Conexion a base de datos
    function databaseConnection(){
        $cadena_connexio = 'mysql:dbname=eduhacks;host=localhost';
        $usuari='root';
        $passwd='';
        try{
            $db= new PDO($cadena_connexio,$usuari,$passwd,
                            array(PDO::ATTR_PERSISTENT => true));
        }catch(PDOException $e){
            echo'Error amb la db' . $e ->getMessage();
        }
        return $db;
    }

    //hacemos el insert a la base de datos del usuario
    function insertUser($user,$Email,$password,$nombre,$apellido,$code){
        //corregir la password
        $db=databaseConnection();
        $passHash= password_hash($password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users`(mail,username,passHash,userFirstName,userLastName,creationDate,active,code) VALUES(:mail,:user,:pass,:nombre,:apellido,addtime(now(),3000),0,:code)";
        $insert = $db->prepare($sql);
        return $insert->execute(array(':user' =>$user, ':mail' =>$Email,':pass'=>$passHash, ':nombre'=>$nombre,':apellido'=>$apellido,':code'=>$code));
    }
    //comprobamos si existe el usuario
    function ComprobarUsuarios($username){
        $db=databaseConnection();
        //estamos comprobando usuarios
        $sql='SELECT username FROM `users` WHERE username= :rol';
        $Comprobar_Usuario = $db->prepare($sql);
        $Comprobar_Usuario->execute(array(':rol' =>$username));
        if($Comprobar_Usuario){
            $usuario= $Comprobar_Usuario->rowcount()>0 ? true : false;
        }
        return $usuario;
        
    }
    //comprobamos si existe el MAIl
    function ComprobarMail($mail){
        $db=databaseConnection();
        //Comprobamos Mail
        $sql='SELECT mail FROM `users` WHERE mail= :rol';
        $Comprobar_Mail = $db->prepare($sql);
        $Comprobar_Mail->execute(array(':rol' =>$mail));
        if($Comprobar_Mail){
            $email= $Comprobar_Mail->rowcount()>0 ? true : false;
        }
        return $email;
    }
    //comprobamos el username y la password
    function ComprobarPassword($username,$password){
        $db=databaseConnection();
        //comprobamos la password
        $sql='SELECT passHash FROM `users` WHERE username= :rol';
        $usuario = $db->prepare($sql);
        $usuario->execute(array(':rol' =>$username));
        if($usuario){
            foreach($usuario as $user){
                return password_verify($password,$user['passHash']);
            }
        }

    }
    //comprobamos el usuario si esta activo
    function UsuarioActiu($username){
        $db=databaseConnection();
        
        $sql='SELECT active FROM `users` WHERE username= :rol';
        $usuario = $db->prepare($sql);
        $usuario->execute(array(':rol' =>$username));
        if($usuario){
            foreach($usuario as $user){
                $actiu=$user['active']==1 ? true:false;
            }
        }   
        return $actiu;
    }
    //Update de ultimo login
    function LastSignIn($username){
        $db=databaseConnection();
        $sql="UPDATE `users` SET `lastSignIn` = CURRENT_TIME() WHERE username=:username";
        $usuario = $db->prepare($sql);
        $usuario->execute(array(':username' =>$username));
        
    }
    
    //update para activar el usuario
    function updateActiveUser($mail){
        $db=databaseConnection();
        $sql ="UPDATE users set active=1 where mail=:rol";
        $activo = $db->prepare($sql);
        return $activo->execute(array(':rol' =>$mail)); 
    }
    //Obtener el nombre de usuarios
    function getname($username){
        $db=databaseConnection();
        $sql='SELECT userFirstName FROM `users` WHERE username= :rol';
        $usuario = $db->prepare($sql);
        $usuario->execute(array(':rol' =>$username));
        if($usuario){
            foreach($usuario as $user){
                return $user['userFirstName'];
            }
        }
    }
    //obtener el apellido del usuario
    function getlastname($username){
        $db=databaseConnection();
        $sql='SELECT userLastName FROM `users` WHERE username= :rol';
        $usuario = $db->prepare($sql);
        $usuario->execute(array(':rol' =>$username));
        if($usuario){
            foreach($usuario as $user){
                return $user['userLastName'];
            }
        }
    }   
    //obtener mail del user
    function getmail($username){
        $db=databaseConnection();
        $sql='SELECT mail FROM `users` WHERE username= :rol';
        $usuario = $db->prepare($sql);
        $usuario->execute(array(':rol' =>$username));
        if($usuario){
            foreach($usuario as $user){
                return $user['mail'];
            }
        }
        
    }
    //obtener codigo del user
    function getcodeuser($mail){
        $db=databaseConnection();
        $sql='SELECT code FROM `users` WHERE mail= :rol AND expiryDate >= now()';
        $usuario = $db->prepare($sql);
        $usuario->execute(array(':rol' =>$mail));
        if($usuario){
            foreach($usuario as $user){
                return $user['code'];
            }
        }
        
    }

    
    //restablecer la contraseña
    function updatepwd($user,$pwd){
        $db=databaseConnection();
        $sql = "UPDATE users set pwd=".$pwd." where user=:rol";
        $reset = $db->prepare($sql);
        return $reset->execute(array(':rol' =>$user)); 
    }

    //insertar el codigo en la base de datos
    function insertcode ($code,$mail){
        $db=databaseConnection();
        $sql="UPDATE `users` SET `code` = :code WHERE mail=:mail";
        $usuario = $db->prepare($sql);
        $usuario->execute(array(':username' =>$mail,':code' =>$code));
    }
    //insertar el current time
    function insertcurrenttime($mail){
        $db=databaseConnection();
        $sql="UPDATE `users` SET `expiryDate` = addtime(now(),3000) WHERE mail=:mail";
        $usuario = $db->prepare($sql);
        $usuario->execute(array(':mail' =>$mail));
    }
    //get user name
    function getusername($mail){
        $db=databaseConnection();
        $sql='SELECT username FROM `users` WHERE mail= :rol';
        $usuario = $db->prepare($sql);
        $usuario->execute(array(':rol' =>$mail));
        if($usuario){
            foreach($usuario as $user){
                return $user['username'];
            }
        }
    }
  
    //Obtener un array con todos los retos de la DB
    function getretos(){
        $db=databaseConnection();
        $sql='SELECT titulo,descripcion,iduser,idreto FROM retos ORDER BY fecha DESC';
        $retos = $db->prepare($sql);
        $retos->execute(array());
        return $retos;
    }

    //Obtener un array con todos los retos del usuario especificado
    function getuserchallenges($mail){
        $db=databaseConnection();
        $sql='SELECT r.titulo,r.descripcion,r.flag,r.idreto FROM retos r JOIN users u ON r.iduser = u.iduser WHERE u.mail= :rol';
        $retosUsu = $db->prepare($sql);
        $retosUsu->execute(array(':rol' =>$mail));
        if($retosUsu){
            return $retosUsu;
        }
    }
    //get user id
    function getuserid($mail){
        $db=databaseConnection();
        $sql='SELECT iduser FROM users WHERE mail= :rol';
        $usuario = $db->prepare($sql);
        $usuario->execute(array(':rol' =>$mail));
        if($usuario){
            foreach($usuario as $user){
                return $user['iduser'];
            }
        }
    }

    
    //insert challenges
    function insertchallenges($Cname,$Cdescription,$Cflag){
        $db=databaseConnection();
        $mail=getmail($_SESSION['Usuari']);
        $id=getuserid($mail);
        $sql = "INSERT INTO `retos`(titulo,descripcion,puntos,flag,fecha,iduser) VALUES(:titulo,:descripcion,10,:flag,addtime(now(),3000),:iduser)";
        $insert = $db->prepare($sql);
        $insert->execute(array(':titulo' =>$Cname, ':descripcion' =>$Cdescription,':flag'=>$Cflag, ':iduser'=>$id));
    }

    //insert hastag
    function inserthastag($hashtagarray,$idchallenge){
    
        $db=databaseConnection();

        foreach ($hashtagarray as $hashtag) {
            $sql = "INSERT INTO `categories`(`name`) VALUES (:hastag)";
            $insert = $db->prepare($sql);
            $insert->execute(array(':hastag' =>$hashtag));
            //select id de la categoria
            $idhastag=getidcategorias($hashtag);
           
            $sql2 = "INSERT INTO `catretos`(`idretos`, `idcategorias`) VALUES (:idreto,:idcategory)";
            $insert2 = $db->prepare($sql2);
            $insert2->execute(array(':idreto' =>$idchallenge, ':idcategory' =>$idhastag));
            
        }
    }
    

    //select id retos
    function getidretos($Cname){
        $db=databaseConnection();   
        $sql = "SELECT idreto FROM retos WHERE titulo = :titulo";
        $idformretos = $db->prepare($sql);
        $idformretos->execute(array(':titulo' =>$Cname));
        foreach($idformretos as $idreto){
            return $idreto[0];
        }
    }
    //select id categorias
    function getidcategorias($hashtag){
        $db=databaseConnection();   
        $sql = "SELECT id FROM categories WHERE name = :hastag";
        $idfromcategorias = $db->prepare($sql);
        $idfromcategorias->execute(array(':hastag' =>$hashtag));
        foreach($idfromcategorias as $idcat){
            return $idcat[0];
        }
    }

    //get catergories of a challenge
    function getcategories($idchallenge){
        $db=databaseConnection();
        $sql='SELECT c.name FROM categories c JOIN catretos cr ON c.id = cr.idcategorias WHERE cr.idretos = :idchallenge';
        $categories = $db->prepare($sql);
        $categories->execute(array(':idchallenge' =>$idchallenge));
        return $categories;
    }
    //get flag by id
    function getflag($idchallenge){
        $db=databaseConnection();
        $sql='SELECT flag FROM retos WHERE idreto = :idchallenge';
        $challenge = $db->prepare($sql);
        $challenge->execute(array(':idchallenge' =>$idchallenge));
        foreach($challenge as $flag){
            return $flag[0];
        }
      
    }
    //insertar completado
    function insertacompletado($idchallenge){
        $db=databaseConnection();
        session_start();
        $mail=getmail($_SESSION['Usuari']);
        $id=getuserid($mail);

        echo $id;
        $sql = "INSERT INTO `completado`(`idreto`, `iduser`) VALUES (:idchallenge,:iduser)";
        $insert = $db->prepare($sql);
        $insert->execute(array(':idchallenge' =>$idchallenge, ':iduser' =>$id));
    }

    //get completado
    function getcompletadobyid($idchallenge){

        $db=databaseConnection();
        $mail=getmail($_SESSION['Usuari']);
        $id=getuserid($mail);
        $sql='SELECT * FROM completado WHERE idreto = :idchallenge and iduser = :iduser';

        $completado = $db->prepare($sql);
        $completado->execute(array(':idchallenge' =>$idchallenge, ':iduser' =>$id));
        return $completado;
    }