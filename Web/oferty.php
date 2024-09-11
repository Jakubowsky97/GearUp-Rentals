<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GearUp Rentals - Oferty</title>
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
                                    echo("Oferty / ".$kategoria["nazwa"]); 
                                }
                            }
                            if ($kategoriaId == "wszystko") {
                                echo("Oferty / Wszystko"); 
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
                </div>
                <div class="oferty">
                    <div class="latestOffer">
                        <?php 
                        require_once("dbh.php");
                        require_once("functionsinc.php");
                        $kategoriaId = $_GET['kategoria'];

                        if ($kategoriaId != "wszystko") {
                            
                            $oferty = getOfertyByKategoriaId($conn, $kategoriaId);
                            // Wyświetl oferty
                            if ($oferty) {
                                foreach ($oferty as $oferta) {
                                    $offerId = $oferta['ofertyId'];
                                    $zdjecia =  getZdjecieOferty($conn, $offerId);
                                    $imagePath = "../Images/Oferty/".$zdjecia[0]['nazwa_pliku']; // Ścieżka do pierwszego zdjęcia oferty
                                    echo '<a href="../Web/product.php?id='.$offerId.'">';
                                    echo '<div class="offer">';
                                    echo '<div class="image-wrapper">';
                                    echo '<img src="'.$imagePath.'" alt="'.$oferta["nazwa_produktu"].'">'; // Ustawienie ścieżki do zdjęcia jako src
                                    echo '</div>';
                                    echo '<h3>' . $oferta["nazwa_produktu"] . '</h3>';
                                    echo '<p>Cena: ' . $oferta["cena"] . ' zł za tydzień</p>';
                                    // Dodaj więcej informacji na temat oferty, jeśli jest to konieczne
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
                            $Offers = getOferty($conn);

                            if ($Offers) {
                                foreach ($Offers as $offer) {
                                    $offerId = $offer['ofertyId'];
                                    $zdjecia =  getZdjecieOferty($conn, $offerId);
                                    $imagePath = "../Images/Oferty/".$zdjecia[0]['nazwa_pliku']; // Ścieżka do pierwszego zdjęcia oferty
                                    echo '<a href="../Web/product.php?id='.$offerId.'">';
                                    echo '<div class="offer">';
                                    echo '<div class="image-wrapper">';
                                    echo '<img src="'.$imagePath.'" alt="'.$offer["nazwa_produktu"].'">'; // Ustawienie ścieżki do zdjęcia jako src
                                    echo '</div>';
                                    echo '<h3>' . $offer["nazwa_produktu"] . '</h3>';
                                    echo '<p>Cena: ' . $offer["cena"] . ' zł za tydzień</p>';
                                    // Dodaj więcej informacji na temat oferty, jeśli jest to konieczne
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
