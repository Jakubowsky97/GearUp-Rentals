<?php
/**
 * Proces rejestracji użytkownika
 * 
 * Ten kod sprawdza, czy formularz rejestracji został przesłany,
 * waliduje wprowadzone dane i tworzy nowe konto użytkownika,
 * jeśli dane są poprawne.
 * 
 * @param string $_POST['submit'] Wartość przycisku "submit" w formularzu
 * @param string $_POST['email'] Wprowadzony adres e-mail
 * @param string $_POST['username'] Wprowadzona nazwa użytkownika
 * @param string $_POST['password'] Wprowadzone hasło
 * @param string $_POST['gender'] Wybrana płeć
 * @param string require_once 'dbh.php' Dołącza plik z połączeniem do bazy danych
 * @param string require_once 'functionsinc.php' Dołącza plik z niestandardowymi funkcjami
 * @param string header() Przekierowuje użytkownika na inną stronę
 * @param string exit() Zatrzymuje wykonanie skryptu
 * @param boolean invalidUid() Sprawdza, czy nazwa użytkownika jest nieprawidłowa
 * @param boolean invalidEmail() Sprawdza, czy adres e-mail jest nieprawidłowy
 * @param boolean|string uidExists() Sprawdza, czy nazwa użytkownika lub adres e-mail już istnieje w bazie danych
 * @param void createUser() Tworzy nowe konto użytkownika w bazie danych
 * @param string echo "Stworzono konto" Wyświetla komunikat o sukcesie
 */

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $username = $_POST['username'];
    $pwd = $_POST['password'];
    $gender = $_POST['gender'];

    require_once 'dbh.php';
    require_once 'functionsinc.php';


    if (invalidUid($username) !== false) {
        header("Location: ../Web/register.php?error=invalidUid");
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("Location: ../Web/register.php?error=invalidEmail");
        exit();
    }

    if (uidExists($conn, $username, $email) !== false) {
        header("Location: ../Web/register.php?error=usernametaken");
        exit();
    }

    createUser($conn, $email, $username, $pwd, "../Images/Profile/defaultUser.jpg", $gender, "", "", "");
    echo "Stworzono konto";

} else {
    header("Location: ../Web/register.php?error=blad");
    exit();
}
