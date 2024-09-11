<?php
include_once "dbh.php"; // Załącz plik z połączeniem do bazy danych
include_once "functionsinc.php"; // Załącz plik z funkcjami

session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION["userid"])) {
    header("Location: ../Web/login.php");
    exit();
}

// Sprawdź, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobierz dane z formularza
    $userId = $_SESSION["userid"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phoneNumber = $_POST["phoneNumber"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $postalCode = $_POST["postalCode"];
    $description = $_POST["description"];

    // Wywołaj funkcję do aktualizacji profilu użytkownika
    updateUserProfile($conn, $userId, $firstName, $lastName, $phoneNumber, $city, $country, $postalCode, $description);
} else {
    // Jeśli formularz nie został wysłany, przekieruj użytkownika na stronę profilu
    header("Location: ../Web/profile.php?error=access_denied");
    exit();
}
?>
