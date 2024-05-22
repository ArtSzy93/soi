function zakladanie(wynik) {
    if (wynik === 1) {
        pokazInfo("Broń założona!");
        setTimeout(function() {
            window.location.href = "ekwipunek.php";
        }, 2000);
    } else if (wynik === 2) {
        pokazInfo("Broń NIE założona!");
        setTimeout(function() {
            window.location.href = "ekwipunek.php";
        }, 2000);
    }
}

function pokazInfo(message) {
        var modal = document.getElementById("okno-modalne");
        var modalMessage = document.getElementById("okno-wiadomosc");
        modalMessage.innerHTML = message;
        modal.style.display = "block";

        // Dodaj obsługę zamykania okna modalnego po kliknięciu na ikonę zamknięcia (x)
        var closeBtn = document.getElementsByClassName("zamknij")[0];
        closeBtn.onclick = function() {
            modal.style.display = "none";
        };

        // Dodaj obsługę zamykania okna modalnego po kliknięciu poza nim
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    }

