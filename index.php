<!DOCTYPE html>
<html>
<title>Noblesse Cosmetics Client Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="./index.css">

</head>
<body style="background-color: burlywood;">

<!--HEADER-->
<header id="main_header">
    <h1>Liste des Clients</h1>
</header>
<!--END_HEADER-->


<!--CENTER-->
<div class="container" id="main_center">
    
    <!--Searchbar-->
    <div class="container">  
        <input type="text" placeholder="Search..">
        <button>BUTTON</button>
    </div>
    <!--END Searchbar-->

    
    <!--DB_content-->
    <div class="container" id="DB_content">
        <table>
            <tr>
                <th>Bouton selection</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
            </tr>

            <tr>
                <td>
                    <button class="container">Select</button>
                </td>
                <td>Maria </td>
                <td>Anders</td>
                <td>mike.duran@hotmail.de</td>
            </tr>
            
        </table>
    </div>
    <!--END DB_content-->
    
    <div class="container">
        <button>Ajouter un Client</button>
        <button>Enlever un Client</button>
    </div>

</div>
<!--END CENTER-->



<!--FOOTER-->
<footer id="main_footer">
    <p>footer</p>
</footer>
<!--END_FOOTER-->

</body>
</html>