<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GearUp Rentals - Produkt</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../Styles/main.css">
        <link rel="stylesheet" href="../Styles/product.css">
    </head>
    <body>  
        <?php 
        error_reporting(0);
            require_once("dbh.php");
            require_once("functionsinc.php");
            $offerId = $_GET['id'];
            $offer = getOffer($conn, $offerId);
            $zdjecia = getZdjecieOferty($conn, $offerId); 
            $userId = $offer['uzytkownicyId'];
            $user = getUserInfo($conn, $userId);

            if(!$offer) {
                header("Location: error.php");
            }
            if ($offer['dostepna'] == 0) {
                header("Location: error.php?dostepnosc=false");
            }
        ?>
                <?php include_once("header.php");?>
                    <div class="container content my-5">
                        <div class="row">
                            <div class="col-lg-5 col-md-12 col-12">
                                <div class="main-img">
                                    <img id="MainImg" class="img-fluid pb-1" src="../Images/Oferty/<?php echo $zdjecia[0]['nazwa_pliku'];?>"  alt="Main Image">
                                </div>
                                

                                <div class="small-img-group">
                                    <?php 
                                        // Pętla foreach do wyświetlenia reszty zdjęć
                                        foreach ($zdjecia as $zdjecie) {
                                            echo '<div class="small-img-col">';
                                            echo '<img class="small-img" src="../Images/Oferty/' . $zdjecie['nazwa_pliku'] . '" alt="Thumbnail" width="100%">';
                                            echo '</div>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12 info">
                            <h6><?php echo("Oferty / ".$offer['nazwa_kategorii']); ?></h6>
                                <h3 class="pb-3 pt-1"><?php echo($offer['nazwa_produktu']); ?></h3>
                                <h6 class="dataDod">Data dodania: <span style="color: black;"><?php echo($offer['data_dodania']);?></span></h6>
                                <h6 class="dataDod">Właściciel: <?php echo("<a href='../Web/profile.php?id=".$userId."'>".$user['imie']." ". $user['nazwisko']."</a>");?></h6>
                                <h6 class="dataDod">Lokalizacja: <span style="color: black;"><?php echo($offer['lokalizacja']);?></span></h6>
                                <h2><?php echo($offer['cena']."zł za tydzień");?></h2>
                            <form action="wynajminc.php?ofertaId=<?php echo($offerId);?>" method="post" onsubmit="return validateForm()">
                                <div class="data my-3">
                                    <div class="start">
                                        <h6>Data rozpoczęcia</h6>
                                        <input type="date" name="dataPocz" id="dataPocz" onchange="calculateTotal()" required>
                                    </div>
                                    <div class="end">
                                        <h6>Data zakończenia</h6>
                                        <input type="date" name="dataKonc" id="dataKonc" onchange="calculateTotal()" required>
                                    </div>
                                </div>
                                <input type="submit" class="buy-btn nav-button-1 nav-text bold buttons" value="Zarezerwuj">
                            </form>
                                <?php 
                                    if($userId == $_SESSION['userid']) {
                                        $offerId = $_GET['id'];
                                        echo '<form method="post" action="deleteProduct.php">';
                                        echo '<input type="hidden" name="offer_id" value='.$offerId.'>';
                                        echo '<input type="submit" class="del-btn nav-button-1 nav-text bold buttons" value="Usuń ofertę">';
                                        echo '</form>';
                                    }
                                ?>
                                <span id="totalAmountSpan"></span>
                            
                                    <h4 class="mt-5 mb-5">Opis oferty</h4>
                                    <span class="opis"><?php echo($offer['opis']);?></span>
                                
                            </div>
                        </div>
                    </div>
                <?php include_once("footer.php") ?>

        <script src="../Scripts/main.js" async defer></script>
        <script src="../Scripts/product.js"></script>
        <script>
            function calculateTotal() {
                var startDateValue = document.getElementById("dataPocz").value;
                var endDateValue = document.getElementById("dataKonc").value;
                var totalAmountSpan = document.getElementById("totalAmountSpan");

                // Sprawdź, czy oba pola daty mają wartość
                if (startDateValue && endDateValue) {
                    var startDate = new Date(startDateValue);
                    var endDate = new Date(endDateValue);

                    // Sprawdź, czy daty są poprawne
                    if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime())) {
                        // Oblicz różnicę między datami w dniach
                        var differenceInTime = endDate.getTime() - startDate.getTime();
                        var differenceInDays = differenceInTime / (1000 * 3600 * 24);

                        // Pobierz cenę za tydzień z PHP i przekształć ją w liczbę
                        var cenaZaTydzien = <?php echo $offer['cena']; ?>;
                        var cenaZaTydzienNumber = parseFloat(cenaZaTydzien);

                        // Oblicz całkowitą kwotę do zapłaty
                        var totalAmount = cenaZaTydzienNumber * (differenceInDays / 7);

                        // Wyświetl kwotę do zapłaty
                        totalAmountSpan.innerHTML = "Do zapłaty: " + totalAmount.toFixed(2) + " zł";
                    } else {
                        // Wyświetl alert, jeśli daty są nieprawidłowe
                        alert("Podane daty są nieprawidłowe!");
                    }
                } else {
                }
            }
        </script>
    </body>
</html>