<?php
session_start();
require('headers.php');
require('functions.php');


//Tarkistetaan tuleeko palvelimelle basic login tiedot (Authorization: Basic asfkjsafdjsajflkasj)
if( isset($_SERVER['PHP_AUTH_USER']) ){
    if(checkUser(createDbConnection(), $_SERVER['PHP_AUTH_USER'],$_SERVER["PHP_AUTH_PW"] )){
        $_SESSION["user"] = $_SERVER['PHP_AUTH_USER'];
  
        echo '{"info":"TERE TULEMAST"}';
        header('Content-Type: application/json');
        exit;
    }
}

//Ilmoitetaan käyttäjälle, että kirjaudupa sisään (avaa selaimessa login ikkunan)

// header('WWW-Authenticate: Basic');
echo '{"info":"Failed to login"}';
header('Content-Type: application/json');
header('HTTP/1.1 401');
exit;
 
if ( checkUser(createDbConnection(), "lyhyt", "toimiiko") ){
    echo "oikea salasana";
}else{
    echo "väärä salasana";
}
?>