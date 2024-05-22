$(document).ready(function() {

    $("#znajdzGracza").keyup(function() {
        var szukaj = $(this).val();

        $.ajax({
            url: "./include/funkcje.php",
            method: "POST",
            data: { szukaj: szukaj },

            success: function(data) {
                $("#lista-graczy").html(data);
            }
        });

    });
});
// Sterowanie pokazywaniem diva w ratuszu z ogłoszeniami
$(document).ready(function() {
    $("#pokaz-div").click(function() {
        if ($("#formularz-dodawania").is(":visible")) {
            $("#formularz-dodawania").addClass("d-none");
        } else {
            $("#formularz-dodawania").removeClass("d-none");
        }
    });
});