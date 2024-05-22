<?php 
include("panel.php");
// Miejsce do sprawdzenia ważnych informacji. Lista gracz. ogłoszenia użytkowniów.
?>
<div class="container">
    <div class="row">
        <div class="col-md-5 tlo-divow m-2 p-2">
            <p>
            Ratusz emanuje aurą tajemniczości i potęgi. Zbudowany jest głównie z masywnego, czarnego drewna o ciężkim, gotyckim stylu architektonicznym.
            Wysokie wieże i mury ratusza wydają się być wyrzeźbione z samej nocy, a ich strzeliste kształty przyciągają uwagę, 
            przywodząc na myśl obraz zamku strzeżonego przez potężnego władcę. </p>
            <p>
            Wejście do ratusza jest monumentalne, z wielkimi, ciężkimi drzwiami wykonanymi z rdzawego żelaza, które 
            prowadzą do przedsionka oświetlonego jedynie przez trzęsawą pochodnię. Wnętrza ratusza są jeszcze bardziej mroczne - długie
             korytarze wyłożone kamiennymi posadzkami prowadzą do surowych, drewnianych drzwi, za którymi kryją się komnaty spisów i ogłoszeń.
            </p>
            <p>
            Wewnątrz ratusza panuje ponura atmosfera, a sufity zdobią mroczne malowidła przedstawiające mityczne bestie i sceny walki. 
            W komnatach spisów mieszczą się samotnie skryci w długich płaszczach urzędnicy, notujący każdego mieszkańca miasta, 
            a ogłoszenia przyczepione są do ścian w postaci pergaminów z pieczęciami. Ciemne, drewniane meble oraz świeczniki o płonącym, 
            błękitnym ogniu dodają wnętrzom ratusza mrocznego uroku, a dźwięk piszczałki w oddali przypomina o nieustającym pośpiechu i tajemniczych intrygach miasta.
            </p>
            <p>
        </div>
        <div class="col-md-6 tlo-divow m-2 p-2 d-flex justify-content-center">
            <img src="images/ratusz.jpg" alt="Ratusz" width="500" height="500">
        </div>
    </div>
    <?php
                if(isset($_SESSION['komunikat']))
                {   echo '<div class="row d-flex justify-content-center">';
                    echo '<p class="col-4 bg-light">'.$_SESSION['komunikat'].'</p>';
                    unset($_SESSION['komunikat']);
                    echo '</div>';
                }
        ?>
    <div class="row d-flex justify-content-center m-2">
        <div id="formularz-dodawania" class="col-6 d-none tlo-divow">
                <form class="border-0" action="include/funkcje.php" method="POST" name="ogloszenie">
                <h2>Dodaj ogłoszenie</h2>
                <span>Kosz to 2000 szt. złota. Ogłoszenie ważne jest 7 dni.</span>
                <div class="form-group m-2">
                    <label for="title_adv">Nazwa ogłoszenia</label>
                    <input type="text" class="form-control bg-dark text-white border-bottom-0" id="title_adv" name="title_adv" placeholder="Wpisz tytuł.." required>
                </div>
                <div class="form-group m-2">
                    <label for="text_adv">Treść:</label>
                    <textarea class="form-control bg-dark text-white border-bottom-0" id="text_adv" name="text_adv" placeholder="Wpisz treść ogłoszenia" required></textarea>
                </div>
                <input type="hidden" name="adv">
                <button type="submit" name="submit" class="btn btn-info">Dodaj ogłoszenie</button>
                
                </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 tlo-divow m-2 p-2" style="max-height:500px; overflow-y: scroll;">
        <input type="text" style="background-color: rgba(46, 5, 5, 0.46); border: none;" class="mt-2 form-control text-white" id="znajdzGracza" autocomplete="off" placeholder="Szukaj..">
            <h2 class="d-flex justify-content-center text-white">Lista graczy</h2>
            <div id="lista-graczy" class="text-white">
                <?php listaGraczy(); ?>
            </div>
        </div>
        <div class="col-md-4 tlo-divow m-1 ">
            <p>
                <button id="pokaz-div" class="mt-1 przyciski-strona-glowna">Dodaj ogłoszenie</button>
            </p>
            <h2>Ostatnie ogłoszenia</h2>
            <div id="lista-ogloszen">
                <div class="ogloszenie">
                    <?php
                    listaOgloszen()
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="js/ratusz.js"></script>