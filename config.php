<?php
    function connection_data($username_s){
        $servername = "localhost";
        $db_name = "sklep";
        $password = "";
        $username = $username_s;

        $connection_data = array();
        array_push($connection_data, $servername, $username, $password, $db_name);

        return $connection_data;
    }
?>