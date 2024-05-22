<?php
include_once("panel.php");
include_once("include/funkcje.php");
if(($_SESSION['rank'] != "admin") && ($_SESSION['userId'] != 11))
{
    header("Location: glowna.php");
}
/* Plik zawierający wszelkie możliwe opcje dla administratora, które można wykonac z poziomu aplikacje webowej.
Dostep do strony ma tylko user z ranga admin, dodatkowo z ID admina 
Dostepne funkcje:
- Usunięcie gracza
- Zmiana nicku gracza
- Zmiana statystyk gracza


- Dodanie potwora do gry


- Dodanie wpisu do Dziennika Zmian
*/
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <p class="info-dodawania"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <h2 class="text-info" >Dodaj broń</h2>
                <form class="bg-secondary text-warning" id="stworz-bron-form" name="stworz-bron" method="POST">
                <div class="form-group">
                    <label for="weapon-name">Nazwa broni</label>
                    <input type="text" class="form-control" id="weapon-name" name="weapon-name" placeholder="Wpisz nazwę.." required>
                </div>
                <div class="form-group">
                    <label for="weapon-price">Cena: </label>
                    <input type="number" min="1" class="form-control" id="weapon-price" name="weapon-price" placeholder="Podaj cenę broni" required>
                </div>
                <div class="form-group">
                    <label for="weapon-min">Minimalne obrażenia: </label>
                    <input type="number" min="1" class="form-control" id="weapon-min" name="weapon-min" placeholder="Podaj minimalne obrażenia" required>
                </div>
                <div class="form-group">
                    <label for="weapon-max">Maksymalne obrażenia</label>
                    <input type="number" min="1" class="form-control" id="weapon-max" name="weapon-max" placeholder="Podaj maksymalne obrażenia" required>
                </div>
                <input type="hidden" name="weapon">
                <button type="submit" name="stworz-bron" id="stworz-bron-button" class="btn btn-info">Dodaj broń</button>
                <p class="info-dodawania"></p>
            </form>
            </div>
            <div class="col-6 mt-2">
                <h2 class="text-info" >Dodaj potwora</h2>
            <form class="bg-secondary text-warning" id="stworz-potwora-form" name="stworz-potwora" method="POST">
                <div class="form-group">
                    <label for="monster-name">Imię potwora</label>
                    <input type="text" class="form-control" id="monster-name" name="monster-name" placeholder="Wpisz imię potwora" required>
                </div>
                <div class="form-group">
                    <label for="monster-str">Siła</label>
                    <input type="number" min="1" class="form-control" id="monster-str" name="monster-str" placeholder="Podaj siłe potwora" required>
                </div>
                <div class="form-group">
                    <label for="monster-resi">Wytrzymałość</label>
                    <input type="number" min="1" class="form-control" id="monster-resi" name="monster-resi" placeholder="Podaj wytrzymałość potwora" required>
                </div>
                <div class="form-group">
                    <label for="monster-int">Inteligencja</label>
                    <input type="number" min="1" class="form-control" id="monster-int" name="monster-int" placeholder="Podaj inteligencje potwora" required>
                </div>
                <div class="form-group">
                    <label for="monster-hp">Życie</label>
                    <input type="number" min="1" class="form-control" id="monster-hp" name="monster-hp" placeholder="Podaj życie potwora" required>
                </div>
                <div class="form-group">
                    <label for="monster-desc">Życie</label>
                    <input type="textarea" class="form-control" id="monster-desc" name="monster-desc" placeholder="Opis..." >
                </div>
                <input type="hidden" name="monster">
                <button type="submit" name="stworz-potwora" id="stworz-potwora-button" class="btn btn-info">Dodaj</button>
                <p class="info-dodawania"></p>
            </form>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
            <h2 class="text-info">Dodaj Changeloga</h2>
            <form class="bg-secondary text-warning" name="dodaj-changeloga" method="POST"">
                <div class="form-group">
                    <label for="title_log">Nazwa wpisu</label>
                    <input type="text" class="form-control" id="title_log" name="title_log" placeholder="Wpisz tytuł.." required>
                </div>
                <div class="form-group">
                    <label for="log">Treść:</label>
                    <textarea class="form-control" id="log" name="log" placeholder="Wpisz zmiany" required></textarea>
                </div>
                <input type="hidden" name="changelog">
                <button type="submit" name="submit" class="btn btn-info">Dodaj zmiany</button>
                <p class="info-dodawania"></p>
            </form>
            </div>
        </div>
    </div>
<script>

               
$(document).ready(function() {
// Dodawanie potwora do DB
$("#stworz-potwora-button").click(function() {
    var formData = $("#stworz-potwora-form").serialize(); 

    $.ajax({
        type: "POST",
        url: "include/funkcje.php", 
        data: formData,
        success: function(response) {
                if (response === "success") {
                    alert("Sukces");
                } else {
                    $(".info-dodawania").html("<p class='text-danger'>Błąd dodawania potwora!</p>");
                }
            }
        });
    });
});
// Dodawanie broni do DB
$("#stworz-bron-button").click(function() {
    var formData = $("#stworz-bron-form").serialize(); 

    $.ajax({
        type: "POST",
        url: "include/funkcje.php", 
        data: formData,
        success: function(response) {
                if (response === "success") {
                    $(".info-dodawania").html("<p class='text-success'>Broń dodana!</p>");
                } else {
                    $(".info-dodawania").html("<p class='text-danger'>Błąd dodawania broni!</p>");
                }
            }
    });

})
$("#dodaj-changeloga").click(function() {
    var formData = $("#dodaj-changeloga").serialize(); 

    $.ajax({
        type: "POST",
        url: "include/funkcje.php", 
        data: formData,
        success: function(response) {
                if (response === "success") {
                    $(".info-dodawania").html("<p class='text-success'>Zmiany dodane!</p>");
                } else {
                    $(".info-dodawania").html("<p class='text-danger'>Błąd dodawania zmian!</p>");
                }
            }
    });

})
</script>

</body>
</html>

