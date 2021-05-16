<!DOCTYPE html>
<html>
<title>Noblesse Cosmetics Client List</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="./layouts/index.css">

</head>
<body style="background-color: burlywood;">


<!--DATABASE CONNECTION-->
    <?php
    include 'connexion.php';
    session_start();

    $_SESSION["sql_requests"]="";


    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
        $url = "https://";   
    else  
        $url = "http://";   
        // Append the host(domain name, ip) to the URL.   
        $url.= $_SERVER['HTTP_HOST'];   
        // Append the requested resource location to the URL   
        $url.= $_SERVER['REQUEST_URI'];    

    function add_client_to_database($db){
        try{
            $sql="INSERT into clients (nom,prenom,date_naissance,num_tel,Email) VALUES ('ajouter un nom à ce client','ajouter un prénom ici','0000-00-00','ajouter un numero de tel à ce client','ajouter un Email à ce client')";
            $db->query($sql);
        }
        catch(Exception $e){
            print $e->getMessage();
            echo 'Unsuccessful insert request';
        }
    }

    function rm_client_from_database($db,$client_id){
        try{
            //delete client
            $sql="DELETE from clients WHERE id=".$client_id."";
            $db->query($sql);
        }
        catch(Exception $e){
            print $e->getMessage();
            echo 'Unsuccessful drop request';
        }

    }
    function hide_select_client_and_show_rm_client__buttons($db){
        $result= $db->prepare("select id from clients");
        $result->setFetchMode(PDO:: FETCH_OBJ);
        $result->execute(); 
        while($row = $result->fetch()){
             #hide the form button
             $rdv="form_".$row->id;
             echo "
                if(!!document.getElementById('".$rdv."')){
                    document.getElementById('".$rdv."').style='display:none;';
                }
                ";
            #show the drop form buttons
            $rdv="drop_form_".$row->id;
            echo "
                if(!!document.getElementById('".$rdv."')){
                    document.getElementById('".$rdv."').style='display:true;';
                }
                ";          
         }
     }

     function show_select_clients_buttons($db){
        $result= $db->prepare("select id from clients");
        $result->setFetchMode(PDO:: FETCH_OBJ);
        $result->execute(); 
        while($row = $result->fetch()){
             #hide the form button
             $rdv="form_".$row->id;
             echo "
                if(!!document.getElementById('".$rdv."')){
                    document.getElementById('".$rdv."').style='display:true;';
                }
                ";
            #show the drop form buttons
            $rdv="drop_form_".$row->id;
            echo "
                if(!!document.getElementById('".$rdv."')){
                    document.getElementById('".$rdv."').style='display:none;';
                }";           
         }
     }
    function database_print($db,$result){
        $result->setFetchMode(PDO:: FETCH_OBJ);
        $result->execute();
        $counter=0;
        while($row = $result->fetch()){
            $counter+=1;
            echo '            
            <tr>
            <td>
                <div id="form_'.$row->id.'">
                    <form action="info_client_page.php?client_id='.$row->id.'" method="POST"> 
                        <input type="submit" style="text-align: center;" value="Choisir ce client" name="select_'.$row->id.'">
                    </form>
                </div>

                <div id="drop_form_'.$row->id.'" style="display:none;">
                    <form method="POST"> 
                        <input type="submit" style="text-align: center;" value="Enlever le client '.$row->id.' " name="drop_row_'.$row->id.'">
                    </form>
                </div>
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
            if(isset($_POST["drop_row_".$row->id])){
                //add a question to be sure to delete the client
                
                //delete the client

                rm_client_from_database($db,$row->id);
                //reload the page
                echo "<script>alert('".$row->id." removed');</script>";
                echo '
                <script>
                    location.href="index.php?";
                </script>';


            }
        };
        if($counter==0){ echo "Le nom, le prenom ou le numero de telephone de ce Client n'existe pas";}
    };
    ?>
