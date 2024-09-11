<?php 

/**
 * Sprawdza, czy podane nazwa użytkownika jest prawidłowa.
 *
 * @param string $username Nazwa użytkownika do sprawdzenia.
 * @return bool Zwraca true, jeśli nazwa użytkownika jest nieprawidłowa, w przeciwnym razie false.
 */
function invalidUid($username){
    $result = false;
    if(!preg_match("/^[a-zA-Z0-9.-_]*$/", $username)) {
        $result = true;
    }
    return $result;
}

/**
 * Sprawdza, czy podany adres e-mail jest prawidłowy.
 *
 * @param string $email Adres e-mail do sprawdzenia.
 * @return bool Zwraca true, jeśli adres e-mail jest nieprawidłowy, w przeciwnym razie false.
 */
function invalidEmail($email){
    $result = false;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
};

/**
 * Sprawdza, czy użytkownik o podanej nazwie użytkownika lub adresie e-mail istnieje w bazie danych.
 *
 * @param mysqli $conn Połączenie z bazą danych.
 * @param string $username Nazwa użytkownika do sprawdzenia.
 * @param string $email Adres e-mail do sprawdzenia.
 * @return array|false Zwraca tablicę asocjacyjną z danymi użytkownika, jeśli istnieje, w przeciwnym razie false.
 */
function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM uzytkownicy WHERE nazwa_uzytkownika = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Web/register.php?error=stmt_error");  
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        mysqli_stmt_close($stmt);
        return $row; // Zwraca tablicę asocjacyjną z danymi użytkownika
    }

    return false; // Zwraca false, jeśli nie znaleziono rekordu
}

/**
 * Tworzy nowego użytkownika w bazie danych.
 *
 * @param mysqli $conn Połączenie z bazą danych.
 * @param string $email Adres e-mail nowego użytkownika.
 * @param string $username Nazwa użytkownika nowego użytkownika.
 * @param string $pwd Hasło nowego użytkownika.
 * @param string $picture Obraz profilowy nowego użytkownika.
 * @param string $gender Płeć nowego użytkownika.
 * @return void
 */
function createUser($conn, $email, $username, $pwd, $picture, $gender, $city, $country, $postalCode){
    // Wstaw nowy adres do tabeli adresy
    $sql_insert_address = "INSERT INTO adresy (miasto, kraj, kod_pocztowy) VALUES (?, ?, ?)";
    $stmt_insert_address = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt_insert_address, $sql_insert_address)) {
        header("Location: ../Web/register.php?error=stmt_error");  
        exit();
    }
    mysqli_stmt_bind_param($stmt_insert_address, "sss", $city, $country, $postalCode);
    mysqli_stmt_execute($stmt_insert_address);
    $addressId = mysqli_insert_id($conn); // Pobierz automatycznie nadane id adresu
    mysqli_stmt_close($stmt_insert_address);   

    // Wstaw nowego użytkownika do tabeli uzytkownicy
    $sql_insert_user = "INSERT INTO uzytkownicy (nazwa_uzytkownika, email, haslo, profile_pic, plec, addressId) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert_user = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt_insert_user, $sql_insert_user)) {
        header("Location: ../Web/register.php?error=stmt_error");  
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt_insert_user, "sssssi", $username, $email, $hashedPwd, $picture, $gender, $addressId);
    mysqli_stmt_execute($stmt_insert_user);
    $userId = mysqli_insert_id($conn); // Pobierz automatycznie nadane id użytkownika
    mysqli_stmt_close($stmt_insert_user);   

    header("Location: ../Web/register.php?error=none&userId=".$userId); // Przekaż userId jako parametr do innego skryptu
    exit();
}


/**
 * Loguje użytkownika do systemu.
 *
 * @param mysqli $conn Połączenie z bazą danych.
 * @param string $username Nazwa użytkownika lub adres e-mail użytkownika do logowania.
 * @param string $pwd Hasło użytkownika do logowania.
 * @return void
 */
function loginUser($conn, $username, $pwd) {
    $user = uidExists($conn, $username, $username);

    if ($user === false) {
        header("Location: ../Web/login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $user["haslo"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("Location: ../Web/login.php?error=wronglogin");
        exit();
    } else {
        session_start();
        $_SESSION["userid"] = $user["id"];
        $_SESSION["useruid"] = $user["nazwa_uzytkownika"];
        header("Location: ../Web/index.php");
        exit();
    }
}

function getUserInfo($conn, $userId) {
    $sql = "SELECT * FROM uzytkownicy as u INNER JOIN adresy as a ON u.addressId = a.addressId WHERE u.id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Web/profile.php?error=stmt_error");  
        exit();
    }

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("Błąd zapytania SQL: " . mysqli_error($conn));
    }
    

    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        mysqli_stmt_close($stmt);
        return $row; // Zwraca tablicę asocjacyjną z danymi użytkownika
    }

    return false; // Zwraca false, jeśli nie znaleziono rekordu
}

