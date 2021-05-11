<?php

    $username= 'root';
    $password= '';
    $host='localhost';
    $db_name='noblesse_cosmetics_clients';

    try{
        $db=new PDO("mysql:host=$host;dbname=$db_name",$username,$password);
    }
    catch(Exception $e){
        print $e->getMessage();
        echo 'connexion failed';
    }


?>