document.addEventListener("DOMContentLoaded", function() {
    const selectElement = document.getElementById("wyborPotwora");
    const infoDiv = document.getElementById("informacjePotwora");

    selectElement.addEventListener("change", function() {
        const selectedValue = selectElement.value;

        fetch(`./include/funkcje.php?potworId=${selectedValue}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    infoDiv.innerHTML = "<p></p>";
                } else {
                    infoDiv.innerHTML = `<p>Nazwa: ${data.name}</p><p>
                    Opis: ${data.description}</p>`;
                }
            })
            .catch(error => {
                console.error("Błąd pobierania danych:", error);
            });
    });
});