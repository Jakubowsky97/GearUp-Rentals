<?php
include_once "dbh.php"; // Załącz plik z połączeniem do bazy danych
include_once "functionsinc.php"; // Załącz plik z funkcjami

session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['userid'])) {
    header("Location: ../Web/login.php");
    exit();
}


    $offerId = $_POST['offer_id'];



        // Pobierz nazwę pliku zdjęcia dla oferty
    $offerImages = getZdjecieOferty($conn, $offerId);

    // Usuń zdjęcia związane z ofertą, jeśli istnieją
    if (!empty($offerImages)) {
        header("Location: ../Web/oferty.php?kategoria=wszystko");
       
        foreach ($offerImages as $image) {
            if($image['nazwa_pliku'] == 'default.jpg') {

            } else {
                $picturePath = "../Images/Oferty/" . $image['nazwa_pliku'];
            if (file_exists($picturePath)) {
                unlink($picturePath);
            }
            }
            
        }
    }

    // Usuń ofertę
    deleteOffer($conn, $offerId);
    // Przekieruj użytkownika z powrotem na stronę ofert
    header("Location: ../Web/oferty.php?kategoria=wszystko");
    exit();
?>
