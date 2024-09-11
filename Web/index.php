<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GearUp Rentals - Strona Główna</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../Styles/main.css">
    </head>
    <body> 
                <?php include_once("header.php");?>
                <div class="content">
                    <div class="main-block">
                        <img src="../Images/background.jpg" alt="bg" height="" class="background">
                        <div class="half-block"></div>
                        <div class="main-text-block">
                            <p>
                                <span class="main-text first-color">Wypożyczaj </span> <span class="main-text second-color">sprzęt sportowy i </span> <span class="main-text third-color">realizuj </span> <span class="main-text second-color">swoje sportowe <br/>marzenia</span>
                            </p>
                        </div>
                        <div class="secondary-text-block">
                            <p>
                            Oferujemy szeroki wybór sprzętu sportowego do wypożyczenia online. 
                            <br/>Z nami możesz także dzielić się
                            swoimi własnymi rzeczami,<br/> wystawiając je do wypożyczenia dla innych entuzjastów sportu. 
                            </p>
                            <?php 
                                checkIfLoggedInAndChangeMainButton();
                            ?>
                        </div>
                    </div>
                    <div class="container">
                    <div class="row">
                        <h1 class="heading">
                        Kategorie produktowe dostępne w naszej wypożyczalni
                        </h1>

                    <div class="box-slider">
                        <?php 
                            require_once("dbh.php");
                            require_once("functionsinc.php");

                            $kategorie = getKategorie($conn);
                            if ($kategorie) {
                                foreach ($kategorie as $kategoria) {
                                    echo("<a href='../Web/oferty.php?kategoria=".$kategoria["kategoriaId"]."' style='display: none;' id='toCategory".$kategoria["kategoriaId"]."'></a>");
                                    echo "<div class='img' onclick=\"document.getElementById('toCategory".$kategoria["kategoriaId"]."').click();\">";
                                    echo '<p class="info">' . $kategoria["nazwa"] . '</p>';
                                    echo '<img src="../Images/' . $kategoria["zdjecie_url"] . '" alt="' . $kategoria["nazwa"] . '" >';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>Nie znaleziono żadnych kategorii.</p>';
                            }
                        ?>
                        </div>
                    </div>
                    </div>
                    <div>
                        <h1 class="heading">Ostatnie oferty:</h1>
                        <div class="latestOffer">
                            <?php 
                            require_once("dbh.php");
                            require_once("functionsinc.php");

                            $latestOffers = getLatestOffers($conn);

                            if ($latestOffers) {
                                foreach ($latestOffers as $offer) {
                                    $offerId = $offer['ofertyId']; // Poprawna zmienna
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
                            ?>
                        </div>
                    </div>
                    <div>
                        <h1 class="heading">Najbliższe rozgrywki:</h1>
                        <div class="latestOffer">
                            <?php 
                            require_once("dbh.php");
                            require_once("functionsinc.php");

                            $latestRozgrywki = getLatestRozgrywki($conn);

                            if ($latestRozgrywki) {
                                foreach ($latestRozgrywki as $latestRozgrywka) {
                                    $rozgrywkaId = $latestRozgrywka['rozgrywkiId'];
                                    $zdjecia =  getZdjecieRozgrywki($conn, $rozgrywkaId);
                                    $imagePath = "../Images/Rozgrywki/".$zdjecia[0]['nazwa_pliku']; // Ścieżka do pierwszego zdjęcia rozgrywek
                                    echo '<a href="../Web/rozgrywka.php?id='.$rozgrywkaId.'">';
                                    echo '<div class="offer">';
                                    echo '<div class="image-wrapper">';
                                    echo '<img src="'.$imagePath.'" alt="'.$latestRozgrywka["nazwa"].'">'; // Ustawienie ścieżki do zdjęcia jako src
                                    echo '</div>';
                                    echo '<h3>' . $latestRozgrywka["nazwa"] . '</h3>';
                                    echo '<p>Data: ' .$latestRozgrywka["dataRozgrywki"] .'</p>';
                                    echo '</div>';
                                    echo '</a>';
                                }
                            } else {
                                echo '<p>Brak dostępnych ofert.</p>';
                            }
                            ?>
                        </div>
                    </div>
                    
                </div>
                <?php include_once("footer.php") ?>
            </div>
        </div>

        <script src="../Scripts/main.js" async defer></script>
    </body>
</html>