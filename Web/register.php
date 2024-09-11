<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GearUp Rentals - Zarejestruj się</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
        <link rel="stylesheet" href="../Styles/main.css">
        <link rel="stylesheet" href="../Styles/login.css">
    </head>
    <body> 
                <?php include_once("header.php");?>
                <div class="content">
                    <div class="login-page">
                        <div class="login-text">
                            <h2>Zarejestruj się</h2>
                            <p>Masz konto? <a class="register-text" href="../Web/login.php">Zaloguj się</a></p>
                        </div>
                        <div class="login-social">
                            <ul class="social-login-nav">
                                <li class="social-login-list">
                                    <svg width="32" height="32" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="social-logo">
                                        <path d="M22.5005 12.7331C22.5005 11.8698 22.4291 11.2398 22.2744 10.5864H12.2148V14.483H18.1196C18.0006 15.4514 17.3577 16.9097 15.9291 17.8897L15.9091 18.0202L19.0897 20.4349L19.3101 20.4564C21.3338 18.6247 22.5005 15.9297 22.5005 12.7331Z" fill="#4285F4"/>
                                        <path d="M12.214 23.0001C15.1068 23.0001 17.5353 22.0667 19.3092 20.4567L15.9282 17.89C15.0235 18.5083 13.8092 18.94 12.214 18.94C9.38069 18.94 6.97596 17.1083 6.11874 14.5767L5.99309 14.5871L2.68583 17.0955L2.64258 17.2133C4.40446 20.6433 8.0235 23.0001 12.214 23.0001Z" fill="#34A853"/>
                                        <path d="M6.12095 14.5767C5.89476 13.9234 5.76386 13.2233 5.76386 12.5C5.76386 11.7767 5.89476 11.0767 6.10905 10.4234L6.10306 10.2842L2.75435 7.7356L2.64478 7.78667C1.91862 9.21002 1.50195 10.8084 1.50195 12.5C1.50195 14.1917 1.91862 15.79 2.64478 17.2133L6.12095 14.5767Z" fill="#FBBC05"/>
                                        <path d="M12.2141 6.05997C14.2259 6.05997 15.583 6.91163 16.3569 7.62335L19.3807 4.73C17.5236 3.03834 15.1069 2 12.2141 2C8.02353 2 4.40447 4.35665 2.64258 7.78662L6.10686 10.4233C6.97598 7.89166 9.38073 6.05997 12.2141 6.05997Z" fill="#EB4335"/>
                                    </svg>
                                    <p>Zarejestruj się przez Google</p>
                                </li>
                                <li class="social-login-list">
                                    <svg width="36" height="36" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg" class="social-logo">
                                        <circle cx="16" cy="16.5" r="14" fill="#0C82EE"/>
                                        <path d="M21.2137 20.7816L21.8356 16.8301H17.9452V14.267C17.9452 13.1857 18.4877 12.1311 20.2302 12.1311H22V8.76699C22 8.76699 20.3945 8.5 18.8603 8.5C15.6548 8.5 13.5617 10.3929 13.5617 13.8184V16.8301H10V20.7816H13.5617V30.3345C14.2767 30.444 15.0082 30.5 15.7534 30.5C16.4986 30.5 17.2302 30.444 17.9452 30.3345V20.7816H21.2137Z" fill="white"/>
                                    </svg>
                                    <p>Zarejestruj się przez Facebook</p>
                                </li>
                            </ul>
                        </div>
                        <div class="divider-register">
                            <div class="divider1-register"></div>
                            Lub zarejestruj się przez E-mail
                            <div class="divider2-register"></div>
                        </div>
                        <div class="login-box">
                            <form action="registerinc.php" method="post">
                                <label for="user-input">Nazwa użytkownika</label><br>
                                <input type="text" name="username" id="user-input" class="required" onkeyup="enableSubmit()"><br>
                                <label for="user-input">E-mail</label><br>
                                <input type="text" name="email" id="user-input" class="required" onkeyup="enableSubmit()"><br>
                                <div class="password-box">
                                    <label for="password-input" class="password-label">Hasło</label>
                                        <div class="show-password-box" onclick="showPassword()">
                                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20.0189 4.88109L19.283 4.14515C19.075 3.93716 18.691 3.96917 18.451 4.25711L15.8908 6.80108C14.7388 6.30514 13.4749 6.06514 12.1468 6.06514C8.1947 6.08107 4.77092 8.38504 3.1228 11.6973C3.02677 11.9052 3.02677 12.1612 3.1228 12.3372C3.89073 13.9052 5.04281 15.2012 6.48281 16.1772L4.38682 18.3051C4.14682 18.5451 4.11481 18.9291 4.27485 19.1371L5.0108 19.8731C5.21879 20.081 5.60277 20.049 5.84277 19.7611L19.8907 5.71321C20.1947 5.47334 20.2267 5.08938 20.0187 4.88137L20.0189 4.88109ZM12.9948 9.71298C12.7228 9.64896 12.4349 9.56901 12.1628 9.56901C10.8028 9.56901 9.71489 10.657 9.71489 12.0169C9.71489 12.2889 9.77891 12.5769 9.85887 12.8489L8.78675 13.9049C8.4668 13.345 8.29081 12.7209 8.29081 12.017C8.29081 9.88899 10.0028 8.17697 12.1308 8.17697C12.8349 8.17697 13.4588 8.35295 14.0188 8.67291L12.9948 9.71298Z" fill="#666666" fill-opacity="0.8"/>
                                                    <path d="M21.1714 11.6974C20.6114 10.5774 19.8753 9.56945 18.9634 8.75342L15.9874 11.6974V12.0174C15.9874 14.1454 14.2754 15.8574 12.1474 15.8574H11.8274L9.93945 17.7454C10.6435 17.8893 11.3795 17.9854 12.0995 17.9854C16.0516 17.9854 19.4754 15.6814 21.1235 12.3532C21.2675 12.1292 21.2675 11.9053 21.1714 11.6973L21.1714 11.6974Z" fill="#666666" fill-opacity="0.8"/>
                                                </svg>
                                            <span>Pokaż</span>
                                        </div>
                                </div>
                                <input type="password" name="password" id="password-input" onkeyup="enableSubmit()" class="required" minlength="8"><br>
                                <p class="password-text">Użyj co najmniej 8 znaków używając liter, liczb oraz symboli</p>

                                <h4>Wybierz swoją płeć<span class="optional"> (opcjonalne)</span></h4>
                                <div class="gender-box">
                                    <input type="radio" name="gender" id="female-radio" value="female">
                                    <label for="female-radio" class="gender-label">Kobieta</label><br>
                                    <input type="radio" name="gender" id="male-radio" value="male">
                                    <label for="male-radio" class="gender-label">Mężczyzna</label>
                                    <input type="radio" name="gender" id="nonBinary-radio" value="nonbinary">
                                    <label for="nonBinary-radio" class="gender-label">Non-Binary</label>
                                </div>
                                <div class="g-recaptcha" data-sitekey="6Lc2G58pAAAAAAAS3ru7cu50rFkQGIPlD-XnQ8PX" data-action="LOGIN"></div>
                                <div class="registerBtn">
                                    <input type="submit" name="submit" value="Zarejestruj się" class="login-register-btn" disabled>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include_once("footer.php") ?>
            </div>
        </div>

        <script src="../Scripts/main.js" async defer></script>
    </body>
</html>