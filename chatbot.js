function sendMessage() {
    let userText = document.getElementById("userInput").value;
    let chatbox = document.getElementById("chatbox");

    if (userText.trim() === "") return; // Ignore empty messages

    // Add user message with profile icon
    let userHtml = `
        <div class="user-message">
            <div class="userText">
                <span>${userText}</span>
            </div>
            <i class="bi bi-person-circle profile-icon"></i>
        </div>
    `;
    chatbox.innerHTML += userHtml;
    chatbox.scrollTop = chatbox.scrollHeight; // Auto-scroll to latest message

    fetch("chatbot.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: userText })
    })
    .then(response => response.json())
    .then(data => {
        let botResponse = data.response;
        let botHtml = `
            <div class="bot-message">
                <i class="bi bi-robot profile-icon"></i>
                <div class="botText">
                    <span>${botResponse}</span>
                </div>
            </div>
        `;
        chatbox.innerHTML += botHtml;
        chatbox.scrollTop = chatbox.scrollHeight; // Auto-scroll to latest message
        document.getElementById("userInput").value = "";
    })
    .catch(error => console.error("Error:", error));
}

function handleKeyPress(event) {
    if (event.key === "Enter") {
        sendMessage();
    }
}