function updateUserProfile($conn, $userId, $firstName, $lastName, $phoneNumber, $city, $country, $postalCode, $description) {
    // Sprawdź, czy użytkownik wprowadził jakiekolwiek dane
    if (!empty($firstName) || !empty($lastName) || !empty($phoneNumber) || !empty($city) || !empty($country) || !empty($postalCode) || !empty($description)) {
        // Aktualizuj dane w tabeli uzytkownicy
        $sql_user = "UPDATE uzytkownicy SET imie=?, nazwisko=?, numer_telefonu=?, opis=? WHERE id=?";
        $stmt_user = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_user, $sql_user)) {
            header("Location: ../Web/profile.php?error=stmt_error");
            exit();
        }

        mysqli_stmt_bind_param($stmt_user, "ssssi", $firstName, $lastName, $phoneNumber, $description, $userId);
        mysqli_stmt_execute($stmt_user);
        mysqli_stmt_close($stmt_user);

        // Aktualizuj dane w tabeli adresy
        $sql_address = "UPDATE adresy SET miasto=?, kraj=?, kod_pocztowy=? WHERE addressId=?";
        $stmt_address = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_address, $sql_address)) {
            header("Location: ../Web/profile.php?error=stmt_error");
            exit();
        }

        // Pobierz addressId użytkownika
        $addressId = getAddressIdForUser($conn, $userId);

        mysqli_stmt_bind_param($stmt_address, "sssi", $city, $country, $postalCode, $addressId);
        mysqli_stmt_execute($stmt_address);
        mysqli_stmt_close($stmt_address);

        header("Location: ../Web/profile.php?id=$userId#success=profile_updated");
        exit();
    } else {
        // Jeśli użytkownik nie wprowadził żadnych danych, zakończ funkcję
        header("Location: ../Web/profile.php?id=$userId#error=nothing_updated");
        exit();
    }
}

// Funkcja pomocnicza do pobierania addressId użytkownika
function getAddressIdForUser($conn, $userId) {
    $sql = "SELECT addressId FROM uzytkownicy WHERE id=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return $row['addressId'];
}

function getKategorie($conn) {
    $sql = "SELECT * FROM kategorie";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $categories = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }

    return $categories;
}

// Funkcja pobierająca oferty z bazy danych
function getOferty($conn) {
    $oferty = array();
    $sql = "SELECT * FROM oferty";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $oferty[] = $row;
        }
        mysqli_free_result($result);
        return $oferty;
    } else {
        return false;
    }
}

// Funkcja pobierająca zdjęcie dla określonej oferty z bazy danych
function getZdjecieOferty($conn, $ofertaId) {
    $sql = "SELECT * FROM zdjecia WHERE ofertyId=?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $ofertaId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $zdjecia = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $zdjecia[] = $row;
        }
        return $zdjecia;
    } else {
        return false;
    }
}


function createOffer($conn, $nazwa, $kategoria, $opis, $lokalizacja, $telefon, $cena, $userId) {
    // Sprawdź, czy użytkownik wprowadził jakiekolwiek dane
    if (!empty($nazwa) && !empty($kategoria) && !empty($opis) && !empty($lokalizacja) && !empty($telefon) && !empty($cena)) {
        // Wstawiamy dane w tabeli oferty
        $sql_offer = "INSERT INTO `oferty`(`nazwa_produktu`, `kategoriaId`, `cena`, `data_dodania`, `opis`, `uzytkownicyId`, `lokalizacja`) VALUES ( ?, ?, ?, CURDATE(), ?, ?, ?)";
        $stmt_offer= mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_offer, $sql_offer)) {
            header("Location: ../Web/addproduct.php?error=stmt_error");
            exit();
        }

        mysqli_stmt_bind_param($stmt_offer, "siisis", $nazwa, $kategoria, $cena, $opis, $userId, $lokalizacja);
        mysqli_stmt_execute($stmt_offer);
        mysqli_stmt_close($stmt_offer);

        // Aktualizuj dane w tabeli uzytkownicy
        $sql_user = "UPDATE uzytkownicy SET numer_telefonu=? WHERE id=?";
        $stmt_user = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_user, $sql_user)) {
            header("Location: ../Web/addproduct.php?error=stmt_error");
            exit();
        }

        mysqli_stmt_bind_param($stmt_user, "si", $telefon, $userId);
        mysqli_stmt_execute($stmt_user);
        mysqli_stmt_close($stmt_user);
    } else {
        // Jeśli użytkownik nie wprowadził żadnych danych, zakończ funkcję
        header("Location: ../Web/addproduct.php?error=nothing_inserted");
        exit();
    }
}

