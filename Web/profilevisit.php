<div class="container profileContainer">
  <main>
    <div class="row infoRow">
      <div class="left col-lg-4">
        <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  
                          <?php
                          echo "<img src='".$userInfo['profile_pic']."' alt='".$userInfo['nazwa_uzytkownika']."' class='rounded-circle' onclick=\"document.getElementById('fileToUpload').click(); document.getElementById('btn-submit').disabled = false;\"/>";
                          ?>
                </div>
              </div>
            </div>
            <div class="infoBox">
              <h4 class="name"><?php echo($userInfo['imie']." ".$userInfo['nazwisko']);?></h4>
              <p class="info"><?php echo($userInfo['email']);?></p>
              <div class="stats row">
                <div class="stat col-xs-4" style="padding-right: 50px;">
                  <p class="number-stat"><?php 
                          require_once("dbh.php");
                          require_once("functionsinc.php");

                          $liczbaRozgrywek = getLiczbaRozgrywekUzytkownika($conn, $_GET["id"]);
                          echo $liczbaRozgrywek;
                        ?></p>
                  <p class="desc-stat">Liczba rozgrywek</p>
                </div>
                <div class="stat col-xs-4">
                  <p class="number-stat"><?php 
                          require_once("dbh.php");
                          require_once("functionsinc.php");

                          $liczbaOfert = getLiczbaOfertUzytkownika($conn, $_GET["id"]);
                          echo $liczbaOfert;
                        ?></p>
                  <p class="desc-stat">Liczba ofert</p>
                </div>
                <div class="stat col-xs-4" style="padding-left: 50px;">
                  <p class="number-stat"><?php 
                          require_once("dbh.php");
                          require_once("functionsinc.php");

                          $liczbaWypozyczen = getLiczbaWypozyczenUzytkownika($conn, $_GET["id"]);
                          echo $liczbaWypozyczen;
                        ?></p>
                  <p class="desc-stat">Wypożyczane rzeczy</p>
                </div>
              </div>
              <p class="desc"><?php echo($userInfo['opis']);?></p>
            </div>
        
      </div>
      </div>
      <div class="right col-lg-8">
        <ul class="nav">
          <?php 
              error_reporting(E_ERROR | E_PARSE); // Wyłącza wyświetlanie ostrzeżeń i notatek
          $userId = $_GET["id"];
          $link = $_GET['link'];

          if($link == 'rozgrywki') {
            echo '<a href="../Web/profile.php?id='.$userId.'"><li>Oferty</li></a>';
            echo '<a href="../Web/profile.php?id='.$userId.'&link=rozgrywki"><li style="border-bottom: 2px solid #999;">Rozgrywki</li></a>';
          } else {
            echo '<a href="../Web/profile.php?id='.$userId.'"><li style="border-bottom: 2px solid #999;">Oferty</li></a>';
            echo '<a href="../Web/profile.php?id='.$userId.'&link=rozgrywki"><li>Rozgrywki</li></a>';
          }
          ?>
          
        </ul>
        <div class="row gallery">
            <?php
                error_reporting(E_ERROR | E_PARSE); // Wyłącza wyświetlanie ostrzeżeń i notatek
              require_once("dbh.php");
              require_once("functionsinc.php");

              if($_GET['link'] == 'rozgrywki') {
                // Sprawdzenie, czy są jakieś rozgrywki
          $rozgrywki = getRozgrywkiByUzytkownik($conn, $userId);
          if ($rozgrywki) {
            foreach ($rozgrywki as $rozgrywka) {
              $rozgrywkaId = $rozgrywka['rozgrywkiId'];
              // Pobranie zdjęcia dla danej rozgrywki
              $zdjecia = getZdjecieRozgrywki($conn, $rozgrywkaId);
              $imagePath = "../Images/Rozgrywki/" . $zdjecia[0]['nazwa_pliku'];
              // Wyświetlenie linku do strony rozgrywki wraz z jej danymi
              echo '<a href="../Web/rozgrywka.php?id=' . $rozgrywkaId . '">';
              echo '<div class="offer">';
              echo '<div class="image-wrapper">';
              echo '<img src="' . $imagePath . '" alt="' . $rozgrywka["nazwa"] . '">';
              echo '</div>';
              echo '<h3>' . $rozgrywka["nazwa"] . '</h3>';
              echo '<p>Data: ' . $rozgrywka["dataRozgrywki"] . '</p>';
              echo '</div>';
              echo '</a>';

            }
          } else {
            // Komunikat w przypadku braku rozgrywek
            echo '<p>Brak rozgrywek do wyświetlenia.</p>';
          }
              } else {
                 // Sprawdzenie, czy są jakieś oferty
            $oferty = getOfertyByUzytkownik($conn, $profileUserId);
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
                // Komunikat w przypadku braku ofert
                echo '<p>Brak ofert do wyświetlenia.</p>';
            }
              }
            
           
            ?>
        </div>
      </div>
    
  </main>
</div>