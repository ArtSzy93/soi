<?php 
include_once("panel.php"); // Panel górny, nawigacja

if (isset($_POST['wyborGracza'])) {
    // Wczytanie listy potworów. 
    wczytajPotwory();
    if ($_SESSION['userHp'] <= 0) {
        $_SESSION['komunikat'] = "Twoje zdrowie nie pozwala Ci na walkę. Musisz się uzdrowić!";
        header('Location: arena.php');
        exit();
    }
    if ($_SESSION['energy'] <= 0) {
        $_SESSION['komunikat'] = "Zmęczyłeś się. Odpocznij i wróć póżniej!";
        header('Location: arena.php');
        exit();
    }
    $idPrzeciwnika = $_POST['wyborGracza'];
    //Przypisanie wartości sesyjnych graczy do zmiennych na czas walki.
    $idGracza        = $_SESSION['userId'];
    if($idPrzeciwnika === $idGracza){
        $_SESSION['komunikat'] = "Nie można zaatakować samego siebie!";
        header('Location: arena.php');
        exit();
    }
    // Wywołanie informacji o aktualnej broni gracza
    uzywanaBron($idGracza);
    $zycieGracza     = $_SESSION['userHp']; 
    $silaGracza      = $_SESSION['userStr'];
    $odpornoscGracza = $_SESSION['userResi']; 
    $nazwaBroniGracza      = $_SESSION['weaponName']; 
    $minDmgGracz     = $_SESSION['weaponMinDmg'];
    $maxDmgGracz     = $_SESSION['weaponMaxDmg'];
    // Wybranie wartości przeciwnika z DB
    global $conn; 
    $stmt = $conn->prepare("SELECT * FROM users_stats INNER JOIN users ON users.id = users_stats.user_id WHERE user_id = :id");
    $stmt->bindParam(':id', $idPrzeciwnika, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Przypisanie statystyk postaci przeciwnika do zmiennych lokalnych
        $nickPrzeciwnika = $result['username'];
        $zyciePrzeciwnika = $result['health'];
        $awatarPrzeciwnika = $result['image'];
        // Jeżeli przeciwnik martwy - nie rozpoczynamy walki.
        if($zyciePrzeciwnika === 0)
        {
            $_SESSION['komunikat'] = "Ten przeciwnik nieźyje, Znajdź innego!";
            header('Location: arena.php');
            exit();
        }
        $silaPrzeciwnika = $result['strength'];
        $odpornoscPrzeciwnika = $result['resilience'];
    } else {
        $_SESSION['komunikat'] = "Gracz o podanym numerze nieistnieje!";
        header('Location: arena.php');
        exit();
    }

    // Przypisanie wartości ataku broni przeciwnika
    $aktywna = 1;
    $stmt = $conn->prepare("SELECT * FROM users_weapons INNER JOIN weapon ON users_weapons.weapon_id = weapon.id WHERE users_weapons.user_id = :id AND active = :active");
    $stmt->bindParam(':id', $idPrzeciwnika, PDO::PARAM_INT);
    $stmt->bindParam(':active', $aktywna, PDO::PARAM_INT);
    $stmt->execute();
    $resultBron = $stmt->fetch(PDO::FETCH_ASSOC); // Pobierz wynik zapytania dotyczącego broni

    if ($resultBron) {
        $bronPrzeciwnika = $resultBron['name'] . '(' . $resultBron['pseudoname'] . ') ';
        $minDmgPrzeciwnika = $resultBron['min_dmg'];
        $maxDmgPrzeciwnika = $resultBron['max_dmg'];
    } else {
        $bronPrzeciwnika = "Gołę Recę";
        $minDmgPrzeciwnika = 1;
        $maxDmgPrzeciwnika = 2;
    }
    // Losowanie, kto zaczyna walkę
    $pierwszyAtak = rand(0, 1); // 0 oznacza, że potwór zaczyna, 1 oznacza, że gracz zaczyna
    $startWalki = true;
} else {
    header('Location: arena.php');
    exit();
}
?>
<span class="d-flex justify-content-center" style="color: green; font-size: 30px;"> Energia: <?php if(isset($_SESSION['energy'])) { echo $_SESSION['energy'] . "/" . $_SESSION['max_energy']; } ?></span>
<div class="row d-flex justify-content-center">
    <div class="col-3 m-2 bg-dark text-white d-flex justify-content-center">
        <a href="arena.php"><button class="m-1 btn btn-info" onclik="">Wróć na arenę</button></a>
        <a href="glowna.php"><button class="m-1 btn btn-info" onclik="">Wróć do miasta</button></a>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-3 m-3 bg-dark text-white">
        <h2><?php echo $nickPrzeciwnika; ?></p></h2>
        <img src="<?php echo $awatarPrzeciwnika; ?>" alt="Portret gracza" class="portrait">
        <ul>Statystyki
            <li>Życie:      <?php echo $zyciePrzeciwnika;?></li>
            <li>Siła:       <?php echo $silaPrzeciwnika;?></li>
            <li>Odporność:  <?php echo $odpornoscPrzeciwnika;?></li>
            <li>Broń:  <?php echo $bronPrzeciwnika;?></li>
            <li>Minimalna siła ataku:  <?php echo $minDmgPrzeciwnika;?></li>
            <li>Maksymalna siła ataku:  <?php echo $maxDmgPrzeciwnika;?></li>
        </ul>
    </div>

    <div class="col-3 m-3 bg-dark text-white">
        <p>Rzucasz wyzwanie swojemu przeciwnikowi. Tylko jeden z Was wróci żywy do miasta.
    </div>

    <div class="col-3 m-3 bg-dark text-white">
        <h2><?php echo $_SESSION['userName']; ?></p></h2>
        <img src="<?php echo $_SESSION['awatar']; ?>" alt="Portret gracza" class="portrait">
        <ul>Statystyki
            <li>Życie:      <?php echo $zycieGracza;?></li>
            <li>Siła:       <?php echo $silaGracza;?></li>
            <li>Odporność:  <?php echo $odpornoscGracza;?></li>
            <li>Broń:       <?php echo $nazwaBroniGracza;?></li>
            <li>Minimalna siła ataku:  <?php echo $minDmgGracz;?></li>
            <li>Maksymalna siła ataku:  <?php echo $maxDmgGracz;?></li>
        </ul>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-3 m-3 bg-dark text-white">
        <h2>Przebieg walki</h2>
        <?php 
        // Rozpoczęcie walki
        if ($startWalki) {
            // Odjęcie 1 punktu energi za akcje.
            zabierzEnergie($idGracza);
            
            if ($pierwszyAtak == 1) {
                echo '<p style="color: blue;">'.$_SESSION['userName'].' zaczyna walkę!</p>';
            } else {
                echo '<p style="color: red;">'. $nickPrzeciwnika.' zaczyna walkę!</p>';
            }
    
            while ($zycieGracza > 0 && $zyciePrzeciwnika > 0) {
                if ($pierwszyAtak == 1) {
                    // Gracz atakuje przeciwnika
                    $atakGracza = $silaGracza + rand($minDmgGracz, $maxDmgGracz) - $odpornoscPrzeciwnika;
                    // Wyświetlenie informacji o ataku
                    if ($atakGracza < 0) {
                        $atakGracza = 0; // Uniknięcie ujemnych wartości ataku
                        echo '<p style="color: grey;">Słabo.. Przeciwnik wytrzymuje Twój atak bez draśnięcia!</p>';
                    } else { 
                        echo '<p style="color: green;">'.$_SESSION['userName'].' atakuje ' .$nickPrzeciwnika . ' i zadaje '. $atakGracza.' obrażeń.</p>';
                        $zyciePrzeciwnika -= $atakGracza;
                    }
                } else {
                    // Przeciwnik atakuje gracza
                    $atakPrzeciwnika = $silaPrzeciwnika + rand($minDmgPrzeciwnika, $maxDmgPrzeciwnika) - $odpornoscGracza;     
                    if ($atakPrzeciwnika < 0) {
                        $atakPrzeciwnika = 0; 
                        echo "<p>".$nickPrzeciwnika." wyprowadza cios, ale nie czyni Ci żadnych obrażeń! </p>";   
                    } else {
                        echo '<p>'.$nickPrzeciwnika.' atakuje ' .$_SESSION['userName']. ' i zadaje '. $atakPrzeciwnika.' obrażeń.</p>';
                        $zycieGracza -= $atakPrzeciwnika;
                    }
                    
                }
                
                $pierwszyAtak = 1 - $pierwszyAtak; // Zamiana kolejności ataku
                
                if ($zyciePrzeciwnika <= 0) {
                    // Gracz wygrał walkę
                    echo '<p style="color: Gold;">Wygrałeś walkę z ' . $nickPrzeciwnika. '. Przeciwnik kona i walka jest skończona </p>';
                    ustawZycie($idGracza,$zycieGracza);
                    ustawZycie($idPrzeciwnika,$zyciePrzeciwnika);
                    dodajDoswiadczenie($idGracza,"Gracz");
                
                    $startWalki = false;
                } else if ($zycieGracza <= 0) {
                    // Gracz przegrał walkę
                    echo '<p style="color: red;">Przegrałeś walkę z ' . $nickPrzeciwnika. '. Twoje ciało pada bez życia! </p>';
                    ustawZycie($idGracza,$zycieGracza);
                    ustawZycie($idPrzeciwnika,$zyciePrzeciwnika);
                    
                    $startWalki = false;
                }
            }
        }
        ?>
        <p>
        <?php 
        if(isset($_SESSION['komunikat']))
        {
            echo '<p>'.$_SESSION['komunikat'] .'</p>';
            unset($_SESSION['komunikat']);
        }
        ?>
        </p>
    </div>
</div>
