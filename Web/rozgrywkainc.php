<?php 
   session_start();
        $isUserLoggedIn = isset($_SESSION["userid"]);

        if(!$isUserLoggedIn) {
            header("Location: login.php");
        }
    // Połączenie z bazą danych
    require_once("dbh.php");
    require_once("functionsinc.php");


    $rozgrywkaId = $_GET['rozgrywkaId'];
    $userId = $_SESSION['userid'];

    addUczestnictwo($conn, $rozgrywkaId, $userId);
    header("Location: rezerwacja.php?kategoria=rozgrywka");
    exit();
?>