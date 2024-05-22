<!DOCTYPE html>
<html lang="pl-PL">
<head>
   <meta charset="UTF-8">
</head>
<?php 
include_once("panel.php"); // Panel górny, nawigacja

if (isset($_POST['wyborPotwora'])) {
    // Wczytanie listy potworów. 
    wczytajPotwory();
    if ($_SESSION['userHp'] <= 0) {
        $_SESSION['komunikat'] = "Twoje zdrowie nie pozwala Ci na dalsze wędrówki. Musisz się uzdrowić!";
        header('Location: przygoda.php');
        exit();
    }
    if ($_SESSION['energy'] <= 0) {
        $_SESSION['komunikat'] = "Zmęczyłeś się. Odpocznij i wróć póżniej!";
        header('Location: przygoda.php');
        exit();
    }
    $tablicaIdPotwora = $_SESSION['monster_ids'];
    // Wylosuj jedno ID potwora z listy
    $losujPotwora = array_rand($tablicaIdPotwora);
    $idPotwora = $tablicaIdPotwora[$losujPotwora];
    echo $idPotwora;
    //Przypisanie wartości sesyjnych gracza do zmiennych na czas walki.
    $idGracza        = $_SESSION['userId'];
    // Wywołanie informacji o aktualnej broni gracza
    uzywanaBron($idGracza);
    $zycieGracza     = $_SESSION['userHp']; 
    $silaGracza      = $_SESSION['userStr'];
    $odpornoscGracza = $_SESSION['userResi'];
    $nazwaBroniGracza      = $_SESSION['weaponName']; 
    $minDmgGracz     = $_SESSION['weaponMinDmg'];
    $maxDmgGracz     = $_SESSION['weaponMaxDmg'];
    // Wybranie wartości potwora z bazy danych
    global $conn; 
    $stmt = $conn ->prepare("SELECT * FROM monster WHERE id = :id");
    $stmt ->bindParam(':id', $idPotwora,PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // Przypisanie wyników do zmiennych lokalnych
    $nazwaPotwora     = $result['name'];
    $opisPotwora      = $result['description'];
    $zyciePotwora     = $result['health'];
    $silaPotwora      = $result['strenght'];
    $odpornoscPotwora = $result['resilience'];
    $minDmgPotwora    = $result['min_dmg'];
    $maxDmgPotwora    = $result['max_dmg'];

    // Losowanie trudności potwora
    $losowanie = rand(1,100);
    if ($losowanie <= 25) {
        // Potwór o normalnych statystykach.
        $poziom = "Łatwy";
    } elseif ($losowanie <= 60) {
        // Potwór silniejszy o 10%
        $poziom = "Średni";
        $zyciePotwora      = round($zyciePotwora * 1.1);
        $silaPotwora       = round($silaPotwora * 1.1);
        $odpornoscPotwora  = round($odpornoscPotwora * 1.1);
        $minDmgPotwora  = round($minDmgPotwora * 1.1);
        $maxDmgPotwora  = round($maxDmgPotwora * 1.1);
    } else {
        // Potwór bardzo silny o 20%
        $poziom = "Trudny";
        $zyciePotwora      = round($zyciePotwora * 1.2);
        $silaPotwora       = round($silaPotwora * 1.2);
        $odpornoscPotwora  = round($odpornoscPotwora * 1.2);
        $minDmgPotwora  = round($minDmgPotwora * 1.2);
        $maxDmgPotwora  = round($maxDmgPotwora * 1.2);
    }
    
    // Losowanie, kto zaczyna walkę
    $pierwszyAtak = rand(0, 1); // 0 oznacza, że potwór zaczyna, 1 oznacza, że gracz zaczyna
    $startWalki = true;
} else {
    header('Location: przygoda.php');
    exit();
}
?>
<span class="d-flex justify-content-center" style="color: green; font-size: 30px;"> Energia: <?php if(isset($_SESSION['energy'])) { echo $_SESSION['energy'] . "/" . $_SESSION['max_energy']; } ?></span>
<div class="row d-flex justify-content-center">
    <div class="col-3 m-2 bg-dark text-white d-flex justify-content-center">
        <a href="przygoda.php"><button class="m-1 btn btn-info" onclik="">Nowa przygoda</button></a>
        <a href="glowna.php"><button class="m-1 btn btn-info" onclik="">Wróć do miasta</button></a>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-3 m-3 bg-dark text-white">
        <h2><?php echo $nazwaPotwora; ?></p></h2>
        <ul>Statystyki
            <li>Życie:      <?php echo $zyciePotwora;?></li>
            <li>Siła:       <?php echo $silaPotwora;?></li>
            <li>Odporność:  <?php echo $odpornoscPotwora;?></li>
            <li>Minimalna siła ataku:  <?php echo $minDmgPotwora;?></li>
            <li>Maksymalna siła ataku:  <?php echo $maxDmgPotwora;?></li>
        </ul>
    </div>

    <div class="col-3 m-3 bg-dark text-white">
        <p>Na Twojej drodze stanął 
        <p>Jego poziom trudności oceniasz na <?php echo $poziom; ?>, ale teraz nie ma to znaczenia. Chwytasz za broń. Za chwilę wszystko się skończy.</p>
        <p>Opis: <br>
        <?php echo $opisPotwora; ?>
    </div>

    <div class="col-3 m-3 bg-dark text-white">
        <h2><?php echo $_SESSION['userName']; ?></p></h2>
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
                echo '<p style="color: blue;">Gracz zaczyna walkę!</p>';
            } else {
                echo '<p style="color: red;">Potwór zaczyna walkę!</p>';
            }
    
            while ($zycieGracza > 0 && $zyciePotwora > 0) {
                if ($pierwszyAtak == 1) {
                    // Gracz atakuje potwora
                    $atakGracza = $silaGracza + rand($minDmgGracz, $maxDmgGracz) - $odpornoscPotwora;
                    // Wyświetlenie informacji o ataku
                    if ($atakGracza < 0) {
                        $atakGracza = 0; // Uniknięcie ujemnych wartości ataku
                        echo '<p style="color: grey;">Słabo.. Potwór wytrzymał Twój atak, nic mu nie zrobileś!</p>';
                    } else { 
                        echo '<p style="color: green;">Gracz atakuje potwora za ' . $atakGracza . ' obrażeń.</p>';
                        $zyciePotwora -= $atakGracza;
                    }
                    
                } else {
                    // Potwór atakuje gracza
                    $atakPotwora = $silaPotwora + rand($minDmgPotwora, $maxDmgPotwora) - $odpornoscGracza;     
                    if ($atakPotwora < 0) {
                        $atakPotwora = 0; 
                        echo "<p>Potwór atakuje, ale nie czyni Ci żadnej krzywdy! </p>";   
                    } else {
                        echo "<p>Potwór atakuje gracza za {$atakPotwora} obrażeń.</p>";   
                        $zycieGracza -= $atakPotwora;
                    }
                    
                }
                
                $pierwszyAtak = 1 - $pierwszyAtak; // Zamiana gracza i potwora jako pierwszego do ataku
                
                if ($zyciePotwora <= 0) {
                    // Gracz wygrał walkę
                    echo '<p style="color: Gold;">Wygrałeś walkę z ' . $nazwaPotwora. '. Truchło leży u Twych stóp. Dobra robota! </p>';
                    ustawZycie($idGracza,$zycieGracza);
                    dodajDoswiadczenie($idGracza,$poziom);
                    odswiezDane($idGracza);
                    $startWalki = false;
                } else if ($zycieGracza <= 0) {
                    // Gracz przegrał walkę
                    echo '<p style="color: red;">Przegrałeś walkę z ' . $nazwaPotwora. '. Twoje ciało pada bez życia! </p>';
                    ustawZycie($idGracza,$zycieGracza);
                    odswiezDane($idGracza);
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
