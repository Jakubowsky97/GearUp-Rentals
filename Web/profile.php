<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GearUp Rentals - Profil</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../Styles/profile.css">
        <link rel="stylesheet" href="../Styles/visitingProfile.css">
        <link rel="stylesheet" href="../Styles/main.css">
    </head>
    <body> 
        <?php include_once("header.php");?>
            <div class="main-content">
                <?php 
                require_once 'dbh.php';
                require_once("functionsinc.php");
                // Pobierz identyfikator użytkownika z parametru w URL
                if (isset($_GET['id'])) {
                    $profileUserId = $_GET['id'];

                    // Pobierz informacje o użytkowniku z funkcji getUserInfo
                    $userInfo = getUserInfo($conn, $profileUserId);

                    // Sprawdź, czy udało się pobrać informacje o użytkowniku
                    if ($userInfo) {
                        if(isset($_SESSION["userid"]) && $profileUserId == $_SESSION['userid']) {
                            include_once("editprofile.php");
                        } else {
                            include_once("profilevisit.php");
                        }
                    } else {
                        echo "Nie znaleziono danych użytkownika.";
                    }
                } else {
                    echo "Brak identyfikatora użytkownika.";
                }
                ?>
            </div>
                <?php include_once("footer.php") ?>
            </div>
        </div>

        <script src="../Scripts/main.js" async defer></script>
    </body>
</html>