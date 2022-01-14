<?php

/**
 * Luo ja palauttaa tietokantayhteyden.
 */
function createDbConnection(){

    try{
        $dbcon = new PDO('mysql:host=localhost;dbname=imdb', 'root', '');
        $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        echo $e->getMessage();
    }

    return $dbcon;
}