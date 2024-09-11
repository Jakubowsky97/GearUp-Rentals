<?php
include_once "dbh.php"; // Załącz plik z połączeniem do bazy danych
include_once "functionsinc.php"; // Załącz plik z funkcjami

session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['userid'])) {
    header("Location: ../Web/login.php");
    exit();
}


    $rozgrywkaId = $_POST['rozgrywka_id'];



    // Pobierz nazwę pliku zdjęcia dla rozgrywki
    $rozgrywkaImages = getZdjecieRozgrywki($conn, $rozgrywkaId);

    // Usuń zdjęcia związane z rozgrywką, jeśli istnieją
    if (!empty($rozgrywkaImages)) {
        header("Location: ../Web/rozgrywki.php?delete=success&kategoria=wszystko");
       
        foreach ($rozgrywkaImages as $image) {
            if($image['nazwa_pliku'] == 'default.jpg') {

            } else {
            $picturePath = "../Images/Rozgrywki/" . $image['nazwa_pliku'];
            if (file_exists($picturePath)) {
                unlink($picturePath);
            }
        }
    }
}
    deleteUczestnictwoAutor($conn, $rozgrywkaId);
    // Usuń rozgrywkę
    deleteRozgrywka($conn, $rozgrywkaId);
    // Przekieruj użytkownika z powrotem na stronę rozgrywki
    header("Location: ../Web/rozgrywki.php?delete=success&kategoria=wszystko");
    exit();
?>
