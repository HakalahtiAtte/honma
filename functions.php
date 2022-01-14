<?php

/**
 * Tarkistaa onko käyttäjä tietokannassa ja onko salasana validi
 */
function checkUser(PDO $dbcon, $username, $password){

    //Sanitoidaan. Lisätty tuntien jälkeen
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    try{
        $sql = "SELECT password FROM users WHERE username=?";  //komento, arvot parametreina
        $prepare = $dbcon->prepare($sql);   //valmistellaan
        $prepare->execute(array($username));  //kysely tietokantaan

        $rows = $prepare->fetchAll(); //haetaan tulokset (voitaisiin hakea myös eka rivi fetch ja tarkistus)

        //Käydään rivit läpi (max yksi rivi tässä tapauksessa) 
        foreach($rows as $row){
            $pw = $row["password"];  //password sarakkeen tieto (hash salasana tietokannassa)
            if( password_verify($password, $pw) ){  //tarkistetaan salasana tietokannan hashia vasten
                return true;
            }
        }

        //Jos ei löytynyt vastaavuutta tietokannasta, palautetaan false
        return false;

    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }
}

/**
 * Luo tietokantaan uuden käyttäjän ja hashaa salasanan
 */
function createUser(PDO $dbcon, $firstname, $lastname, $username, $password){

    //Sanitoidaan. Lisätty tuntien jälkeen.
    $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
    $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    try{
        $hash_pw = password_hash($password, PASSWORD_DEFAULT); //salasanan hash
        $sql = "INSERT IGNORE INTO users VALUES (?,?,?,?)"; //komento, arvot parametreina
        $prepare = $dbcon->prepare($sql); //valmistellaan
        $prepare->execute(array($firstname, $lastname, $username, $hash_pw));  //parametrit tietokantaan
    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }
}

/**
 * Luo ja palauttaa tietokantayhteyden.
 */
function createDbConnection(){

    try{
        $dbcon = new PDO('mysql:host=localhost;dbname=n7haat00', 'root', '');
        $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }

    return $dbcon;
}

function createTable(PDO $con){

    $sql = "CREATE TABLE IF NOT EXISTS users (
        firstname varchar(50) NOT NULL,
        lastname varchar(50) NOT NULL,
        username varchar(50) NOT NULL,
        password varchar(250) NOT NULL,
        PRIMARY KEY (username)
        );

       CREATE TABLE IF NOT EXISTS info(
       username varchar(50) NOT NULL,
       email varchar(100),
       phone varchar(20),
       FOREIGN KEY (username) REFERENCES users(username)
        );";

    try{   
        $con->exec($sql);  
    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }

    //Luodaan pari käyttäjää tietokantaan
    //createUser(createDbConnection(), "firstname", "lastname", "username", "password");
    //createUser(createDbConnection(), "firstname1", "lastname2", "username3", "password");
    //createUser(createDbConnection(), "atte", "hakalahti", "n7haat00", "salasana");
    
    
}

function createInfo(PDO $dbcon, $username, $email, $phone){

    //Sanitoidaan. Lisätty tuntien jälkeen.
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $phone = filter_var($phone, FILTER_SANITIZE_STRING);
    

    try{
        $sql = "INSERT IGNORE INTO info VALUES (?,?,?)"; //komento, arvot parametreina
        $prepare = $dbcon->prepare($sql); //valmistellaan
        $prepare->execute(array($username, $email, $phone));  //parametrit tietokantaan
    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }
}

?>