<!--DATABASE CONNECTION END-->


    <!--HEADER-->
    <header id="main_header">
        <h1>Liste des Clients</h1>
    </header>
    <!--END_HEADER-->


    <!--CENTER-->
    <div class="container" id="main_center">
        
        <div id="mod_button"> 
            <button onclick="mod_button_clicked()">Modifier</button> 
        </div>
        <!-- ADD CLIENT BUTTON -->
        <div>
        <form method=post>
            <button style="visibility: hidden;" type="submit" id="add_client_button" name="add_client_button_submit">Ajouter un Client</button>
        </form>
        <!-- ADD CLIENT BUTTON END-->

        <!-- RM CLIENT BUTTON -->
        <!-- <form method=post> -->
            <button style="visibility: hidden;" id="rm_client_button" name="rm_client_button_submit" onclick="rm_client_button_clicked()">Enlever un Client</button>
        <!-- </form> -->
        <!-- RM CLIENT BUTTON END -->


        <!--Searchbar-->      
            <form name="form" method="post">
                <input id="search_bar" name="search" type="text" placeholder="Search..">
                <input type="submit" name="submit">
            
            </form>
        <!--END Searchbar-->

        </div>


        
        <!--DB_content-->
        <div id="client_list">
            <table>
                <tr>
                    <th>Bouton selection</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                </tr>

                <!--PHP input structure-->
                <?php
    
                    if(isset($_POST['submit'])) {
                        $client_name= $_POST['search'];

                        //le cas si il n'y a pas de nom spécifié
                        if (strlen($client_name)==0){
                            
                            $result= $db->prepare("SELECT * FROM `clients`");
                        }
                        else{
                        //le cas si il y a un nom donner
                            $result= $db->prepare("SELECT * FROM `clients` WHERE nom='$client_name' or prenom='$client_name' or num_tel='.$client_name.'");
                        }

                        database_print($db,$result);
                    }
                else{
                    $result= $db->prepare("SELECT * FROM `clients`");
                    
                    database_print($db,$result);
                }
                echo $_SESSION["sql_requests"];
                ?>
                <!--PHP input structure END-->
            </table>

        </div>
        <!--END DB_content-->
    </div>
    <!--END CENTER-->



<!--FOOTER-->
<footer id="main_footer">
</footer>
<!--END_FOOTER-->

<script>


//hide buttons functions
<?php 
if(isset($_POST['add_client_button_submit'])){
    //add client to database
    add_client_to_database($db);

    //switch page to this new clients informations
        $gid=$db->prepare("SELECT MAX(id) as maximum FROM clients");
        $gid->execute();
        $max_val = $gid->fetch(PDO::FETCH_ASSOC);
        $max_val=$max_val['maximum'];
        $infos_to_send='client_id='.$max_val.'';
        echo 'location.href="info_client_page.php?'.$infos_to_send.'";';
}
?>

function rm_client_button_clicked(){

<?php
    hide_select_client_and_show_rm_client__buttons($db);
?>

    show_saving_button();
}

//functions to alter the modification button


function show_saving_button(){
        document.getElementById("mod_button").innerHTML=
        "<button id='save_content_button' onclick='save_content()'>Sauvegarder</button>";
}

function save_content(){
    location.href="index.php?";
    hide_add_and_rm_button();
}

function hide_mod_button(){
    show_saving_button();
}

function show_mod_button(){
        document.getElementById("save_content_button").innerHTML='            <button onclick="mod_button_clicked()">Modifier</button> ';
}

function hide_add_and_rm_button(){
    document.getElementById("add_client_button").style="visibility:hidden";
    document.getElementById("rm_client_button").style="visibility:hidden";
}

function show_add_and_rm_button(){
    document.getElementById("add_client_button").style="visibility:visible";
    document.getElementById("rm_client_button").style="visibility:visible";
}


function mod_button_clicked(){
    show_add_and_rm_button();
    hide_mod_button();

}

</script>



</body>
</html>