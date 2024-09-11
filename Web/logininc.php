<?php

if(isset($_POST["submit"])) {

    // zboera dane z formularza logowania
    $username = $_POST["login"];
    $pwd = $_POST["password"];

    // uwzględnia do działania tego procesu plik łączenia bazy danych oraz plik wszystkich funkcji
    require_once 'dbh.php';
    require_once 'functionsinc.php';

    // użycie funkcji loginUser
    loginUser($conn, $username, $pwd);
    
} else {
    // Przejście do login.php jeżeli formularz nie został przetworzony prawidłowo
    header("Location: ../Web/login.php");
    exit();
}

?>