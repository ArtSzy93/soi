$(document).ready(function() {
    $('#rejestracja').submit(function(e) {
        e.preventDefault();

        var username = $('#username').val();
        var email = $('#email').val();
        var remail = $('#remail').val();
        var password = $('#password').val();
        var repassword = $('#repassword').val();
        if (password.length < 8) {
            pokazInfo("Hasło powinno mieć przynajmniej 8 znaków."); // Wyświetlenie niestandardowego okna modalnego
            return;
        }
        $.ajax({
            type: 'POST',
            url: './rejestracja.php',
            data: {
                username: username,
                email: email,
                remail: remail,
                password: password,
                repassword: repassword
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === "success") {
                    pokazInfo(response.message);
                }  else if (response.status === "error") {
                    pokazInfo(response.message);
                } 
            }, // dodajemy brakującą kropkę przed "error"
            error: function() {
                pokazInfo("Wystąpił błąd podczas komunikacji z serwerem. Spróbuj ponownie później.");
            }
        });
    }); // dodajemy zamykający nawias klamrowy dla funkcji submit

    // Funkcja pokazująca niestandardowe okno modalne
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
});