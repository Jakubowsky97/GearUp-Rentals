<?php 
include_once "dbh.php"; // Załącz plik z połączeniem do bazy danych
include_once "functionsinc.php"; // Załącz plik z funkcjami

session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['userid'])) {
    header("Location: ../Web/login.php");
    exit();
}

$userId = $_SESSION['userid'];
$rozgrywkaId = $_GET['rozgrywkaId'];

deleteUczestnictwo($conn, $rozgrywkaId, $userId);

header("Location: ../Web/rozgrywka.php?id=".$rozgrywkaId);
exit();
?>