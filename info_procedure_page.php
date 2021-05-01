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


#client_info{
    margin-top: 10%;
}

#bouton_clients{
    margin-top: 10%;
}


</style>
<body style="background-color: burlywood;">


<!--DATABASE CONNECTION + GET CLIENT INFO-->
    <?php
    include 'connexion.php';
    session_start();
    
    function database_print($result){
        $result->setFetchMode(PDO:: FETCH_OBJ);
        $result->execute();
        $counter=0;
        while($row = $result->fetch()){
            $counter+=1;
            echo '            
            <tr>
            <td>
                <form action="info_procedure_page.php?nom='.$row->nom.'&prenom='.$row->prenom.'&Email='.$row->Email.'&date='.$row->date_naissance.'&tel='.$row->num_tel.'" method="POST"> 
                    <input type="submit" style="text-align: center;" value="Choisir ce client" name="select_'.$counter.'">
                </form>
            </td>
            <td>'.
                $row->prenom. #prenom
            '</td>
            <td>'.
                $row->nom. #nom
            '</td>
            <td>'.
                $row->Email. # email
            '</td>
            ';
        };
        if($counter==0){ echo "Le nom, le prenom ou le numero de telephone de ce Client n'existe pas";}
    };


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
        <h1>Info du Rendezvous</h1>
    </header>
    <!--END_HEADER-->



    <!--CENTER-->
    <div class="container" id="main_center">

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