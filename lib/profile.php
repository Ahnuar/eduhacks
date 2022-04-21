<?php
    if(isset($_COOKIE['PHPSESSID'])){
        session_start();
        if(!isset($_SESSION['Usuari'])){
            header("Location:../index.php");
            exit();
        }else{
            require 'database.php';
            //obtenemos datos de usuario para representarlo en el main
            $nombre=strtoupper(getname($_SESSION['Usuari']));
            $apellido=strtoupper(getlastname($_SESSION['Usuari']));
            $mail=getmail($_SESSION['Usuari']);
        }
    }else{
        header("Location:../index.php");
        exit();
    }  
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Eduhacks</title>
        <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <span class="d-block d-lg-none"><?php echo $nombre;?> <?php echo $apellido;?> </span>
                <span class="d-none d-lg-block"><img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="../assets/img/profile.jpg" alt="..." /></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">Profile</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="./challengs.php">Learn</a></li>
                   
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#awards">Awards</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="./logout.php">Log out</a></li>
                </ul>
            </div>
        </nav>
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <!-- About-->
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-0">
                    <?php echo $nombre;?>
                        <span class="text-primary"><?php echo $apellido;?></span>
                    </h1>
                    <div class="subheading mb-5">
                        <p>Your email:  </p>
                        <a href="mailto:name@email.com"><?php echo $mail;?></a>
                    </div>
                    <p class="lead mb-5">Current level : NOOB</p>
                </div>
            </section>
            <hr class="m-0" />
            <!-- Experience
            <section class="resume-section" id="experience">
                <div class="resume-section-content">
                    <h2 class="mb-5">CHALLENGE</h2>
                    
                    <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                            <div class="flex-grow-1">
                                <h3 class="mb-0"><i><a type="button"  data-bs-toggle="modal" data-bs-target="#exampleModal">Upload Challenge</a></i></h3>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Upload Challenge</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                                    Select image to upload:
                                                    <input type="file" name="fileToUpload" id="fileToUpload">
                                                    <input type="submit" value="Upload Image" name="submit">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-primary"><i>Upload Is Available</i></span>
                            </div>
                    </div>
                    
                    -->
                  
                    <?php
                    /* 
                        require './database.php';
                        if(!comprobarRetos($mail)){
                            echo '                    
                            <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">No tienes retos</h3>
                                <p>No has creado ningún reto aún. Aquí tienes algunos retos que podrian inspirarte.</p>
                            </div>
                                <div class="flex-shrink-0"><span class="text-primary">Upload Is Available</span></div>
                            </div>';

                            $retos=getretos();
                            foreach ($retos as $reto) {
                                echo '                    
                                <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                                <div class="flex-grow-1">
                                    <h3 class="mb-0">'.$reto['titol'].'</h3>
                                    <p>'.$reto['descripcion'].'</p>
                                </div>
                                    <div class="flex-shrink-0"><span class="text-primary">Available</span></div>
                                </div>'; 
                            }

                        } else{
                            echo '                    
                            <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">Tu último reto subido</h3>
                                <p>Aquí tienes tu ultimo reto subido!</p>
                            </div>
                                <div class="flex-shrink-0"><span class="text-primary">Available</span></div>
                            </div>';

                            $lastreto=getretosUsu($mail);
                            echo '                    
                            <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">'.$lastreto['titol'].'</h3>
                                <p>'.$lastreto['descripcion'].'</p>
                            </div>
                                <div class="flex-shrink-0"><span class="text-primary">Available</span></div>
                            </div>';
                        }
                        */
                    ?>
                </div>
            </section>
            <hr class="m-0" />
            
            <!-- Awards-->
            <section class="resume-section" id="awards">
                <div class="resume-section-content">
                    <h2 class="mb-5">Awards</h2>
                    <ul class="fa-ul mb-0">
                        <li>
                            <span class="fa-li"><i class="fas fa-trophy text-warning"></i></span>
                            BASIC PENTESTING
                        </li>
                        <li>
                            <span class="fa-li"><i class="fas fa-trophy text-warning"></i></span>
                            MR ROBOT CTF    
                        </li>
                        <li>
                            <span class="fa-li"><i class="fas fa-trophy text-warning"></i></span>
                            BLUE
                        </li>
                        <li>
                            <span class="fa-li"><i class="fas fa-trophy text-warning"></i></span>
                            LINUX PRIVESC
                        </li>
                        
                    </ul>
                </div>
            </section>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
