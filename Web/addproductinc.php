<?php
// Połączenie z bazą danych
require_once("dbh.php");
require_once("functionsinc.php");

session_start();
// Pobranie danych z formularza
$nazwa = $_POST['nazwa'];
$kategoria = $_POST['kategorie'];
$opis = $_POST['opis'];
$lokalizacja = $_POST['lokalizacja'];
$telefon = $_POST['numer']; // Poprawione pobieranie numeru telefonu
$cena = $_POST['cena'];
$userId = $_SESSION['userid'];
$userInfo = getUserInfo($conn, $_SESSION['userid']);
// Numeracja plików
$counter = 1;
$targetDir = "../Images/oferty/";
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
    // Tutaj dodaj kod zapisujący dane oferty w odpowiedniej tabeli
    createOffer($conn, $nazwa, $kategoria, $opis, $lokalizacja, $telefon, $cena, $userId);
    // Pobranie id ostatnio dodanej oferty
    $lastOfferId = getLastOfferId($conn);

    // Zaktualizowanie ofertyId dla każdego pliku w tabeli zdjecia
    foreach ($uploadedFiles as $fileName) {
        $sql = "INSERT INTO zdjecia (nazwa_pliku, ofertyId, typ) VALUES ('$fileName', '$lastOfferId', 'oferta')";
        if (mysqli_query($conn, $sql)) {
            echo "Plik $fileName został dodany do bazy danych.<br>";
        } else {
            echo "Wystąpił błąd podczas dodawania pliku $fileName do bazy danych: " . mysqli_error($conn) . "<br>";
        }
    }
} else {
    // Jeżeli nie zostały przesłane żadne zdjęcia, wstawiaj dane do bazy danych z domyślną nazwą pliku
    createOffer($conn, $nazwa, $kategoria, $opis, $lokalizacja, $telefon, $cena, $userId);
    $lastOfferId = getLastOfferId($conn);
    $sql = "INSERT INTO zdjecia (nazwa_pliku, ofertyId, typ) VALUES ('default.jpg', '$lastOfferId', 'oferta')";
    if (mysqli_query($conn, $sql)) {
        echo "Domyślne zdjęcie zostało dodane do bazy danych.<br>";
    } else {
        echo "Wystąpił błąd podczas dodawania domyślnego zdjęcia do bazy danych: " . mysqli_error($conn) . "<br>";
    }
}

// Przekierowanie użytkownika z powrotem na stronę główną lub inną stronę po zakończeniu procesu
header("Location: product.php?id=$lastOfferId");
exit();
?>