// Pobiera id ostatnio dodanej oferty z bazy danych
function getLastOfferId($conn) {
    $sql = "SELECT MAX(ofertyId) AS lastOfferId FROM oferty";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['lastOfferId'];
}

function getOffer($conn, $offerId) {
    $sql = "SELECT oferty.*, kategorie.nazwa AS nazwa_kategorii FROM oferty INNER JOIN kategorie ON oferty.kategoriaId = kategorie.kategoriaId WHERE oferty.ofertyId=?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $offerId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// Funkcja pobierająca 5 najnowszych ofert z bazy danych
function getLatestOffers($conn) {
    $sql = "SELECT * FROM oferty ORDER BY data_dodania DESC LIMIT 5"; // Sortuj po dacie dodania malejąco i ogranicz do 5 rekordów
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $latestOffers = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $latestOffers[] = $row; // Dodaj każdą ofertę do tablicy wyników
        }
        return $latestOffers;
    } else {
        return false; // Zwróć false, jeśli nie znaleziono żadnych ofert
    }
}

/**
 * Usuwa ofertę wraz z powiązanymi zdjęciami z bazy danych.
 *
 * @param mysqli $conn Połączenie z bazą danych.
 * @param int $offerId ID oferty do usunięcia.
 * @return void
 */
function deleteOffer($conn, $offerId) {
    // Usuń zdjęcia powiązane z ofertą
    $sql_delete_images = "DELETE FROM zdjecia WHERE ofertyId=?";
    $stmt_delete_images = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_delete_images, $sql_delete_images)) {
        mysqli_stmt_bind_param($stmt_delete_images, "i", $offerId);
        mysqli_stmt_execute($stmt_delete_images);
        mysqli_stmt_close($stmt_delete_images);
    }

    // Usuń ofertę
    $sql_delete_offer = "DELETE FROM oferty WHERE ofertyId=?";
    $stmt_delete_offer = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_delete_offer, $sql_delete_offer)) {
        mysqli_stmt_bind_param($stmt_delete_offer, "i", $offerId);
        mysqli_stmt_execute($stmt_delete_offer);
        mysqli_stmt_close($stmt_delete_offer);
    }

    $sql_delete_rezerwacja = "DELETE FROM wypozyczenia WHERE ofertyId=?";
    $stmt_delete_rezerwacja = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_delete_rezerwacja, $sql_delete_rezerwacja)) {
        mysqli_stmt_bind_param($stmt_delete_rezerwacja, "i", $offerId);
        mysqli_stmt_execute($stmt_delete_rezerwacja);
        mysqli_stmt_close($stmt_delete_rezerwacja);
    }
}

function getOfertyByKategoriaId($conn, $kategoriaId) {
    $oferty = array();
    // Przygotuj zapytanie SQL, które pobierze tylko oferty z danej kategorii
    $sql = "SELECT * FROM oferty WHERE kategoriaId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false; // Jeśli zapytanie nie jest przygotowane, zwróć false
    } else {
        // Zwiąż parametry zapytania
        mysqli_stmt_bind_param($stmt, "i", $kategoriaId);
        // Wykonaj zapytanie
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $oferty[] = $row;
            }
            mysqli_free_result($result);
            return $oferty;
        } else {
            return false;
        }
    }
}

function getOfertyByUzytkownik($conn, $userId) {
    $oferty = array();
    // Przygotuj zapytanie SQL, które pobierze tylko oferty od danego uzytkownika
    $sql = "SELECT * FROM oferty WHERE uzytkownicyId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false; // Jeśli zapytanie nie jest przygotowane, zwróć false
    } else {
        // Zwiąż parametry zapytania
        mysqli_stmt_bind_param($stmt, "i", $userId);
        // Wykonaj zapytanie
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $oferty[] = $row;
            }
            mysqli_free_result($result);
            return $oferty;
        } else {
            return false;
        }
    }
}

