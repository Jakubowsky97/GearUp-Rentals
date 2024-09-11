<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GearUp Rentals - Dodaj produkt</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../Styles/main.css">
        <link rel="stylesheet" href="../Styles/addProduct.css">
    </head>
    <body>
        <?php 
        error_reporting(E_ERROR | E_PARSE); // Wyłącza wyświetlanie ostrzeżeń i notatek
        session_start();
        $isUserLoggedIn = isset($_SESSION["userid"]);

        if(!$isUserLoggedIn) {
            header("Location: login.php");
        }
        ?>
        <div class="app">
            <div class="app-root">
                <?php include_once("header.php");
                ?>
                <div class="content">
                    <div class="main-title">
                        <h1>Dodaj ofertę</h1>
                    </div>
                        <div class="container imageBox">
                            <h2 class="info">Podaj nazwę oferty oraz wybierz kategorię.</h2>
                            <form action="addproductinc.php" method="post" enctype="multipart/form-data">
                                <div class="form">
                                    <div>
                                        <div class="nazwaBox">
                                            <label for="Input">Nazwa oferty*</label><br>
                                            <input type="text" name="nazwa" id="nazwaInput" minlength="16" maxlength="96">
                                            <h4 class="info-input">Wpisz przynajmniej 16 znaków</h4>
                                        </div>
                                        <div class="kategoria">
                                            <label for="kategoriaInput">Kategoria*</label><br>
                                            <select id="kategorie" name="kategorie">
                                                <option value="brak"></option>
                                                <?php 
                                                    require_once("dbh.php");
                                                    require_once("functionsinc.php");

                                                    $kategorie = getKategorie($conn);
                                                    $userInfo = getUserInfo($conn, $_SESSION['userid']);
                                                foreach ($kategorie as $kategoria) {
                                                    echo "<option value='".$kategoria["kategoriaId"]."'>".$kategoria["nazwa"]."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="imageUploader">
                                    <label for="uploadImg" class="bold">Dodaj zdjęcia do twojej oferty. Maksymalnie 4 zdjęć: </label><br>
                                    <input type="file" id="uploadInput" accept="image/jpg, image/jpeg, image/png" name="images[]" multiple>
                                    <img src="../Images/upload.png" alt="upload images" onclick="document.getElementById('uploadInput').click();" class="uploadImg">
                                </div>
                        </div>
                        <div class="container container_location">
                            <div style="margin-top: 20px;">
                                <label for="cena" class="Label">Cena wypożyczenia za tydzień*</label><br>
                                <input name="cena" id="Input" type="number">
                            </div>
                        </div>
                        <div class="container">
                                <label for="Input" class="Label">Opis*</label>
                                <textarea name="opis" id="Input" cols="30" rows="10" maxlength="9000" minlength="40"></textarea>
                                <p>Wpisz conajmniej 40 znaków</p>
                        </div>
                        <div class="container container_location">
                                <label for="Input" class="Label">Lokalizacja*</label>
                                <input name="lokalizacja" id="Input" type="text">
                        </div>
                        <div class="container container_dane">
                        <h2 class="info">Dane kontaktowe</h2>
                        <div>
                            <label for="imie" class="Label">Imię*</label><br>
                            <input name="imie" id="imie" type="text" value="<?php echo($userInfo['imie']); ?>" disabled>
                        </div>
                        <div style="margin-top: 10px;">
                            <label for="email" class="Label">Email*</label><br>
                            <input name="email" id="email" type="text" value="<?php echo($userInfo['email']); ?>" disabled>
                        </div>
                        <div style="margin-top: 10px;">
                            <label for="numer" class="Label">Numer telefonu*</label><br>
                            <input name="numer" id="numer" type="tel" value="<?php echo($userInfo['numer_telefonu']); ?>">
                        </div>    
                        </div>
                        <div class="container container_buttons">
                            <input type="submit" class="nav-button-1 nav-text bold buttons" value="Dodaj ofertę">                          
                        </div>
                    </form>
                </div>
                <?php include_once("footer.php") ?>
            </div>
        </div>

        <script src="../Scripts/main.js" async defer></script>
        <script src="../Scripts/kategoria.js" async defer></script>
        <script>
            var submitButton = document.querySelector("input[type='submit']");
            submitButton.addEventListener('click', function(event) {
                var fileUpload = document.querySelector("input[type='file']");
                if (fileUpload.files.length > 4) {
                    event.preventDefault();
                    alert("Możesz przesłać maksymalnie 4 pliki");
                }
            });
        </script>
    </body>
</html>