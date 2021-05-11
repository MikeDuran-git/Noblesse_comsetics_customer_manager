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

    img{
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-top: 5%;
    }
</style>

<body style="background-color: burlywood;">


<!--DATABASE CONNECTION + GET CLIENT INFO-->
    <?php
    include 'connexion.php';
    session_start();
    $client_id=$_GET['client_id'];

    //get URL
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
            $url = "https://";   
        else  
            $url = "http://";   
        // Append the host(domain name, ip) to the URL.   
        $url.= $_SERVER['HTTP_HOST'];   
        // Append the requested resource location to the URL   
        $url.= $_SERVER['REQUEST_URI'];    
 

    //Client Data
    
    
    $date_rdv=$_GET['date_rdv'];
    $nom_procedure=$_GET['nom_procedure'];
    $infos_rdv=$_GET['infos_rdv'];
    $nom=$_GET['nom_client'];
    $id_rdv=$_GET['id_rdv'];
    
        function get_img($db,$client_id,$id_rdv,$avant_apres_bool){
        
        $result= $db->query('SELECT * FROM `images` WHERE id_client="'.$client_id.'" AND id_rdv="'.$id_rdv.'"');
        
        foreach($result as $row){
            

            $img_url=str_replace("_","/",$row[$avant_apres_bool]);
            
            echo '<img id=img_'.$row["id_img"].'_'.$avant_apres_bool.' src='.$img_url.' width="300" height="400">';
            
            //input to change image
            $upload_id="upload_id_".$row["id_img"].'_'.$avant_apres_bool;
            $submit_id="submit_".$row["id_img"]."_".$avant_apres_bool;
            $form_id='form_'.$row["id_img"].'_'.$avant_apres_bool; 
            $select_img_id='select_'.$row["id_img"].'_'.$avant_apres_bool;
            

            echo '
            <form id='.$form_id.' style="display:true;" method="POST" enctype="multipart/form-data">
                <input style="display:none" type="file" name ='.$upload_id.' id='.$upload_id.' accept="imgs/*">
                
                <button style="display:none" type="submit" name='.$select_img_id.' id='.$select_img_id.'>SELECTIONNER IMAGE</button>
                
                <button style="display:none" type="submit" name='.$submit_id.' id='.$submit_id.'>ENVOYER</button>
            </form>
            ';

            //the case we switch images.
            if(isset($_POST[$submit_id])){
                $filename=$_FILES[$upload_id]['name'];
                //change content of database
                if($avant_apres_bool=='img_avant')
                    $result= $db->query('UPDATE images 
                                SET img_avant="imgs_'.$filename.'" WHERE id_img='.$row['id_img'].' ');
                else
                    $result= $db->query('UPDATE images SET img_apres="imgs_'.$filename.'" WHERE id_img='.$row['id_img'].';');

                //change content on website
                echo '
                <script>
                    document.getElementById("img_'.$row["id_img"].'_'.$avant_apres_bool.'").src="imgs/'.$filename.'";
                </script>
                ';
                echo '<script>alert("contenu sauvegardé");</script>';

            }
          
            //the image is selected to be removed 
            if(isset($_POST[$select_img_id])){
                //change content on the database
                if($avant_apres_bool=='img_avant'){
                    $result= $db->query('UPDATE images SET img_avant="imgs_Empty.png" WHERE id_img='.$row['id_img'].';');
                }
                else{
                    $result= $db->query('UPDATE images SET img_apres="imgs_Empty.png" WHERE id_img='.$row['id_img'].';');
                }
                //change content on the page
                echo '
                <script>
                    document.getElementById("img_'.$row["id_img"].'_'.$avant_apres_bool.'").src="imgs/Empty.png";
                </script>
                ';
                echo '<script>alert("contenu sauvegardé");</script>';

            }  

            
        }
    }

    function show_only_select_img_button($counter){
        
            //hide datei_auswählen buttons
            echo 'document.getElementById("upload_id_'.$counter.'_img_avant").style="display:none";';
            echo 'document.getElementById("upload_id_'.$counter.'_img_apres").style="display:none";';

            //hide envoyer button
            echo 'document.getElementById("submit_'.$counter.'_img_avant").style="display:none";';
            echo 'document.getElementById("submit_'.$counter.'_img_apres").style="display:none";';

            //show selectionner button
            echo 'document.getElementById("select_'.$counter.'_img_avant").style="display:true";';
            echo 'document.getElementById("select_'.$counter.'_img_apres").style="display:true";';



    }

    function hide_select_envoyer_datei_auswahl_button($counter){
          //hide datei_auswählen button
          echo 'document.getElementById("upload_id_'.$counter.'_img_avant").style="display:none";';
          echo 'document.getElementById("upload_id_'.$counter.'_img_apres").style="display:none";';

          //hide envoyer button
          echo 'document.getElementById("submit_'.$counter.'_img_avant").style="display:none";';
          echo 'document.getElementById("submit_'.$counter.'_img_apres").style="display:none";';

          //hide selectionner button
          echo 'document.getElementById("select_'.$counter.'_img_avant").style="display:none";';
          echo 'document.getElementById("select_'.$counter.'_img_apres").style="display:none";';
    }

    function show_envoyer_and_datei_auswahl_button($counter){
        //show datei_auswählen button
        echo 'document.getElementById("upload_id_'.$counter.'_img_avant").style="display:true";';
        echo 'document.getElementById("upload_id_'.$counter.'_img_apres").style="display:true";';
       
        //show envoyer button
        echo 'document.getElementById("submit_'.$counter.'_img_avant").style="display:true";';
        echo 'document.getElementById("submit_'.$counter.'_img_apres").style="display:true";';
       
        //hide selectionner button
        echo 'document.getElementById("select_'.$counter.'_img_avant").style="display:none";';
        echo 'document.getElementById("select_'.$counter.'_img_apres").style="display:none";';
                   
          
    }

    function add_empty_row_to_db($db,$client_id,$id_rdv){
        //get the maximum value of all ids.
            $counter= $db->prepare("SELECT MAX(id_img) as c from images where id_client=".$client_id." AND id_rdv=".$id_rdv.";");
                    
            $counter->execute();
            $counter = $counter->fetch();
            $counter=$counter['c'];
            $new_img_id=$counter+=1;
                
        //set the sql request
            $sql= 'INSERT INTO images (id_client, id_rdv, id_img, img_avant, img_apres) VALUES ('.$client_id.','.$id_rdv.','.$new_img_id.',"imgs_Empty.png","imgs_Empty.png");';
                        
        //modify database
            $db->query($sql);
    }

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
                    <td>
                        <?php 
                            echo '<strong>Procédure effectuée: </strong><br>'.$nom_procedure.'';
                        ?>
                    </td>
                    <td>
                        <?php 
                            echo '<strong>Date du rdv:</strong><br>'.$date_rdv.'';
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php 
                            echo '<strong>infos:</strong><br>'; 
                            echo '<p>'.$infos_rdv.'</p>'
                        ?>
                    </td>
                </tr>
                <tr>
                </tr>
            </table>
            <table id="images" style="width:100%">
                <td>  
                    <strong>Image Avant:</strong><br>
                    <div id="imgs_avant_function">
                    <?php
                    get_img($db,$client_id,$id_rdv,"img_avant");
                    ?>
                    </div>
                    
                </td>
                <td >
                    <strong>Image Après:</strong><br>
                    <div id="imgs_apres_function">
                    <?php
                    get_img($db,$client_id,$id_rdv,"img_apres");
                    ?>
                    </div>
 
                </td>

            </table>

            <div id="button_add_rm" style="display: none">
                
                <form style="display:true;" method="POST" enctype="multipart/form-data">

                    <button type="submit" name='add_empty'> 
                        AJOUTER UNE IMAGE AVANT ET APRES
                    </button>
                </form>                   
                </button>                

                <button id="button_mod_img" onclick="mod_img()">
                    CHANGER UNE IMAGE
                </button>                
                
                <button id="button_rm_img" onclick="remove_img()">
                    ENLEVER UNE IMAGE
                </button>

            </div>
            
        </div>
        <!--Infos of the rdv END-->

        <!--CLIENT BOUTON ADD REMOVE AND MOD -->
        <div id= "bouton_clients" >
        <button onclick="modify_content()">Modifier</button>

        </div>    
        <!--CLIENT BOUTON ADD REMOVE AND MOD END-->
    
    
    </div>
    <!--END CENTER-->



<!--FOOTER-->
<footer id="main_footer">
</footer>
<!--END_FOOTER-->

<script type="text/javascript" src="jquery-1.3.2.js"> </script>


<script>
    <?php
    #add empty row
    if(isset($_POST['add_empty'])){
        echo 'document.getElementById("button_add_rm").style="display:none";';
        add_empty_row_to_db($db,$client_id,$id_rdv);

        echo "location.replace('".$url."')";
    }
    ?>
     
//remove image
function remove_img(){
    document.getElementById("button_add_rm").style="display:none";
    <?php
       $counter= $db->prepare("SELECT COUNT(*) as c from images where id_client=".$client_id." AND id_rdv=".$id_rdv.";");
       
       $counter->execute();
       $counter = $counter->fetch();
       $counter=$counter['c'];
       while($counter > 0){
            show_only_select_img_button($counter);
            $counter-=1;
       }
    ?>

}

//change specific image
function mod_img(){
    document.getElementById("button_add_rm").style="display:none";
    <?php
       $counter= $db->prepare("SELECT COUNT(*) as c from images where id_client=".$client_id." AND id_rdv=".$id_rdv.";");
       
       $counter->execute();
       $counter = $counter->fetch();
       $counter=$counter['c'];
       
       while($counter > 0){
            show_envoyer_and_datei_auswahl_button($counter);
            $counter-=1;
       }
    ?>
}
// prints the buttons to change the content of img
function modify_content(){
    //show content that can be modified
    document.getElementById("button_add_rm").style="display:true;";
    document.getElementById("bouton_clients").innerHTML='<button onclick="save_content()">Sauvegarder</button>';
}

//removes all buttons to change the imgs.
function save_content(){
    document.getElementById("button_add_rm").style="display:none;";
    document.getElementById("bouton_clients").innerHTML='<button onclick="modify_content()">Modifier</button>';
    <?php
       $counter= $db->prepare("SELECT COUNT(*) as c from images where id_client=".$client_id." AND id_rdv=".$id_rdv.";");
       $counter->execute();
       $counter = $counter->fetch();
       $counter=$counter['c'];
       while($counter > 0){
           hide_select_envoyer_datei_auswahl_button($counter);
            $counter-=1;
       }
    ?>

    alert("contenu sauvegardé");

}

</script>

</body>
</html>