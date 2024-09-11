<?php
// Połączenie z bazą danych
require_once("dbh.php");
require_once("functionsinc.php");

session_start();
// Pobranie danych z formularza
$nazwa = $_POST['nazwa'];
$kategoria = $_POST['kategorie'];
$data = $_POST['date'];
$formattedDatetime = date("Y-m-d H:i:s", strtotime($data));
$liczbaOsob = $_POST['osoby'];
$opis = $_POST['opis'];
$lokalizacja = $_POST['lokalizacja'];
$telefon = $_POST['numer']; // Poprawione pobieranie numeru telefonu
$userId = $_SESSION['userid'];
$userInfo = getUserInfo($conn, $_SESSION['userid']);
// Numeracja plików
$counter = 1;
$targetDir = "../Images/Rozgrywki/";
$uploadedFiles = [];

// Sprawdzenie, czy jakieś zdjęcia zostały przesłane
if (!empty($_FILES['images']['name'][0])) { 

foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
    if ($counter > 4) {
        break; // Ograniczenie do maksymalnie 4 zdjęć
    }

    $fileName = basename($_FILES['images']['name'][$key]);
    // Nowa nazwa pliku zgodna z wymaganiami - nazwa_oferty_numer_pliku_rozszerzenie
    $newFileName = str_replace(' ', '_', $nazwa) . "_" . $counter . "." . pathinfo($fileName, PATHINFO_EXTENSION);
    $targetFilePath = $targetDir . $newFileName;

    if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetFilePath)) {
        $uploadedFiles[] = $newFileName; // Zapisz nową nazwę pliku
        $counter++;
    }
}


    // Zapisanie informacji o ofercie w bazie danych
    // Tutaj dodaj kod zapisujący dane rozgrywki w odpowiedniej tabeli
    createRozgrywka($conn, $nazwa, $kategoria, $formattedDatetime, $liczbaOsob, $opis, $lokalizacja, $telefon, $userId);
    // Pobranie id ostatnio dodanej rozgrywki
    $lastRozgrywkaId = getLastRozgrywkaId($conn);

    // Zaktualizowanie ofertyId dla każdego pliku w tabeli zdjecia
    foreach ($uploadedFiles as $fileName) {
        $sql = "INSERT INTO zdjecia (nazwa_pliku, rozgrywkiId, typ) VALUES ('$fileName', '$lastRozgrywkaId', 'rozgrywka')";
        if (mysqli_query($conn, $sql)) {
            echo "Plik $fileName został dodany do bazy danych.<br>";
        } else {
            echo "Wystąpił błąd podczas dodawania pliku $fileName do bazy danych: " . mysqli_error($conn) . "<br>";
        }
    }
} else {
    createRozgrywka($conn, $nazwa, $kategoria, $formattedDatetime, $liczbaOsob, $opis, $lokalizacja, $telefon, $userId);
    $lastRozgrywkaId = getLastRozgrywkaId($conn);
    $sql = "INSERT INTO zdjecia (nazwa_pliku, rozgrywkiId, typ) VALUES ('default.jpg', '$lastRozgrywkaId', 'rozgrywka')";
    if (mysqli_query($conn, $sql)) {
        echo "Domyślne zdjęcie zostało dodane do bazy danych.<br>";
    } else {
        echo "Wystąpił błąd podczas dodawania domyślnego zdjęcia do bazy danych: " . mysqli_error($conn) . "<br>";
    }
}

// Przekierowanie użytkownika z powrotem na stronę główną lub inną stronę po zakończeniu procesu
header("Location: rozgrywka.php?id=$lastRozgrywkaId");
exit();
?>
