<?php 
        error_reporting(E_ERROR | E_PARSE); // Wyłącza wyświetlanie ostrzeżeń i notatek
        session_start();
        $isUserLoggedIn = isset($_SESSION["userid"]);

        if(!$isUserLoggedIn) {
            header("Location: login.php");
        }
        ?>
 <!-- Header -->
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(https://raw.githubusercontent.com/creativetimofficial/argon-dashboard/gh-pages/assets-old/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          <div class="col-lg-7 col-md-10">
            <h1 class="display-2 text-white">Cześć <?php echo($userInfo['imie']); ?></h1>
            <p class="text-white mt-0 mb-5">To jest twój profil tu możesz edytować swoje dane i zobaczyć co inni wiedzą o tobie</p>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <form action="uploadImage.php" method="post" enctype="multipart/form-data">
                      <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" style="display: none;">
                          <?php
                          echo "<img src='".$userInfo['profile_pic']."' alt='".$userInfo['nazwa_uzytkownika']."' class='rounded-circle' onclick=\"document.getElementById('fileToUpload').click(); document.getElementById('btn-submit').disabled = false;\"/>";
                          ?>
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
            </div>
            <div class="card-body pt-0 pt-md-4">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                    <div>
                      <span class="heading"><?php 
                          require_once("dbh.php");
                          require_once("functionsinc.php");

                          $liczbaRozgrywek = getLiczbaRozgrywekUzytkownika($conn, $_GET["id"]);
                          echo $liczbaRozgrywek;
                        ?></span>
                      <span class="description">Liczba rozgrywek</span>
                    </div>
                    <div>
                      <span class="heading">
                        <?php 
                          require_once("dbh.php");
                          require_once("functionsinc.php");

                          $liczbaOfert = getLiczbaOfertUzytkownika($conn, $_SESSION["userid"]);
                          echo $liczbaOfert;
                        ?>
                      </span>
                      <span class="description">Oferty</span>
                    </div>
                    <div>
                      <span class="heading"><?php 
                          require_once("dbh.php");
                          require_once("functionsinc.php");

                          $liczbaWypozyczen = getLiczbaWypozyczenUzytkownika($conn, $_SESSION["userid"]);
                          echo $liczbaWypozyczen;
                        ?></span>
                      <span class="description">Wypożyczane rzeczy</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <h3>
                  <?php 
                  echo($userInfo['imie']. " ". $userInfo['nazwisko']);
                  ?>
                </h3>
                <div class="h5 font-weight-300">
                  <i class="ni location_pin mr-2"></i><?php echo($userInfo['miasto']. ", ". $userInfo['kraj']); ?>
                </div>
                <hr class="my-4">
                <p><?php echo($userInfo['opis']); ?></p>
                <input type="submit" href="#!" class="btn btn-info" id="btn-submit" value="Zatwierdź" disabled>
              </form>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Moje konto</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form action="profileinc.php" method="post">
                <h6 class="heading-small text-muted mb-4">Informacje o tobie</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-username">Nazwa użytkownika</label>
                        <input type="text" id="input-username" class="form-control form-control-alternative" name="username" placeholder="Nazwa użytkownika" value="<?php echo($userInfo['nazwa_uzytkownika']); ?>" disabled>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">E-mail</label>
                        <input type="email" id="input-email" class="form-control form-control-alternative" name="email" placeholder="E-mail" value="<?php echo($userInfo['email']); ?>" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-first-name">Imie</label>
                        <input type="text" id="input-first-name" class="form-control form-control-alternative" name="firstName" placeholder="Imie" value="<?php echo($userInfo['imie']); ?>">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-last-name">Nazwisko</label>
                        <input type="text" id="input-last-name" class="form-control form-control-alternative" name="lastName" placeholder="Nazwisko" value="<?php echo($userInfo['nazwisko']); ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4">
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Informacje kontaktowe</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-number">Numer telefonu</label>
                        <input id="input-number" class="form-control form-control-alternative" name="phoneNumber" placeholder="Numer telefonu" value="<?php echo($userInfo['numer_telefonu']); ?>" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-city">Miasto</label>
                        <input type="text" id="input-city" class="form-control form-control-alternative" name="city" placeholder="Miasto" value="<?php echo($userInfo['miasto']); ?>">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-country">Kraj</label>
                        <input type="text" id="input-country" class="form-control form-control-alternative" name="country" placeholder="Kraj" value="<?php echo($userInfo['kraj']); ?>">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Kod pocztowy</label>
                        <input type="text" id="input-postal-code" class="form-control form-control-alternative" name="postalCode" placeholder="Kod pocztowy" value="<?php echo($userInfo['kod_pocztowy']); ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4">
                <!-- Description -->
                <h6 class="heading-small text-muted mb-4">O mnie</h6>
                <div class="pl-lg-4">
                  <div class="form-group focused">
                    <label>O mnie</label>
                    <textarea rows="4" class="form-control form-control-alternative" placeholder="Parę słów o mnie..." name="description"><?php echo($userInfo['opis']); ?></textarea>
                  </div>
                </div>
                <div class="btn-group">
                  <input type="submit" href="#!" class="btn btn-info">
                  <a href="../Web/logoutinc.php" class="btn btn-logout">Wyloguj się</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>