function requestOfRental($conn, $userId, $offerId, $dataRozpoczecia, $dataZakonczenia, $cena) {
        // Wstawiamy dane w tabeli oferty
        $sql = "INSERT INTO `wypozyczenia`(`uzytkownikId`, `ofertyId`, `dataRozpoczecia`, `dataZakonczenia`, `cena`) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt , $sql)) {
            header("Location: ../Web/product.php?id=$offerId#error=stmt_error");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "iissd", $userId, $offerId, $dataRozpoczecia, $dataZakonczenia, $cena);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $sql_offer = "UPDATE oferty SET dostepna = 0 WHERE ofertyId = ?";
        $stmt_offer= mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_offer, $sql_offer)) {
            header("Location: product.php?id=$offerId#error=stmt_error");
            exit();
        }

        mysqli_stmt_bind_param($stmt_offer, "i", $offerId);
        mysqli_stmt_execute($stmt_offer);
        mysqli_stmt_close($stmt_offer);
}

function getLiczbaOfertUzytkownika($conn, $userId) {
    $liczbaOfert = 0;
    $sql = "SELECT COUNT(*) AS liczba_ofert FROM oferty WHERE uzytkownicyId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $liczbaOfert = $row['liczba_ofert'];
        }
        mysqli_stmt_close($stmt);
    }
    return $liczbaOfert;
}

function getLiczbaWypozyczenUzytkownika($conn, $userId) {
    $liczbaWypozyczen = 0;
    $sql = "SELECT COUNT(*) AS liczba_wypozyczen FROM wypozyczenia WHERE uzytkownikId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $liczbaWypozyczen = $row['liczba_wypozyczen'];
        }
        mysqli_stmt_close($stmt);
    }
    return $liczbaWypozyczen;
}

function createRozgrywka($conn, $nazwa, $kategoria, $data, $liczbaOsob, $opis, $lokalizacja, $telefon ,$userId) {
        // Wstawiamy dane w tabeli rozgrywki
        $sql = "INSERT INTO `rozgrywki`(`nazwa`, `kategoriaId`, `dataRozgrywki`, `lokalizacja`, `liczbaOsob`, `opis`, `uzytkownicyId`) VALUES (? , ?, ?, ?, ?, ?, ?)";
        $stmt= mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../Web/addrozgrywki.php?error=stmt_error");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sissisi", $nazwa, $kategoria, $data, $lokalizacja, $liczbaOsob, $opis, $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Aktualizuj dane w tabeli uzytkownicy
        $sql_user = "UPDATE uzytkownicy SET numer_telefonu=? WHERE id=?";
        $stmt_user = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_user, $sql_user)) {
            header("Location: ../Web/addrozgrywki.php?error=stmt_error");
            exit();
        }

        mysqli_stmt_bind_param($stmt_user, "si", $telefon, $userId);
        mysqli_stmt_execute($stmt_user);
        mysqli_stmt_close($stmt_user);
    }

    
function getLastRozgrywkaId($conn) {
    $sql = "SELECT MAX(rozgrywkiId) AS lastRozgrywkiId FROM rozgrywki";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['lastRozgrywkiId'];
}

// Funkcja pobierająca zdjęcie dla określonej rozgrywek z bazy danych
function getZdjecieRozgrywki($conn, $rozgrywkiId) {
    $sql = "SELECT * FROM zdjecia WHERE rozgrywkiId=? AND typ = 'rozgrywka'";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $rozgrywkiId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $zdjecia = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $zdjecia[] = $row;
        }
        return $zdjecia;
    } else {
        return false;
    }
}

function getRozgrywka($conn, $rozgrywkiId) {
    $sql = "SELECT rozgrywki.*, kategorie.nazwa AS nazwa_kategorii FROM rozgrywki INNER JOIN kategorie ON rozgrywki.kategoriaId = kategorie.kategoriaId WHERE rozgrywki.rozgrywkiId=?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $rozgrywkiId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function deleteRozgrywka($conn, $rozgrywkaId) {
    // Usuń zdjęcia powiązane z ofertą
    $sql_delete_images = "DELETE FROM zdjecia WHERE rozgrywkiId=?";
    $stmt_delete_images = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_delete_images, $sql_delete_images)) {
        mysqli_stmt_bind_param($stmt_delete_images, "i", $rozgrywkaId);
        mysqli_stmt_execute($stmt_delete_images);
        mysqli_stmt_close($stmt_delete_images);
    }

    // Usuń ofertę
    $sql_delete_rozgrywka = "DELETE FROM rozgrywki WHERE rozgrywkiId=?";
    $stmt_delete_rozgrywka = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_delete_rozgrywka, $sql_delete_rozgrywka)) {
        mysqli_stmt_bind_param($stmt_delete_rozgrywka, "i", $rozgrywkaId);
        mysqli_stmt_execute($stmt_delete_rozgrywka);
        mysqli_stmt_close($stmt_delete_rozgrywka);
    }
}

