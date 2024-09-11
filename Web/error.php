<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GearUp Rentals - Error</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../Styles/main.css">
    </head>
    <body> 
                <?php include_once("header.php");?>
                <div class="content" style="display: flex; justify-content: center; margin: 100px 0 ;">
                    <?php 
                        $dostepnosc = $_GET["dostepnosc"];
                        if($dostepnosc == "false") {
                            echo "<h1>Ta oferta jest aktualnie wynajmowana.</h1>";
                        } else {
                            echo "<h1>Error 404 - Ta strona jest już nie dostępna</h1>";
                        }
                    ?>
                </div>
                <?php include_once("footer.php") ?>
            </div>
        </div>

        <script src="../Scripts/main.js" async defer></script>
    </body>
</html>