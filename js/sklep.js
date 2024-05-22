function obslugaZakupu(wynik) {
    if (wynik === 1) {
        pokazInfo("Nie masz wystarczającej ilości pieniędzy.");
    } else if (wynik === 2) {
        pokazInfo("Zakup udany!");
    } else if (wynik === 3) {
        pokazInfo("Masz już tę broń.");
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