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
    /* JUST FOR THIS DEMO */

textarea{  
    width: 100%;
    white-space:normal !important;
}

</style>

<body style="background-color: burlywood;">


<!--DATABASE CONNECTION + GET CLIENT INFO-->
    <?php
    include 'connexion.php';
    session_start();


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
    $client_id=$_GET['client_id'];
    $id_rdv=$_GET['id_rdv'];
    $nom=$_GET['nom_client'];

    $result= $db->prepare("SELECT * FROM rendezvous where id_client=".$client_id." AND id_rdv=".$id_rdv.";");
    $result->setFetchMode(PDO:: FETCH_OBJ);
    $result->execute(); 
    while($row = $result->fetch()){
        $date_rdv=$row->date_rdv;
        $nom_procedure=$row->nom_procedure;
        $infos_rdv=$row->infos_rdv;
    }
    
    
    
    function get_img($db,$client_id,$id_rdv,$avant_apres_bool,$url){
        
        $result= $db->query('SELECT * FROM `images` WHERE id_client="'.$client_id.'" AND id_rdv="'.$id_rdv.'"');
        
        foreach($result as $row){
            

            $img_url=str_replace("_","/",$row[$avant_apres_bool]);

            //input to change image
            $upload_id="upload_id_".$row["id_img"].'_'.$avant_apres_bool;
            $submit_id="submit_".$row["id_img"]."_".$avant_apres_bool;
            $form_id='form_'.$row["id_img"].'_'.$avant_apres_bool; 
            $select_img_id='select_'.$row["id_img"].'_'.$avant_apres_bool;
            $rm_row_id='row_id_'.$client_id.'_'.$id_rdv.'_'.$row['id_img'];


            echo '<img id=img_'.$row["id_img"].'_'.$avant_apres_bool.' src='.$img_url.' width="300" height="400">';

            echo '
            <form id='.$form_id.' style="display:true;" method="POST" enctype="multipart/form-data">
                <input style="display:none" type="file" name ='.$upload_id.' id='.$upload_id.' accept="imgs/*">
                
                <button style="display:none" type="submit" name='.$select_img_id.' id='.$select_img_id.'>SELECTIONNER IMAGE</button>
                
                <button style="display:none" type="submit" name='.$submit_id.' id='.$submit_id.'>ENVOYER</button>';
                
                if($avant_apres_bool=="img_avant"){
                    echo '
                    <button style="display:none; position: float;" type="submit" name='.$rm_row_id.' id='.$rm_row_id.'>Enlever cette ligne <strong>(image avant ET après)</strong></button>
                    ';
                }
            echo
            '</form>
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

            //delete row
            if(isset($_POST[$rm_row_id])){
                 $sql="DELETE FROM images WHERE id_client=".$client_id." AND id_rdv=".$id_rdv." AND id_img=".$row['id_img'];
                 $db->query($sql);
                $img_id_avant='img_'.$row["id_img"].'_img_avant';
                $img_id_apres='img_'.$row["id_img"].'_img_apres';
                echo '
                <script>
                    document.getElementById("'.$form_id.'").remove();
                    document.getElementById("'.$img_id_avant.'").remove();
                    document.getElementById("'.$img_id_apres.'").remove();
                </script>
                ';
                
            }
        }
    }

    function show_rm_img_buttons($db,$client_id,$id_rdv){
        
        $result= $db->query('SELECT * FROM `images` WHERE id_client="'.$client_id.'" AND id_rdv="'.$id_rdv.'"');
        foreach($result as $row){
            $rm_row_id='row_id_'.$client_id.'_'.$id_rdv.'_'.$row['id_img'];
            echo 'document.getElementById("'.$rm_row_id.'").style="display:true";';
        }

    }
    function hide_rm_img_buttons($db,$client_id,$id_rdv){
        
        $result= $db->query('SELECT * FROM `images` WHERE id_client="'.$client_id.'" AND id_rdv="'.$id_rdv.'"');
        foreach($result as $row){
            $rm_row_id='row_id_'.$client_id.'_'.$id_rdv.'_'.$row['id_img'];
            echo 'document.getElementById("'.$rm_row_id.'").style="display:none";';
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

    function change_date($db,$client_id,$id_rdv,$new_date){
        $sql='UPDATE rendezvous
              SET  date_rdv="'.$new_date.'" WHERE id_client='.$client_id.' 
              AND id_rdv='.$id_rdv.';';
        $db->query($sql);
    }
    function change_procedure($db,$client_id,$id_rdv,$new_nom_procedure){
        $sql='UPDATE rendezvous
              SET  nom_procedure="'.$new_nom_procedure.'" WHERE id_client='.$client_id.' 
              AND id_rdv='.$id_rdv.';';
        $db->query($sql);
    }
    function change_info_rdv($db,$client_id,$id_rdv,$new_info){
        $sql='UPDATE rendezvous
        SET  infos_rdv="'.$new_info.'" WHERE id_client='.$client_id.' 
        AND id_rdv='.$id_rdv.';';
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
    <div class="container" id="main_center" >
        <?php
            $infos_to_send="location.href='info_client_page.php?client_id=".$client_id."'";
            echo "<input type='button' onClick=".$infos_to_send." value='Retour info du client'>";
        ?>
        <!--CLIENT BOUTON ADD REMOVE AND MOD -->
        <div id= "bouton_clients" >
        <button onclick="modify_content()">Modifier</button>
        </div>    
        <!--CLIENT BOUTON ADD REMOVE AND MOD END-->
        <!--Infos of the rdv-->
        <div id= "infos_rdv" style="margin-top:2%;">
            <table style="width:100%">
                <tr>
                    <td>
                        <?php 
                            echo '<strong>Procédure effectuée: </strong><br><p id="actual_procedure">'.$nom_procedure.'</p>';
                        ?>
                        <form style="display:true;" method="POST" enctype="multipart/form-data">
                            
                            <!-- button to display the alter procedure input -->
                            <button type="submit" name='change_procedure_name' id="change_procedure_name_button_id" style="display:none;">
                                Changer le nom de la procédure 
                            </button>

                            <!-- button to change the procedure  -->
                            <div id="procedure_input" style="display:none;">
                                <input id="procedure_input_sub" name="procedure_input_submit" type="text" onkeyup="Expand(this);" >
                                <input type="submit" name="procedure_submit">
                            </div>
                        </form>
                    </td>

                </tr>
                <tr>
                    <td>
                        <?php 
                            echo '<strong>Date du rdv:</strong><br>
                            <p id="actual_date">'.$date_rdv.'</p>';
                        ?>
                        <form style="display:true;" method="POST" enctype="multipart/form-data">
                            <!-- button to display the alter date input -->
                            <button type="submit" name='change_date' id="change_date_button_id" style="display:none;">
                                Changer la Date 
                            </button>
                            <!-- button to change the date  -->
                            <div id="date_input" style="display:none;">
                                <input type="date" name="date_input_submit">
                                <input type="submit" name="date_submit">
                            </div>
                            
                        </form>     
                    </td>
                </tr>

                <tr>
                    <td>
                        <?php 
                            echo '<strong>infos:</strong>'; 
                            echo ' <strong id="warning_br" style="display:none;color:red;">(IMPORTANT: Pour faire un retour à la ligne écrire en fin de ligne  '.htmlentities("<br>").' exemple: hello '.htmlentities("<br>").' world)</strong>'; 
                            echo '<br>';
                        ?>
                        <form style="display:true;" method="POST" enctype="multipart/form-data">
                        <?php
                            echo "<div id='info_rdv_content'>
                                    <p>".$infos_rdv."</p>
                                </div>";
                        ?>
                            <!-- button to display the alter info_rdv input -->
                            <button type="submit" name='change_info_rdv' id="change_info_rdv_button_id" style="display:none;">
                                Changer les Informations du Rendezvous
                            </button>

                            <!-- button to change the info_rdv  -->
                            <div id="info_rdv_input" style="display:none;">
                                <input type="submit" name="info_rdv_submit">
                            </div>
                        </form>
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
                    get_img($db,$client_id,$id_rdv,"img_avant",$url);
                    ?>
                    </div>
                    
                </td>
                <td >
                    <strong>Image Après:</strong><br>
                    <div id="imgs_apres_function">
                    <?php
                    get_img($db,$client_id,$id_rdv,"img_apres",$url);
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
                
                <button id="button_rm_row" onclick="show_row_rm_buttons()">
                    ENLEVER UNE IMAGE AVANT ET APRES
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


    
    
    </div>
    <!--END CENTER-->



<!--FOOTER-->
<footer id="main_footer">
</footer>
<!--END_FOOTER-->

<script>
//add empty row to database
<?php
    if(isset($_POST['add_empty'])){
        echo 'document.getElementById("button_add_rm").style="display:none";';
        add_empty_row_to_db($db,$client_id,$id_rdv);
        echo "location.replace('".$url."')";
    }
    #change the date
    if(isset($_POST['change_date'])){
        echo 'document.getElementById("date_input").style="display:true";';
        #echo 'hide_change_date_button();';
    }

    if(isset($_POST['date_submit'])){
        $new_date=$_POST['date_input_submit'];
        $new_date=date("Y-m-d",strtotime($new_date));
        echo 'document.getElementById("actual_date").innerHTML="'.$new_date.'";';
        change_date($db,$client_id,$id_rdv,$new_date);
    }
    #change procedure name
    if(isset($_POST['change_procedure_name'])){
        echo 'document.getElementById("procedure_input").style="display:true";';
        echo 'document.getElementById("change_procedure_name_button_id").style="display:none";';        
        echo 'document.getElementById("procedure_input_sub").value="'.$nom_procedure.'";';
    }

    if(isset($_POST['procedure_submit'])){
        #get the name new name of the procedure.
        $new_procedure_name=$_POST['procedure_input_submit'];
        #add the new name procedure to the html
        echo 'document.getElementById("actual_procedure").innerHTML="'.$new_procedure_name.'";';
        #change the name of the procedure to the database
        change_procedure($db,$client_id,$id_rdv,$new_procedure_name);
    }

    # change the infos of the rdv:
    if(isset($_POST['change_info_rdv'])){
        echo 'document.getElementById("info_rdv_input").style ="display:true;";
        ';
        echo "set_text_area();";
        echo 'hide_change_info_rdv_button();';
    }

    if(isset($_POST['info_rdv_submit'])){
      
        #get the content of the textarea

        $new_info= htmlspecialchars( $_POST['my_text_id']);
        #hide warning sign
        echo 'document.getElementById("warning_br").style="display:none;";
        ';
        #add the new name procedure to the html
        echo 'document.getElementById("info_rdv_content").innerHTML = "<p>'.$new_info.'</p>";';

        #change the name of the procedure to the database
        change_info_rdv($db,$client_id,$id_rdv,$new_info);

    }
?>

function set_text_area(){
    document.getElementById("warning_br").style="display:true;color:red;";

    document.getElementById("info_rdv_content").innerHTML = '<br><textarea rows=9 name="my_text_id" wrap="hard"><?php echo $infos_rdv?></textarea></br>';

    var txt=document.getElementById('info_rdv_content').getElementsByTagName('textarea')[0].value;

    
}

//expand the size of the input text 
function Expand(obj){
      if (!obj.savesize) obj.savesize=obj.size;
      obj.size=Math.max(obj.savesize,obj.value.length);
}

function hide_change_info_rdv_button(){
    document.getElementById("change_info_rdv_button_id").style ="display:none;";
}
function show_change_info_rdv_button(){
    document.getElementById("change_info_rdv_button_id").style="display:true";

}

function hide_change_name_procedure_button(){
    document.getElementById("change_procedure_name_button_id").style="display:none";
}

function show_change_name_procedure_button(){
    document.getElementById("change_procedure_name_button_id").style="display:true";
}

//hide change_date_button
function hide_change_date_button(){
    document.getElementById("change_date_button_id").style="display:none";
}

//show change_date_button
function show_change_date_button(){
    document.getElementById("change_date_button_id").style="display:true";
}
//remove a row from db
function show_row_rm_buttons(){
    document.getElementById("button_add_rm").style="display:none";
    <?php
        show_rm_img_buttons($db,$client_id,$id_rdv);
    ?>
    modify_content();
}

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
    show_change_date_button();
    show_change_name_procedure_button();
    show_change_info_rdv_button();

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
    hide_change_date_button();
    hide_change_name_procedure_button();
    hide_change_info_rdv_button();

    alert("contenu sauvegardé");

}

//FUNCTION TO MAKE THE TEXTAREA ADAPT TO CONTENT
var autoExpand = function (field) {
    // Reset field height
    field.style.height = 'inherit';
    // Get the computed styles for the element
    var computed = window.getComputedStyle(field);
    // Calculate the height
    var height = field.scrollHeight;
    field.style.height = height + 'px';
};
//EVENT LISTENER FOR THE TEXTAREA MODIFICATION
document.addEventListener('input', function (event) {
if (event.target.tagName.toLowerCase() !== 'textarea') return;
autoExpand(event.target);
}, false);

</script>

</body>
</html>