<?php 
include('panel.php');
// Wyświetlanie czatu prywatnego pokoju. Pisanie wiadomości i czytanie poprzednich
if(!isset($_GET['id'])) {
    header('Location: pokoje.php');
}
// Sprawdzam czy pokój istnieje oraz czy gracz ma do niego uprawnienia. 
$result = sprawdzUprawnieniaPokoju($_SESSION['userId'], $_GET['id']);
if(!$result)
{
    $_SESSION['komunikat'] = "Pokój nie istnieje lub nie posiadasz zaproszenia do udziału!";
    header('Location: pokoje.php');
}
// Zaproszenie gracza do pokoju
if(isset($_POST['user-id']))
{
    zaprosUsunDoPokoju($_POST['user-id'], $_POST['room-id'], $_POST['tryb']);
}
?>
<div class="container">
    <?php 
    if(isset($_SESSION['komunikat']))
    {
        ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                <?php echo $_SESSION['komunikat'] ; ?>
                </div>
            </div>
        <?php
        unset($_SESSION['komunikat']);
    }


    ?>
    <div class="row d-flex justify-content-center">
        <div class="col-5 p-2 m-3 bg-dark text-white">   
            <p>Witamy w pokoju <span id="room-name"></span></p> 
            <p>Gracze przypisani do pokoju:</p>
            <?php graczeWPokoju($_GET['id'])?>
        </div>
        <!--Dodawanie gracza do pokoju -->
        <div class="col-3 p-2 mt-3 bg-dark text-white ">   
            <p>Zaproś gracza o ID: </p>
            <form method="POST" action="">
                <div class="form-group">
                    <input type="number" min="1" class="form-control" id="user-id" name="user-id" placeholder="Wprowadż numer">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="room-id" name="room-id" value="<?php echo $_GET['id'];?>">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="tryb" name="tryb" value="1">
                </div>
                <div class="form-group d-flex justify-content-center">
                    <button type="submit" class="m-2 btn btn-primary">Zaproś</button>
                </div>
            </form>
        </div>
    </div>
<div class="row d-flex justify-content-center">
    <div class="col-md-6 d-flex justify-content-cente ">
        <div id="pokoj-glowny">
            <div id="pokoj-chat-box">   
            </div>
        </div>
    </div>
            <!--Dodawanie gracza do pokoju -->
            <div class="col-2 p-2 mt-3 text-white">   
            <p>Usuń gracza o ID: </p>
            <form method="POST" action="">
                <div class="form-group">
                    <input type="number" min="1" class="form-control" id="user-id" name="user-id" placeholder="Wprowadż numer">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="room-id" name="room-id" value="<?php echo $_GET['id'];?>">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="tryb" name="tryb" value="2">
                </div>
                <div class="form-group d-flex justify-content-center">
                    <button type="submit" class="m-2 btn btn-danger">Usuń</button>
                </div>
            </form>
        </div>
</div>   
<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="wiadomosc">
        <input type="text" id="message-input" placeholder="Wpisz wiadomość">
            <button onclick="sendMessage('<?php echo $_SESSION['userName']; ?>(<?php echo $_SESSION['userId']; ?>)')">Wyślij</button>
        </div>
    </div>
</div>


<script src="js/pokoj.js"></script>
<script>
    var userName = "<?php echo $_SESSION['userName']; ?>";
    var userId = "<?php echo $_SESSION['userId']; ?>";
    var roomId = "<?php echo $_GET['id']; ?>";
</script>
</div>