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

        $counter=0; //compter les rdv
        while($row = $result->fetch()){
            $counter+=1;
            $infos_to_send='client_id='.$client_id.
                           '&nom_client='.$nom.
                           '&id_rdv='.$row->id_rdv.
                           '';
            echo '            
            <tr>
                
                <td>
                    <form action="info_procedure_page.php?'.$infos_to_send.'" method="POST"> 
                        <input type="submit" style="text-align: center;" value="Choisir ce '.$row->id_rdv.' " name="select_'.$row->id_rdv.'">
                    </form>
                </td>

                <td>'.
                    $row->date_rdv. #date du rdv
                '</td>
                
                <td>'.
                    $row->nom_procedure. #nom de la procedure
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

        if($variable != "date")
            echo "
                <button id='change_client_".$variable."_button_id' style='display:none;' onclick='show_client_".$variable."_input()'>Changer le ".$variable." du client</button>

                <form style='display:none;' id='".$variable."_input' method='POST' enctype='multipart/form-data'>
            
                    <input id='".$variable."_input_sub' name='".$variable."_input_submit' type='text' onkeyup='Expand(this);' >
            
                    <input type='submit' name='".$variable."_submit' onclick='hide_client_".$variable."_input()'>
                </form>
            ";
        else
            echo "
                <button id='change_client_".$variable."_button_id' style='display:none;' onclick='show_client_".$variable."_input()'>Changer la ".$variable." du client</button>

                <form style='display:none;' id='".$variable."_input' method='POST' enctype='multipart/form-data'>
            
                    <input  type='date' id='".$variable."_input_sub' name='".$variable."_input_submit'>
            
                    <input type='submit' name='".$variable."_submit' onclick='hide_client_".$variable."_input()'>
                </form>
            ";
    }

    function set_client_name($db,$client_id,$new_client_name){
        try{
            $sql="UPDATE clients SET nom='".$new_client_name."' WHERE id=".$client_id.";";
            
            $db->query($sql);
        }
        catch(Exception $e){
            print $e->getMessage();
            echo 'INSERTING NEW CLIENT NAME FAILED';
        }
    }

    function set_client_tel($db,$client_id,$new_client_tel){
        try{
            $sql="UPDATE clients SET num_tel='".$new_client_tel."' WHERE id=".$client_id.";";
            
            $db->query($sql);
        }
        catch(Exception $e){
            print $e->getMessage();
            echo 'INSERTING NEW CLIENT Phone number FAILED';
        }
    }

    function set_client_surname($db,$client_id,$new_client_surname){
        try{
            $sql="UPDATE clients SET prenom='".$new_client_surname."' WHERE id=".$client_id.";";
            
            $db->query($sql);
        }
        catch(Exception $e){
            print $e->getMessage();
            echo 'INSERTING NEW CLIENT surname FAILED';
        }
    }

    function set_client_Email($db,$client_id,$new_client_Email){
        try{
            $sql="UPDATE clients SET Email='".$new_client_Email."' WHERE id=".$client_id.";";
            
            $db->query($sql);
        }
        catch(Exception $e){
            print $e->getMessage();
            echo 'INSERTING NEW CLIENT Email FAILED';
        }
    }

    function set_client_date($db,$client_id,$new_client_date){
        try{
            $sql="UPDATE clients SET date_naissance='".$new_client_date."' WHERE id=".$client_id.";";
            
            $db->query($sql);
        }
        catch(Exception $e){
            print $e->getMessage();
            echo 'INSERTING NEW CLIENT date_naissance FAILED';
        }
    }

    if(isset($_POST['name_submit'])){
        //we take the new name input
            $new_client_name=$_POST['name_input_submit'];    
        // changing the database
            set_client_name($db,$client_id,$new_client_name); 
        //refresh the page
        header("Refresh:0");
    }
    
    if(isset($_POST['tel_submit'])){
        //we take the new tel input
            $new_client_tel=$_POST['tel_input_submit'];    
        // changing the database
            set_client_tel($db,$client_id,$new_client_tel); 
        //refresh the page
        header("Refresh:0");
    }

    if(isset($_POST['surname_submit'])){
        //we take the new surname input
            $new_client_surname=$_POST['surname_input_submit'];    
        // changing the database
            set_client_surname($db,$client_id,$new_client_surname); 
        //refresh the page
        header("Refresh:0");
    }
    if(isset($_POST['Email_submit'])){
        //we take the new Email input
            $new_client_Email=$_POST['Email_input_submit'];    
        // changing the database
            set_client_Email($db,$client_id,$new_client_Email); 
        //refresh the page
        header("Refresh:0");
    }

    if(isset($_POST['date_submit'])){
        //we take the new date input
            $new_client_date=$_POST['date_input_submit'];    
        // changing the database
            set_client_date($db,$client_id,$new_client_date); 
        //refresh the page
            header("Refresh:0");
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
                        <?php 
                                echo '<strong>Nom:</strong><br>
                                <p id="content_nom">'.$nom.'</p>';
                                display_adapted_form("name");
                        ?>
                         
                    </td>

                    <td>
                        	<?php 
                                echo '<strong>numero Telephone:</strong><br>  <p id="content_tel">'.$tel.'</p>';
                                display_adapted_form("tel");
                            ?>
                                                
                            
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php 
                            echo '<strong>Prénom:</strong><br>  <p id="content_prenom">'.$prenom.'</p>';
                            display_adapted_form("surname");
                        ?>
                    </td>
                    <td>
                        <?php 
                            echo '<strong>Email:</strong><br>  
                            <p id="content_Email">'.$Email.'</p>';
                            display_adapted_form("Email");
                        ?>
                    </td>

                </tr>
                <tr>
                    <td>
                        <?php 
                            echo '<strong>Date de naissance:</strong><br>  
                            <p id="content_date">'.$date_naissance.'</p>';
                            
                            display_adapted_form("date");
                        ?>
                    </td>
                </tr>
            </table>

        </div>    
        <!--CLIENT INFO END -->


        <!--CLIENT BOUTON ADD REMOVE AND MOD -->
        <div id= "bouton_clients" style="visibility: hidden;">
            <?php
                echo '<button>Ajout Rendez-vous</button>';
                echo '<button >Enlever un Rendez-vous</button>';
            ?>
        </div>    
        <!--CLIENT BOUTON ADD REMOVE AND MOD END-->

        <!--Appointment of client-->
        <div id= "rdv_client" style="margin-top: 0%;" >
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