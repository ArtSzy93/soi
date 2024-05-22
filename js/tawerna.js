function displayMessage(sender, message) {
    const chatBox = document.getElementById("tawerna-chat-box");
    const messageDiv = document.createElement("div");
    const currentDate = new Date();
    const currentHour = currentDate.getHours();
    const currentMinutes = currentDate.getMinutes();
    const formattedMinutes = String(currentMinutes).padStart(2, '0');
    messageDiv.textContent = `${currentHour}:${formattedMinutes} ${sender}(${userId}): ${message}`;
    chatBox.appendChild(messageDiv);
}
// Odbierz zdarzenie klawisza Enter w polu tekstowym
document.getElementById("message-input").addEventListener("keyup", function(event) {
    if (event.key === "Enter") {
        const userName = "<?php echo $_SESSION['userName']; ?>";
        const userId = "<?php echo $_SESSION['userId']; ?>";
        sendMessage(userName, userId);
    }
});

function sendMessage() {
    const messageInput = document.getElementById("message-input");
    const message = messageInput.value;

    // Wysłanie wiadomości na serwer za pomocą AJAX i przekazanie zmiennych sesji
    fetch("./include/tawerna-dodaj-wiadomosc.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "sender=" + encodeURIComponent(userName) + "&message=" + encodeURIComponent(message),
    })
        .then(response => response.json())
        .then(data => {
            displayMessage(data.sender, data.message);
            messageInput.value = "";
        })
        .catch(error => console.error("Błąd podczas wysyłania wiadomości:", error));
}
function formatTime(timestamp) {
    const date = new Date(timestamp);
    const hours = date.getHours();
    const minutes = date.getMinutes();
    return `${hours}:${minutes < 10 ? '0' : ''}${minutes}`;
}

function loadMessages() {
    fetch("./include/tawerna-wczytaj-wiadomosci.php")
        .then(response => response.json())
        .then(data => {
            const chatBox = document.getElementById("tawerna-chat-box");
            chatBox.innerHTML = ""; // Wyczyszczenie czata przed dodaniem nowych wiadomości
            
            data.forEach(message => {
                const messageDiv = document.createElement("div");
                const formattedTime = formatTime(message.time);
                messageDiv.textContent = `${formattedTime} ${message.sender}(${message.user_id}): ${message.message}`;
                chatBox.appendChild(messageDiv);
            });
        })
        .catch(error => console.error("Błąd podczas wczytywania wiadomości:", error));
}

// Wywołujemy funkcję wczytującą wiadomości po załadowaniu strony
document.addEventListener("DOMContentLoaded", loadMessages);
setInterval(loadMessages, 10000);