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
            echo '<img id='.$row["id_img"].' src='.$img_url.' width="300" height="400">';
            
            //input to change image
            $upload_id="upload_id_".$row["id_img"].'_'.$avant_apres_bool;
            $submit_id="submit_".$row["id_img"]."_".$avant_apres_bool;
            $form_id='form_'.$row["id_img"].'_'.$avant_apres_bool; 
            
            
            echo '
            <form id='.$form_id.' style="display:none;" method="POST" enctype="multipart/form-data">
                <input type="file" name='.$upload_id.' accept="imgs/*">
                <button type="submit" name='.$submit_id.'>ENVOYER</button>
            </form>
            ';

            //the case we switch images.
            if(isset($_POST[$submit_id])){
                $filename=$_FILES[$upload_id]['name'];

                if($avant_apres_bool=='img_avant')
                    $result= $db->query('UPDATE images 
                                SET img_avant="imgs_'.$filename.'" WHERE id_img='.$row['id_img'].' ');
                else
                    $result= $db->query('UPDATE images SET img_apres="imgs_'.$filename.'" WHERE id_img='.$row['id_img'].';');

                    header("Refresh:0");

            }
        }
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
                    <td><?php echo '<strong>Procédure effectuée: </strong><br>'.$nom_procedure.'';?></td>
                    <td><?php echo '<strong>Date du rdv:</strong><br>'.$date_rdv.'';?></td>
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
                    <td>
                        <?php echo '<strong>Image Avant:</strong><br>';


                            get_img($db,$client_id,$id_rdv,'img_avant');
                        
                        ?>

                    </td>
                    <td>
                        <?php 
                            echo '<strong>Image Après:</strong><br>'; 
                        
                            get_img($db,$client_id,$id_rdv,'img_apres');
                        ?>
                    </td>
                </tr>
            </table>

            <div id="button_add_rm" style="display: none">
                <button>AJOUTER UNE IMAGE AVANT</button>
                <button>AJOUTER UNE IMAGE APRES</button>
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



<script>

function modify_content(){
    
    document.getElementById("button_add_rm").style="display:true;";
    document.getElementById("bouton_clients").innerHTML='<button onclick="save_content()" >Sauvegarder</button>';
    <?php
       $counter= $db->prepare("SELECT COUNT(*) as c from images where id_client=".$client_id." AND id_rdv=".$id_rdv.";");
       $counter->execute();
       $counter = $counter->fetch();
       $counter=$counter['c'];
       while($counter > 0){
            echo 'document.getElementById("form_'.$counter.'_img_avant").style="display:true";';
            echo 'document.getElementById("form_'.$counter.'_img_apres").style="display:true";';

            $counter-=1;
       }
    ?>
}


function save_content(){
    document.getElementById("button_add_rm").style="display:none;";
    document.getElementById("bouton_clients").innerHTML='<button onclick="modify_content()">Modifier</button>';
    <?php
       $counter= $db->prepare("SELECT COUNT(*) as c from images where id_client=".$client_id." AND id_rdv=".$id_rdv.";");
       $counter->execute();
       $counter = $counter->fetch();
       $counter=$counter['c'];
       while($counter > 0){
            echo 'document.getElementById("form_'.$counter.'_img_avant").style="display:none";';
            echo 'document.getElementById("form_'.$counter.'_img_apres").style="display:none";';

            $counter-=1;
       }
    ?>

}

</script>

</body>
</html>