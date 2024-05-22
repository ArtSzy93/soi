<?php
// Miejsce pracy dla gracza. Za poświęcony czas otrzymuje złoto. 
include('panel.php');
?>
<div class="container">
<div class="row d-flex justify-content-center mt-3 mr-2">
    <div class="col">
        <span class="d-flex justify-content-center" style="color: gold; font-size: 15px; background-color: rgba(46, 5, 5, 0.36) !important;">
            Energia: <?php echo isset($_SESSION['energy']) ? $_SESSION['energy'] . "/" . $_SESSION['max_energy'] : ''; ?>
        </span>
    </div>
</div>
<div class="row d-flex justify-content-center mt-3 mr-2">
    <div class="col">
        <span class="d-flex justify-content-center" style="color: Snow; font-size: 30px; background-color: rgba(46, 5, 5, 0.5) !important;">
            <?php if(isset($_SESSION['praca'])) {
                echo $_SESSION['praca'];
                unset($_SESSION['praca']);
            }
             ?>
        </span>
    </div>
</div>
<div id="pokaz" class="row mt-2 d-flex justify-content-center">
</div>
<div class="row d-flex justify-content-center">
    <div class="col-md-4">
        <div class="card text-white p-2 h-100 praca">
            <img class="card-img-top" src="images/tartak.jpg" alt="Tartak">
            <div class="card-body d-flex flex-column mt-auto">
                    <h5>Tartak</h2>
                    <p> Ciężka, fizyczna praca w tartaku. Obróbka drewna nie jest prosta czynnością. Możesz jednak podjąć się tej pracy od ręki. Płacimy 20 szt. złota za 1 punkt energii wydany na pracę.</p>
                    <span>Żródło: <a href="https://pl.pinterest.com/pin/98305204352818478/" target="_blank" rel="nofollow">LINK DO ŻRÓDŁA</a>                   
            </div>
            <div class="card-footer mt-auto">
                <p>Ile chcesz pracowac?</p>
                <form name="praca" id="praca-tartak" method="POST" action="include/funkcje.php">
                            <select class="form-control bg-dark text-white " id="czas-pracy-tartak" name="czas-pracy">
                                <option value="1">1 godzina pracy</option>
                                <option value="3">3 godziny pracy</option>
                                <option value="6">6 godzin pracy</option>
                                <option value="12">12 godzin pracy</option>
                            </select>
                     <input type="hidden" name="miejsce" value="w tartaku">
                     <button type="submit" name="praca" class="przyciski-strona-glowna mt-2"> Rozpocznij pracę</button>
                </form>
            </div>
        </div>

    </div>   
    <div class="col-md-4">
        <div class="card text-white p-2 h-100 praca" >
            <img class="card-img-top" src="images/kamieniolom.jpg" alt="Kamieniołom">
            <div class="card-body d-flex flex-column mt-auto">
                    <h5>Kamieniołom</h2>
                    <p>Wejście do kamieniołomu jest otoczone martwymi drzewami o gnijących korzeniach. Wnętrze jaskini jest oświetlone jedynie przez bladą poświatę lodowych stalaktytów, które wydają się roztaczać jeszcze większą ciemność. Praca w tym miejscu jest nie tylko uciążliwa fizycznie, ale także przesiąknięta niepokojem, który wywołują kamienie wydobywane z Ciemnych Wzgórz. Płacimy 20 szt. złota za 1 punkt energii wydany na pracę</p>
                    <span>Żródło: <a href="https://pl.pinterest.com/pin/3025924742146864/" target="_blank" rel="nofollow">LINK DO ŻRÓDŁA</a>
            </div>
            <div class="card-footer mt-auto">
                <p>Ile chcesz pracowac?</p>
                <form name="praca" id="praca-tartak" method="POST" action="include/funkcje.php">
                            <select class="form-control bg-dark text-white " id="czas-pracy-kamieniolom" name="czas-pracy">
                                <option value="1">1 godzina pracy</option>
                                <option value="3">3 godziny pracy</option>
                                <option value="6">6 godzin pracy</option>
                                <option value="12">12 godzin pracy</option>
                            </select>
                    <input type="hidden" name="miejsce" value="w kamieniołomach">
                    <button type="submit" name="praca" class="przyciski-strona-glowna mt-2"> Rozpocznij pracę</button>
                </form>
            </div>
        </div>
    </div>   

    <div class="col-md-4">
        <div class="card text-white p-2 h-100 praca" >
            <img class="card-img-top" src="images/stocznia.jpg" alt="Stocznia">
            <div class="card-body d-flex flex-column">
                    <h5>Stocznia</h2>
                    <p>Stocznia Zaklętego Portu jest otoczona przez wiecznie unoszącą się mgłę, która sprawia, że światło słoneczne dociera tu tylko w rzadkich chwilach. Woda wokół stoczni ma nieziemski, fioletowy odcień, a jej powierzchnia jest spokojna, jakby niesiona przez niewidzialne ręce. Praca w tej stoczni jest pełna tajemnic i niebezpieczeństw. Płacimy 20 szt. złota za 1 punkt energii wydany na pracę</p>      
                    <span>Żródło: <a href="https://i.pinimg.com/originals/b4/b9/87/b4b98767803266c19130f1fe71b1dc5b.jpg" target="_blank" rel="nofollow">LINK DO ŻRÓDŁA</a>
            </div>
            <div class="card-footer mt-auto">
                <p>Ile chcesz pracowac?</p>
                    <form name="praca" id="praca-stocznia" method="POST" action="include/funkcje.php">
                        <select class="form-control bg-dark text-white " id="czas-pracy-stocznia" name="czas-pracy">
                            <option value="1">1 godzina pracy</option>
                            <option value="3">3 godziny pracy</option>
                            <option value="6">6 godzin pracy</option>
                            <option value="12">12 godzin pracy</option>
                        </select>
                     <input type="hidden" name="miejsce" value="w stoczni">
                     <button type="submit" name="praca" class="przyciski-strona-glowna mt-2 "> Rozpocznij pracę</button>
                    </form>
            </div>
        </div>
    </div> 

    <div class="col-md-4 mt-2">
        <div class="card text-white p-2 h-100 praca" >
            <img class="card-img-top" src="images/rybak.jpg" alt="Rybak">
            <div class="card-body d-flex flex-column">
                    <h5>Rybak</h2>
                    <p>Praca u Rybaka to nie tylko połowy ryb i naprawy sieci, ale także pozyskiwanie tajemniczych skarbów i artefaktów, które od czasu do czasu wypłukuje jezioro. Rybak sam w sobie jest postacią enigmatyczną, zawsze opowiadającą historie o mrocznych istotach, które bytują w głębinach jeziora, oraz tajemniczych znikających rybakach, których nigdy już nikt nie widział. Płacimy 20 szt. złota za 1 punkt energii wydany na pracę</p>
            </div>
            <div class="card-footer mt-auto">
                <p>Ile chcesz pracowac?</p>
                    <form name="praca" id="praca-rybak" method="POST" action="include/funkcje.php">
                        <select class="form-control bg-dark text-white " id="czas-pracy-rybak" name="czas-pracy">
                            <option value="1">1 godzina pracy</option>
                            <option value="3">3 godziny pracy</option>
                            <option value="6">6 godzin pracy</option>
                            <option value="12">12 godzin pracy</option>
                        </select>
                        <input type="hidden" name="miejsce" value="u rybaka">
                        <button type="submit" name="praca" class="przyciski-strona-glowna mt-2"> Rozpocznij pracę</button>
                    </form>
            </div>
        </div>
    </div> 
</div>

</div>