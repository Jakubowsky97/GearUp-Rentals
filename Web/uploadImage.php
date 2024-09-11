<?php
include_once "dbh.php"; // Załącz plik z połączeniem do bazy danych
include_once "functionsinc.php"; // Załącz plik z funkcjami

session_start();
$target_dir = "../Images/Profile/";
$file_name = basename($_FILES["fileToUpload"]["name"]);
$normalized_file_name = strtolower(str_replace(' ', '_', $file_name));
$userId = $_SESSION['userid'];
$target_file = $target_dir . str_replace(' ', '_', $normalized_file_name);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Pobierz informacje o użytkowniku z funkcji getUserInfo
$userInfo = getUserInfo($conn, $userId);

$uploadOk = 1;


// Sprawdź, czy plik obrazu jest rzeczywistym obrazem lub fałszywym obrazem
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Plik jest obrazem - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Plik nie jest obrazem.";
        $uploadOk = 0;
    }
}

// Sprawdź, czy plik już istnieje
if (file_exists($target_file)) {
    unlink($target_file);
}

// Sprawdź rozmiar pliku
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Przepraszamy, plik jest zbyt duży.";
    $uploadOk = 0;
}

// Dozwolone rozszerzenia plików
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Przepraszamy, tylko pliki JPG, JPEG, PNG są dozwolone.";
    $uploadOk = 0;
}

// Jeśli wszystko jest w porządku, spróbuj przesłać plik
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Plik ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " został przesłany.";

        // Aktualizacja nazwy pliku w bazie danych
        $sql = "UPDATE uzytkownicy SET profile_pic=? WHERE id=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../Web/profile.php?error=stmt_error");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "si", $target_file, $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: ../Web/profile.php?id=$userId#success=profilePic_updated");
        exit();
    } else {
        echo "Wystąpił błąd podczas przesyłania pliku.";
    }
    } else {
    echo "Przepraszamy, plik nie został przesłany.";
} 

?>
