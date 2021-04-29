<!DOCTYPE html>
<html>
<title>Noblesse Cosmetics Client page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="./layouts/info_client_page.css">

</head>
<body style="background-color: burlywood;">


<!--DATABASE CONNECTION + GET CLIENT INFO-->
    <?php
    include 'connexion.php';
    session_start();
    
    //Client Data
    $nom=$_GET['nom'];
    $prenom=$_GET['prenom'];
    $Email=$_GET['Email'];
    $date_naissance=$_GET['date'];
    $tel=$_GET['tel'];


    

    ?>
<!--DATABASE CONNECTION END-->



    <!--HEADER-->
    <header id="main_header">
        <h1>Info du Client</h1>
    </header>
    <!--END_HEADER-->



    <!--CENTER-->
    <div class="container" id="main_center">
        <input type=button onClick="location.href='index.php'" value='Retour à la liste des clients'>
        
        <p>Name: <?php echo $nom;?></p> <br>
        <p>Prenom: <?php echo $prenom; ?></p> <br>
        <p>Date de naissance: <?php echo $date_naissance; ?></p> <br>
        <p>numero Telephone: <?php echo $tel;?></p> <br>
        <p>Email: <?php echo $Email; ?></p> <br>

    </div>
    <!--END CENTER-->



<!--FOOTER-->
<footer id="main_footer">
</footer>
<!--END_FOOTER-->





</body>
</html>