function deleteUczestnictwoAutor($conn, $rozgrywkaId) {
    // Usuń uczestnictwo związane z rozgrywką
    $sql_delete_uczestnictwo = "DELETE FROM uczestnictwo WHERE rozgrywkiId=?";
    $stmt_delete_uczestnictwo = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_delete_uczestnictwo, $sql_delete_uczestnictwo)) {
        mysqli_stmt_bind_param($stmt_delete_uczestnictwo, "i", $rozgrywkaId);
        mysqli_stmt_execute($stmt_delete_uczestnictwo);
        mysqli_stmt_close($stmt_delete_uczestnictwo);
    }
}


function getRozgrywkiByKategoriaId($conn, $kategoriaId) {
    $rozgrywki = array();
    // Przygotuj zapytanie SQL, które pobierze tylko oferty z danej kategorii
    $sql = "SELECT * FROM rozgrywki WHERE kategoriaId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false; // Jeśli zapytanie nie jest przygotowane, zwróć false
    } else {
        // Zwiąż parametry zapytania
        mysqli_stmt_bind_param($stmt, "i", $kategoriaId);
        // Wykonaj zapytanie
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rozgrywki[] = $row;
            }
            mysqli_free_result($result);
            return $rozgrywki;
        } else {
            return false;
        }
    }
}

function getRozgrywki($conn) {
    $rozgrywki = array();
    $sql = "SELECT * FROM rozgrywki";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rozgrywki[] = $row;
        }
        mysqli_free_result($result);
        return $rozgrywki;
    } else {
        return false;
    }
}

function addUczestnictwo($conn, $rozgrywkiId, $uzytkownicyId) {
    $sql = "INSERT INTO `uczestnictwo` (`rozgrywkiId`, `uzytkownicyId`) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt , $sql)) {
        header("Location: ../Web/rozgrywka.php?id=$rozgrywkiId#error=stmt_error");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $rozgrywkiId, $uzytkownicyId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function countUczestnictwo($conn, $rozgrywkaId) {
    $liczbaUczestnictw = 0;
    $sql = "SELECT COUNT(uzytkownicyId) AS liczba_uczestnictw FROM uczestnictwo WHERE rozgrywkiId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $rozgrywkaId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $liczbaUczestnictw = $row['liczba_uczestnictw'];
        }
        mysqli_stmt_close($stmt);
    }
    return $liczbaUczestnictw;
}

function checkIfUczestniczy($conn, $rozgrywkaId, $userId) {
    $sql = "SELECT * FROM uczestnictwo WHERE rozgrywkiId = ? AND uzytkownicyId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Web/rozgrywka.php?id=$rozgrywkaId#error=stmt_error");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $rozgrywkaId, $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Użytkownik uczestniczy już w tej rozgrywce
        mysqli_stmt_close($stmt);
        return true;
    } else {
        // Użytkownik nie uczestniczy w tej rozgrywce
        mysqli_stmt_close($stmt);
        return false;
    }
}

function deleteUczestnictwo($conn, $rozgrywkaId, $userId) {
    $sql = "DELETE FROM uczestnictwo WHERE rozgrywkiId=? AND uzytkownicyId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $rozgrywkaId, $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

function getLatestRozgrywki($conn) {
    $sql = "SELECT * FROM rozgrywki ORDER BY dataRozgrywki DESC LIMIT 5"; 
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $latestRozgrywki = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $latestRozgrywki[] = $row; // Dodaj każdą rozgrywkę do tablicy wyników
        }
        return $latestRozgrywki;
    } else {
        return false; // Zwróć false, jeśli nie znaleziono żadnych rozgrywek
    }
}

function getLiczbaRozgrywekUzytkownika($conn, $userId) {
    $liczbaRozgrywek = 0;
    $sql = "SELECT COUNT(*) AS liczba_rozgrywek FROM rozgrywki WHERE uzytkownicyId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $liczbaRozgrywek = $row['liczba_rozgrywek'];
        }
        mysqli_stmt_close($stmt);
    }
    return $liczbaRozgrywek;
}

function getRozgrywkiByUzytkownik($conn, $userId) {
    $rozgrywki = array();
    // Przygotuj zapytanie SQL, które pobierze tylko rozgrywki od danego uzytkownika
    $sql = "SELECT * FROM rozgrywki WHERE uzytkownicyId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false; // Jeśli zapytanie nie jest przygotowane, zwróć false
    } else {
        // Zwiąż parametry zapytania
        mysqli_stmt_bind_param($stmt, "i", $userId);
        // Wykonaj zapytanie
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rozgrywki[] = $row;
            }
            mysqli_free_result($result);
            return $rozgrywki;
        } else {
            return false;
        }
    }
}