<!DOCTYPE html>
<html>
<title>Noblesse Cosmetics Client page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="./layouts/info_client_page.css">

</head>

<style>
#infos_rdv{
    margin-top: 10%;
}

table, th, td {
    border: 1px solid black;
    padding: 5px;
}
</style>

<body style="background-color: burlywood;">


<!--DATABASE CONNECTION + GET CLIENT INFO-->
    <?php
    include 'connexion.php';
    session_start();
    $client_id=$_GET['client_id'];

    //Client Data
    $date_rdv=$_GET['date_rdv'];
    $nom_procedure=$_GET['nom_procedure'];
    $infos_rdv=$_GET['infos_rdv'];
    $nom=$_GET['nom_client'];


    ?>
<!--DATABASE CONNECTION END-->

    <!--HEADER-->
    <header id="main_header">

        <h1>Info du Rendezvous de <?php echo $nom;?></h1>
    </header>
    <!--END_HEADER-->
    



    <!--CENTER-->
    <div class="container" id="main_center">
        <?php
            $infos_to_send="location.href='info_client_page.php?client_id=".$client_id."'";
            echo "<input type='button' onClick=".$infos_to_send." value='Retour info du client'>";
        ?>

        <!--Infos of the rdv-->
        <div id= "infos_rdv">

            <table style="width:100%">
                <tr>
                    <td><?php echo '<strong>Procédure effectuée: </strong><br>'.$nom_procedure.'';?></td>
                    <td><?php echo '<strong>Date du rdv:</strong><br>'.$date_rdv.'';?></td>
                </tr>
                <tr>
                    <td><?php echo '<strong>infos:</strong><br>'; ?></td>
                </tr>
                <tr>
                    <td>
                        <?php echo '<strong>Image Avant:</strong><br>'; ?>
                    </td>
                    <td>
                        <?php echo '<strong>Image Après:</strong><br>'; ?>
                    </td>

                </tr>
            </table>
        </div>
        <!--Infos of the rdv END-->



        <!--CLIENT BOUTON ADD REMOVE AND MOD -->
        <div id= "bouton_clients">
        <button>Modifier</button>

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