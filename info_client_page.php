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


#client_info, #bouton_clients, #rdv_client{
    margin-top: 10%;
}



</style>
<body style="background-color: burlywood;">


<!--DATABASE CONNECTION + GET CLIENT INFO-->
    <?php
    include 'connexion.php';
    session_start();
    
    function database_print($db,$result,$client_id,$nom){
       $result->setFetchMode(PDO:: FETCH_OBJ);
        $result->execute(); 
        //count amount

        $counter=0;
        while($row = $result->fetch()){
            $counter-=1;
            $infos_to_send='client_id='.$client_id.
                           '&nom_client='.$nom.
                           '&id_rdv='.$row->id_rdv.
                           '';
            echo '            
            <tr>
            <td>
                <form action="info_procedure_page.php?'.$infos_to_send.'" method="POST"> 
                    <input type="submit" style="text-align: center;" value="Choisir ce rendezvous" name="select_'.$counter.'">
                </form>
            </td>
            <td>'.
                $row->date_rdv. #prenom
            '</td>
            <td>'.
                $row->nom_procedure. #nom
            '</td>
            ';
        };
        if($counter==0){ echo "Le client n'a pas de rdv";}
    };

    //Client Data
    $client_id=$_GET['client_id'];

    $result= $db->prepare("SELECT * FROM clients where clients.id=".$client_id.";");
    $result->setFetchMode(PDO:: FETCH_OBJ);
    $result->execute(); 
    while($row = $result->fetch()){
        $nom=$row->nom;
        $prenom=$row->prenom;
        $Email=$row->Email;
        $date_naissance=$row->date_naissance;
        $tel=$row->num_tel;
    }

    function display_adapted_form($variable){
        echo "
        <button id='change_client_".$variable."_button_id' style='display:none;' onclick='show_client_".$variable."_input()'>Chang le ".$variable." du client</button>

        <form style='display:none;' id='".$variable."_input' method='POST' enctype='multipart/form-data'>
            
            <input id='".$variable."_input_sub' name='".$variable."_input_submit' type='text' onkeyup='Expand(this);' >
            
            <input type='submit' name='".$variable."_submit' onclick='hide_client_".$variable."_input()'>
            </form>
        ";
    }
    ?>
<!--DATABASE CONNECTION END-->



    <!--HEADER-->
    <header id="main_header">
        <h1>Info du Client</h1>
    </header>
    <!--END_HEADER-->



    <!--CENTER-->
    <div class="container" id="main_center">
        <!-- Retour a la page d'accueil -->
            <input type=button onClick="location.href='index.php'" value='Retour à la liste des clients'><br>
        <!-- Retour a la page d'accueil END-->

        <!--button to modify content-->
        <div  id="modify_content_button">
            <button onclick="modify_content()" style="margin-top: 2%;" >MODIFIER</button>
        </div>
        <!--button to modify content END-->


        <!--CLIENT INFO-->
        <div id='client_info'>
            <table style="width:100%">
                <tr>
                    <td>
                        <?php echo '<strong>Nom:</strong><br>'.$nom;?>
                        
                        <button id='change_client_name_button_id' style='display:none;' onclick='show_client_name_input()'>Chang le nom du client</button>

                        <form style='display:none;' id='name_input' method='POST' enctype='multipart/form-data'>
                            
                            <input id='name_input_sub' name='name_input_submit' type='text' onkeyup='Expand(this);' >
                            
                            <input type='submit' name='name_submit' onclick="hide_client_name_input()">
                            </form>
                    </td>

                    <td>
                        	<?php echo '<strong>numero Telephone:</strong><br>'.$tel;?>
                                                   
                        <button id='change_client_tel_button_id' style="display:none;" onclick='show_client_tel_input()'>Chang le telephone du client</button>

                        <form style="display:none;" id="tel_input" method="POST" enctype="multipart/form-data">
    
                            <input id="tel_input_sub" name="tel_input_submit" type="text" onkeyup="Expand(this);" >
    
                            <input type="submit" name="tel_submit" onclick="hide_client_tel_input()">
                        </form>
                            
                    </td>
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
        <table style="text-align:center;">
                <tr>
                    <th>Bouton selection</th>
                    <th>Date du rdv</th>
                    <th>Procédure appliquée</th>
                </tr>
                <?php
                    $result= $db->prepare("SELECT * FROM rendezvous, clients where rendezvous.id_client=".$client_id." and clients.id=".$client_id." ORDER BY date_rdv Desc;");
                    
                    database_print($db,$result,$client_id,$nom);
                ?>
        </table>
        </div>
        <!--Appointment of client END-->



        <!--CLIENT BOUTON ADD REMOVE AND MOD -->
        <div id= "bouton_clients">
        <?php
            echo '<button>Ajout Rendez-vous</button>';
            echo '<button >Enlever un Rendez-vous</button>';
            ?>
        </div>    
        <!--CLIENT BOUTON ADD REMOVE AND MOD END-->
    
    
    </div>
    <!--END CENTER-->



<!--FOOTER-->
<footer id="main_footer">
</footer>
<!--END_FOOTER-->

<script src="info_client_page.js">
</script>



</body>
</html>