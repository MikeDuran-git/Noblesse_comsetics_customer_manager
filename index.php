<!DOCTYPE html>
<html>
<title>Noblesse Cosmetics Client Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="index.css">

</head>
<body style="background-color: burlywood;">


<!--DATABASE CONNECTION-->
    <?php
    include 'connexion.php';
    ?>
<!--DATABASE CONNECTION END-->


    <!--HEADER-->
    <header id="main_header">
        <h1>Liste des Clients</h1>
    </header>
    <!--END_HEADER-->


    <!--CENTER-->
    <div class="container" id="main_center">
        
        <!--Searchbar-->
        <div>  
            <form name="form" method="post">
            
                <button id="add_client_button">Ajouter un Client</button>
                <button id="rm_client_button">Enlever un Client</button>
                
                <input id="search_bar" name="search" type="text" placeholder="Search..">
                <input type="submit" name="submit">
            
            </form>

        </div>
        <!--END Searchbar-->
        
        
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
                            $result= $db->prepare("SELECT * FROM `clients` WHERE nom='$client_name' or prenom='$client_name'");

                        }

                        $result->setFetchMode(PDO:: FETCH_OBJ);
                        $result->execute();
                        

                        while($row = $result->fetch()){
                            echo '            
                            <tr>
                            <td>
                                <button class="container">Select</button>
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
                        }
                    }
                else{
                    $result= $db->prepare("SELECT * FROM `clients`");
                    $result->setFetchMode(PDO:: FETCH_OBJ);
                    $result->execute();
                    while($row = $result->fetch()){
                        echo '            
                        <tr>
                        <td>
                            <button class="container">Select</button>
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
                    }
                }
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





</body>
</html>