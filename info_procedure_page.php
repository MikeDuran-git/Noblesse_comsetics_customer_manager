<!DOCTYPE html>
<html>
<title>Noblesse Cosmetics Client page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="./layouts/info_client_page.css">

</head>

<style>

</style>

<body style="background-color: burlywood;">


<!--DATABASE CONNECTION + GET CLIENT INFO-->
    <?php
    include 'connexion.php';
    session_start();
    $client_id=$_GET['client_id'];

    //Client Data
    ?>
<!--DATABASE CONNECTION END-->



    <!--HEADER-->
    <header id="main_header">
        <h1>Info du Rendezvous</h1>
    </header>
    <!--END_HEADER-->
    



    <!--CENTER-->
    <div class="container" id="main_center">
        <?php
        $infos_to_send="location.href='info_client_page.php?client_id=1'";
        echo "
        <input type='button' onClick=".$infos_to_send." value='Retour à la liste des clients'>    
        "
        ;
        ?>

      <!--  <input type='button' onClick="location.href='info_client_page.php?client_id=1'" value='Retour à la liste des clients'>
-->
        <!--Infos of the rdv-->
        <div id= "infos_rdv">
            <?php
                echo '<strong>Procédure effectuée:</strong><br>';
            ?>
        </div>
        <!--Infos of the rdv END-->



        <!--CLIENT BOUTON ADD REMOVE AND MOD -->
        <div id= "bouton_clients">

        </div>    
        <!--CLIENT BOUTON ADD REMOVE AND MOD END-->
    
    
    </div>
    <!--END CENTER-->



<!--FOOTER-->
<footer id="main_footer">
</footer>
<!--END_FOOTER-->





</body>
</html>