<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GearUp Rentals - Rozgrywki</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../Styles/main.css">
    <link rel="stylesheet" href="../Styles/oferty.css">
</head>
<body> 
    <div class="app">
        <div class="app-root">
            <?php include_once("header.php");?>
            <div class="content">
                <div class="filterBox">
                    <div class="kategoria" id="kategoriaContainer">
                        <label for="kategorie" class="lblKat">
                        <?php 
                            require_once("dbh.php");
                            require_once("functionsinc.php");
                            $kategorie = getKategorie($conn);
                            $kategoriaId = $_GET['kategoria'];
                        
                            foreach ($kategorie as $kategoria) { 
                                if($kategoria["kategoriaId"] == $kategoriaId) {
                                    echo("Rozgrywki / ".$kategoria["nazwa"]); 
                                }
                            }
                            if ($kategoriaId == "wszystko") {
                                echo("Rozgrywki / Wszystko"); 
                            }
                            ?>
                        </label>  
                        <select id="kategorie" name="kategorie">
                            <option value="wszystko">Wszystko</option>
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
                    <div class="button">
                        <a href="../Web/addrozgrywki.php"><input type="submit" class="buy-btn nav-button-1 nav-text bold buttons" value="Dodaj rozgrywkę"></a>
                    </div>
                </div>
                <div class="oferty">
                    <div class="latestOffer">
                        <?php 
                        require_once("dbh.php");
                        require_once("functionsinc.php");
                        $kategoriaId = $_GET['kategoria'];

                        if ($kategoriaId != "wszystko") {
                            
                            $rozgrywki = getRozgrywkiByKategoriaId($conn, $kategoriaId);
                            // Wyświetl rozgrywki
                            if ($rozgrywki) {
                                foreach ($rozgrywki as $rozgrywka) {
                                    $rozgrywkaId = $rozgrywka['rozgrywkiId'];
                                    $zdjecia =  getZdjecieRozgrywki($conn, $rozgrywkaId);
                                    $imagePath = "../Images/Rozgrywki/".$zdjecia[0]['nazwa_pliku']; // Ścieżka do pierwszego zdjęcia rozgrywek
                                    echo '<a href="../Web/rozgrywka.php?id='.$rozgrywkaId.'">';
                                    echo '<div class="offer">';
                                    echo '<div class="image-wrapper">';
                                    echo '<img src="'.$imagePath.'" alt="'.$rozgrywka["nazwa"].'">'; // Ustawienie ścieżki do zdjęcia jako src
                                    echo '</div>';
                                    echo '<h3>' . $rozgrywka["nazwa"] . '</h3>';
                                    echo '<p>Data: ' .$rozgrywka["dataRozgrywki"] .'</p>';
                                    echo '</div>';
                                    echo '</a>';
                                }
                            } else {
                                echo "<script> let latestOffer = document.getElementsByClassName('latestOffer')[0];"; 
                                echo "latestOffer.style.justifyContent = 'center';";
                                echo "latestOffer.style.height = '300px';";
                                echo "</script>";
                                echo "<div class='info-h2'><h2>Brak ofert w wybranej kategorii.</h2></div>";
                            }
                        } else {
                            $rozgrywki = getRozgrywki($conn);

                            // Wyświetl rozgrywki
                            if ($rozgrywki) {
                                foreach ($rozgrywki as $rozgrywka) {
                                    $rozgrywkaId = $rozgrywka['rozgrywkiId'];
                                    $zdjecia =  getZdjecieRozgrywki($conn, $rozgrywkaId);
                                    $imagePath = "../Images/Rozgrywki/".$zdjecia[0]['nazwa_pliku']; // Ścieżka do pierwszego zdjęcia rozgrywek
                                    echo '<a href="../Web/rozgrywka.php?id='.$rozgrywkaId.'">';
                                    echo '<div class="offer">';
                                    echo '<div class="image-wrapper">';
                                    echo '<img src="'.$imagePath.'" alt="'.$rozgrywka["nazwa"].'">'; // Ustawienie ścieżki do zdjęcia jako src
                                    echo '</div>';
                                    echo '<h3>' . $rozgrywka["nazwa"] . '</h3>';
                                    echo '<p>Data: ' .$rozgrywka["dataRozgrywki"] .'</p>';
                                    echo '</div>';
                                    echo '</a>';
                                }
                            } else {
                                echo '<p>Brak dostępnych ofert.</p>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php include_once("footer.php") ?>
        </div>
    </div>
    
    <script src="../Scripts/oferty.js" async defer></script>
    <script src="../Scripts/main.js" async defer></script>
</body>
</html>
