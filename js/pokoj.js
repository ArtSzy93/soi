function displayMessage(sender, message) {
    const chatBox = document.getElementById("pokoj-chat-box");
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
        const roomId = "<?php echo $_GET['id']; ?>";
        sendMessage(userName, userId, roomId);
    }
});

function sendMessage() {
    const messageInput = document.getElementById("message-input");
    const message = messageInput.value;

    // Wysłanie wiadomości na serwer za pomocą AJAX i przekazanie zmiennych sesji
    fetch("./include/pokoj-dodaj-wiadomosc.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "sender=" + encodeURIComponent(userName) + "&message=" + encodeURIComponent(message) +"&room=" + encodeURIComponent(roomId),
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
    const roomId = new URLSearchParams(window.location.search).get("id");
    if (!roomId) {
        console.error("Brak ID pokoju.");
        return;
    }

    fetch(`./include/pokoj-wczytaj-wiadomosci.php?id=${roomId}`)
        .then(response => response.json())
        .then(data => {
            const chatBox  = document.getElementById("pokoj-chat-box");
            const roomName = document.getElementById("room-name");
            chatBox.innerHTML = ""; // Wyczyszczenie czata przed dodaniem nowych wiadomości

            // Sprawdź, czy data zawiera informację o nazwie pokoju
             if (data.length > 0 && data[0].room_name) {
            roomName.textContent = `"${data[0].room_name}"`;
        }
            
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