<?php 
    function checkIfLoggedInAndChangeNav() {
        // Sprawdzenie, czy użytkownik jest zalogowany
        if(isset($_SESSION["userid"])) {
            $userId = $_SESSION['userid'];
            echo "<a class='link-button link-button-1' href='../Web/profile.php?id=".$userId."'><button class='nav-button nav-text bold'>Profil</button></a>";
        } else {
            echo "<a class='link-button link-button-1' href='../Web/login.php'><button class='nav-button nav-text bold'>Zaloguj się</button></a>";
        }
    }

    function checkIfLoggedInAndChangeMainButton() {
        
        // Sprawdzenie, czy użytkownik jest zalogowany
        $isUserLoggedIn = isset($_SESSION["userid"]);

        if($isUserLoggedIn) {
            echo "<a class='link-button' href='../Web/addproduct.php'><button class=' nav-text bold button_slide slide_down'>Dodaj ofertę</button></a>";
        } else {
            echo "<a class='link-button' href='../Web/register.php'><button class=' nav-text bold button_slide slide_down'>Zacznij tutaj</button></a>";
        }
    }
