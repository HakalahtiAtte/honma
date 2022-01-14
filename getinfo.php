<?php
session_start();
require ('functions.php');
require ('headers.php');

$html = "";

if(isset($_SESSION["user"])){
        //käyttää luotua database yhteyttä
        //$info = $_GET['info'];
        $conn = createDbConnection();
        //haku jonka koodi hakee mysql
        $sql = "SELECT * FROM info
        WHERE username LIKE '%" . $_SESSION["user"] . "%'";
        // Tarkistukset yms
        // Aja kysely kantaan
        $prepare = $conn->prepare($sql);
        $prepare->execute();
        $rows = $prepare->fetchAll();
        //tulostus

        $html .= '<ul>';

        foreach($rows as $row) {

            $html .= '<li>' . $row['username'] . '</li>';
            $html .= '<li>' . $row['email'] . '</li>';
            $html .= '<li>' . $row['phone'] . '</li>';
        }
        $html .= '</ul>';
        echo $html;
    exit;
}
echo "Log In";
?>