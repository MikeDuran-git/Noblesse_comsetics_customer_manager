<?php

    $username= 'root';
    $password= '';
    $host='localhost';
    $db_name='noblesse_cosmetics_clients';

    try{
        $db=new mysqli($host,$username,$password,$db_name);
        echo 'conexxion success';
    }
    catch(Exception $e){
        print $e->getMessage();
    }
?>