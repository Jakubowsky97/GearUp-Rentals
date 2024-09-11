<?php 
    error_reporting(E_ERROR | E_PARSE); // Wyłącza wyświetlanie ostrzeżeń i notatek
    session_start();
    $isUserLoggedIn = isset($_SESSION["userid"]);

    if(!$isUserLoggedIn) {
         header("Location: login.php");
    }
        

    // Połączenie z bazą danych
    require_once("dbh.php");
    require_once("functionsinc.php");

    session_start();
    $userId = $_SESSION['userid'];
    $offerId = $_GET['ofertaId'];
    $rozp = $_POST['dataPocz'];
    $zakoncz = $_POST['dataKonc'];
    $rozpCena = strtotime($rozp);
    $zakonczCena = strtotime($zakoncz);
    
    $oferta = getOffer($conn, $offerId);
    $cenaPods = $oferta['cena']/7;
    $zakresDaty = ($zakonczCena - $rozpCena)/60/60/24;
    $cena = ($cenaPods * $zakresDaty);
    $cenaRound = round($cena, 2);

    requestOfRental($conn, $userId, $offerId, $rozp, $zakoncz, $cenaRound);

    header("Location: rezerwacja.php");
exit();
?>