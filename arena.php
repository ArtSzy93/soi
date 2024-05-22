<?php 
include("panel.php");
wczytajGraczy();
$tablicaGraczy = $_SESSION['players_id'];
// Wylosuj jedno ID potwora z listy
if($tablicaGraczy > 0) {
    $losujGracza = array_rand($tablicaGraczy);
    $gracz1 = $tablicaGraczy[$losujGracza];
    $losujGracza = array_rand($tablicaGraczy);
    $gracz2 = $tablicaGraczy[$losujGracza];
    $losujGracza = array_rand($tablicaGraczy);
    $gracz3 = $tablicaGraczy[$losujGracza];
}

?>

<div class="row mt-2 d-flex justify-content-center">
    <div class="col-5 d-flex justify-content-center bg-danger text-warning">
                <?php 
                if(isset($_SESSION['komunikat']))
                {
                    echo '<p>'.$_SESSION['komunikat'] .'</p>';
                    unset($_SESSION['komunikat']);
                }
                ?>
    </div>
</div>
<div class="row mt-2 d-flex justify-content-center">
            <div class="col-3 tlo-divow p-2">
            <h2 class="text-white d-flex justify-content-center">Zaatakuj gracza o ID</h2>
                <form class="text-warning" name="wyborGracza" method="POST" action="pojedynek.php">
                    <div class="form-group">
                        <input type="number" class="form-control" id="id_przeciwnika" name="wyborGracza" placeholder="Wpisz ID.." required>
                    </div>
                    <button type="submit" name="submit" class="p-2 m-1 przyciski-strona-glowna">Zaatakuj gracza</button>
                </form>
            </div>
</div>
<?php 
if($tablicaGraczy > 0) {
?>
<div class="row mt-2 d-flex justify-content-center">
    <div class="col-3 d-flex justify-content-center text-warning">
    <div class="card text-white p-2" style="width: 25rem;">
            <img class="card-img-top" src="images/przeciwnik.jpg" alt="Tajemniczy Przeciwnik">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title d-flex justify-content-center">Tajemniczy przeciwnik</h5>
                <p class="card-text">Wyjdź na arene i zawalcz z tajemniczym przeciwnikiem..</p>
                <form class="bg-secondary text-warning" name="wyborGracza" method="POST" action="pojedynek.php">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_przeciwnika" name="wyborGracza" value="<?php echo $gracz1; ?>">
                    </div>
                    <button type="submit" name="submit" class="przyciski-strona-glowna">Walcz</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-3 d-flex justify-content-center text-warning">
    <div class="card text-white p-2" style="width: 25rem;">
            <img class="card-img-top" src="images/przeciwnik.jpg" alt="Tajemniczy Przeciwnik">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title d-flex justify-content-center">Tajemniczy przeciwnik</h5>
                <p class="card-text">Wyjdź na arene i zawalcz z tajemniczym przeciwnikiem..</p>
                <form class="bg-secondary text-warning" name="wyborGracza" method="POST" action="pojedynek.php">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_przeciwnika" name="wyborGracza" value="<?php echo $gracz2; ?>">
                    </div>
                    <button type="submit" name="submit" class="przyciski-strona-glowna">Walcz</button>
                </form>
            </div>
        </div>
    </div>


    <div class="col-3 d-flex justify-content-center text-warning">
    <div class="card text-white p-2" style="width: 25rem;">
            <img class="card-img-top" src="images/przeciwnik.jpg" alt="Tajemniczy Przeciwnik">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title d-flex justify-content-center">Tajemniczy przeciwnik</h5>
                <p class="card-text">Wyjdź na arene i zawalcz z tajemniczym przeciwnikiem..</p>
                <form class="bg-secondary text-warning" name="wyborGracza" method="POST" action="pojedynek.php">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_przeciwnika" name="wyborGracza" value="<?php echo $gracz3; ?>">
                    </div>
                    <button type="submit" name="submit" class="przyciski-strona-glowna">Walcz</button>
                </form>
            </div>
        </div>
    </div>

<?php 
} else {

?>

<div class="col-3 d-flex justify-content-center text-warning">
<p>Aktualnie brak przeciwników! Spróbuj póżniej!</p>
</div>

<?php 
}
?>

</div>