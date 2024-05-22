<?php 
include_once("panel.php");
/*
Skrzynka nadawcza oraz odbiorcza
 - Wysyłanie wiadomości
 - Odbieranie wiadomości
 - Usuwanie wiadomości
*/
// Sprawdzam, czy nastąpiło przekierowanie GET z ID wiadomości.
if(isset($_GET['wiadomosc']))
{
    czytajWiadomosc($_GET['wiadomosc']);
    $idmessage = $_GET['wiadomosc'];
}
?>
<div class="row d-fles justify-content-center">
    <div class="col-sm-4  formularz-czytanie-wiadomosci">
                    <form>
                    <div class="form-group">
                        <label for="player">Nadawca</label>
                        <input type="text" class="form-control" id="player" name="player" placeholder="<?php 
                        echo $_SESSION['nadawca'];
                        ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="tittle">Tytuł wiadomości</label>
                        <input type="text" class="form-control" id="tittle" name="tittle" placeholder="<?php 
                        echo $_SESSION['tytul'];
                        ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="time">Data i godzina</label>
                        <input type="text" class="form-control" id="time" name="time" placeholder="<?php 
                        echo $_SESSION['czas'];
                        ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="message">Treść wiadomości</label>
                        <textarea class="form-control" id="message" name="message" rows="3" disabled><?php 
                        echo $_SESSION['tresc'];
                        ?></textarea>
                    </div>
                    <div class="row mt-2">
                                <div class="col-lg-6">
                                <a href="wiadomosci.php" class="btn btn-secondary d-flex justify-content-center m-2">Powrót</a>
                                </div>
                                <div class="col-lg-6">
                                    <a href="wiadomosci.php?usun=<?php echo $idmessage; ?>" class="btn btn-danger d-flex justify-content-center m-2">Usuń wiadomość</a>
                                </div>
                                
                    </div>

            </form>
    </div>
</div>
<?php 
// Czyszczenie zmiennych sesyjnych 
unset($_SESSION['nadawca']);
unset($_SESSION['tytul']);
unset($_SESSION['czas']);
unset($_SESSION['tresc']);
?>