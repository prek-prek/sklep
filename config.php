<?php
    function connection_data($username_s){
        $servername = "mysql.ct8.pl";
        $db_name = "m32187_sklep";
        $password = "Prek1337";
        $username = $username_s;

        $connection_data = array();
        array_push($connection_data, $servername, $username, $password, $db_name);

        return $connection_data;
    }
?>
