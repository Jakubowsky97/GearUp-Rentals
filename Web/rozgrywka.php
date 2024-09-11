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
            $rozgrywkiId = $_GET['id'];
            $rozgrywka = getRozgrywka($conn, $rozgrywkiId);
            $zdjecia = getZdjecieRozgrywki($conn, $rozgrywkiId); 
            $userId = $rozgrywka['uzytkownicyId'];
            $user = getUserInfo($conn, $userId);

            if(!$rozgrywka) {
                header("Location: error.php");
            }
            
        ?>
                <?php include_once("header.php");?>
                    <div class="container content my-5">
                        <div class="row">
                            <div class="col-lg-5 col-md-12 col-12">
                                <div class="main-img">
                                    <img id="MainImg" class="img-fluid pb-1" src="../Images/Rozgrywki/<?php echo $zdjecia[0]['nazwa_pliku'];?>"  alt="Main Image">
                                </div>
                                

                                <div class="small-img-group">
                                    <?php 
                                        // Pętla foreach do wyświetlenia reszty zdjęć
                                        foreach ($zdjecia as $zdjecie) {
                                            echo '<div class="small-img-col">';
                                            echo '<img class="small-img" src="../Images/Rozgrywki/' . $zdjecie['nazwa_pliku'] . '" alt="Thumbnail" width="100%">';
                                            echo '</div>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12 info">
                            <h6><?php echo("Rozgrywki / ".$rozgrywka['nazwa_kategorii']); ?></h6>
                                <h3 class="pb-3 pt-1"><?php echo($rozgrywka['nazwa']); ?></h3>
                                <h6 class="dataDod">Data rozgrywki: <span style="color: black;"><?php echo($rozgrywka['dataRozgrywki']);?></span></h6>
                                <h6 class="dataDod">Organizator: <?php echo("<a href='../Web/profile.php?id=".$userId."'>".$user['imie']." ". $user['nazwisko']."</a>");?></h6>
                                <h6 class="dataDod">Lokalizacja: <span style="color: black;"><?php echo($rozgrywka['lokalizacja']);?></span></h6>
                                <h6 class="dataDod">Liczba osób potrzebna: <span style="color: black;"><?php echo(countUczestnictwo($conn, $rozgrywkiId));?>/<?php echo($rozgrywka['liczbaOsob']);?></span></h6>
                           
                                
                            
                                <?php 
                                $uczestnictwo = checkIfUczestniczy($conn, $rozgrywkiId, $_SESSION['userid']);
                                $liczbaUczestnictw = countUczestnictwo($conn, $rozgrywkiId);
                                $liczbaMiejsc = $rozgrywka['liczbaOsob'];

                                    if($userId == $_SESSION['userid']) {
                                        $rozgrywkaId = $_GET['id'];
                                        echo '<form method="post" action="deleteRozgrywka.php">';
                                        echo '<input type="hidden" name="rozgrywka_id" value='.$rozgrywkaId.'>';
                                        echo '<input type="submit" class="del-btn nav-button-1 nav-text bold buttons" value="Usuń rozgrywkę" style="width: 150px;">';
                                        echo '</form>';
                                    } else if($uczestnictwo) {
                                        echo '<form action="wyjdzinc.php?rozgrywkaId='.$rozgrywkiId.'" method="post" style="margin-top:20px;">';
                                        echo '<input type="submit" class="buy-btn nav-button-1 nav-text bold buttons" value="Opuść" style="width: 150px;">';
                                        echo '</form>';
                                    } else if($liczbaUczestnictw == $liczbaMiejsc) {
                                        echo '<form method="post" style="margin-top:20px;">';
                                        echo '<input type="submit" class="buy-btn nav-button-1 nav-text bold buttons" value="Brak miejsc" style="width: 150px;" disabled>';
                                        echo '</form>';
                                    } else if(!isset($_SESSION["userid"])) {
                                        echo '<form action="login.php" method="post" style="margin-top:20px;">';
                                        echo '<input type="submit" class="buy-btn nav-button-1 nav-text bold buttons" value="Dołącz" style="width: 150px;">';
                                        echo '</form>';
                                    } else {
                                        echo '<form action="rozgrywkainc.php?rozgrywkaId='.$rozgrywkiId.'" method="post" style="margin-top:20px;">';
                                        echo '<input type="submit" class="buy-btn nav-button-1 nav-text bold buttons" value="Dołącz" style="width: 150px;">';
                                        echo '</form>';
                                    }
                                ?>
                                <span id="totalAmountSpan"></span>
                            
                                    <h4 class="mt-5 mb-5">Opis rozgrywki</h4>
                                    <span class="opis"><?php echo($rozgrywka['opis']);?></span>
                                
                            </div>
                        </div>
                    </div>
                <?php include_once("footer.php") ?>

        <script src="../Scripts/main.js" async defer></script>
        <script>
            var MainImg = document.getElementById("MainImg");
            var SmallImg = document.getElementsByClassName("small-img");

            for(let i = 0; i < SmallImg.length; i++) { 
                SmallImg[i].onclick = function() { 
                    MainImg.src = SmallImg[i].src;
                }
            }
        </script>
    </body>
</html>