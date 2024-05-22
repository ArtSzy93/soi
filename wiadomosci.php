<?php 
include_once("panel.php");
/*
Skrzynka nadawcza oraz odbiorcza
 - Wysyłanie wiadomości
 - Odbieranie wiadomości
 - Usuwanie wiadomości
*/

$userid = $_SESSION['userId'];
// Wywołanie funkcji usuwania wiadomości z bazy danych
if(isset($_GET['usun'])) {
    usunWiadomosc($_GET['usun']);
}

?>
<div class="container text-light">
    <h1>Prywatne wiadomości</h1>

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
    <!-- Sekcja wysyłania wiadomości -->
    <div class="row">
        <div class="col">
        
            <form method="POST" action="include/funkcje.php">
                    <div class="form-group">
                        <label for="player">Nick lub ID gracza: </label>
                        <input type="text" class="bg-dark text-white form-control" id="player" name="player" placeholder="Wpisz tutaj nick lub ID gracza">
                    </div>
                    <div class="form-group">
                        <label for="tittle">Tytuł wiadomości: </label>
                        <input type="text" class="bg-dark text-white form-control" id="tittle" name="tittle" placeholder="Wpisz tytuł wiadomości">
                    </div>
                    <div class="form-group">
                        <label for="message">Treść wiadomości: </label>
                        <textarea class="bg-dark text-white form-control" id="message" name="message" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                    <div class="d-flex justify-content-center mt-2">
                        <button type="submit" class="text-white przyciski-strona-glowna">Wyślij wiadomość</button>
                    </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h2>Skrzynka odbiorcza</h2>
            <table class="table table-hover table-dark ml-0">
              <thead>
               <tr>
                  <th scope="col">Data</th>
                  <th scope="col">Nadawca</th>
                  <th scope="col">Tytuł</th>
                  <th scope="col">Akcja</th>
                </tr>
              </thead>
            <tbody class="skrzynka-odbiorcza-tabelka">
                  <?php 
                    wyswietlWiadomosci($_SESSION['userId']);
                  ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

