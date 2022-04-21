<?php


    if($_POST['cflag'] && $_POST['cid']){
        require './database.php';
        $reto=getflag($_POST['cid']);
        if($_POST['cflag']==$reto){

           
            $idreto=$_POST['cid'];
            echo $idreto;
            echo $_POST['cflag'];
            insertacompletado($idreto);
            header("Location: ./challengs.php");
            exit();
        //crear una funcion que me diga si el reto esta completado o no

        echo '<script>alert("GOOD flag")</script>';
        echo '<script>window.location.href = "./challengs.php";</script>';
    }
    //crear los alerts de error
    else{
        echo '<script>alert("Wrong flag")</script>';
        echo '<script>window.location.href = "./challengs.php";</script>';
    }
}