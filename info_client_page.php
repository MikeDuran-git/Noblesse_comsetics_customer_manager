<!DOCTYPE html>
<html>
<title>Noblesse Cosmetics Client page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="./layouts/info_client_page.css">

</head>

<style>
table, th, td {
    border: 1px solid black;
    padding: 5px;
  }
table {
    border-spacing: 15px;
}

#client_info{
    margin-top: 10%;
}


</style>
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


        <!--CLIENT INFO-->

        <div id='client_info'>
            <table style="width:100%">
                <tr>
                    <td><?php echo '<strong>Nom:</strong><br>'.$nom;?></td>
                    <td><?php echo '<strong>numero Telephone:</strong><br>'.$tel;?></td>
                </tr>
                <tr>
                    <td><?php echo '<strong>Prénom:</strong><br>'.$prenom; ?></td>
                    <td><?php echo '<strong>Email:</strong><br>'.$Email; ?></td>

                </tr>
                <tr>
                    <td><?php echo '<strong>Date de naissance:</strong><br>'.$date_naissance; ?></td>
                </tr>
            </table>

        </div>    
        <!--CLIENT INFO END -->


        <!--Appointment of client-->
        <div id= "rdv_client">

        </div>
        <!--Appointment of client END-->

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