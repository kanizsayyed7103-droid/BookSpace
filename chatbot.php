<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace AI Chatbot</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #a18cd1;
        margin: 0;
        padding-top: 70px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* Chat Container */
    .chatbot-wrapper {
        padding: 20px;
        flex-grow: 1;
        width: 100%;
    }

    .chat-container {
        max-width: 900px;
        margin: auto;
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        height: calc(100vh - 150px);
        min-height: 450px;
    }

    /* Messages */
    .message {
        max-width: 75%;
        padding: 0.75rem 1.25rem;
        border-radius: 1.25rem;
        margin-bottom: 0.8rem;
        line-height: 1.5;
    }

    .user-message {
        background-color: #6f42c1;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 0.3rem;
    }

    .ai-message {
        background-color: #f0f0f0;
        color: #333;
        align-self: flex-start;
        border-bottom-left-radius: 0.3rem;
    }

    .error-message {
        background-color: #ffe0e0;
        color: #c676f0ff;
        border-left: 5px solid #c676f0ff;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        max-width: 85%;
        align-self: flex-start;
    }

    .message-history {
        flex-grow: 1;
        padding: 1.5rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    /* Send button */
    .btn-send {
        background-color: #6f42c1;
        color: white;
        border-radius: 0.75rem;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-send:hover {
        background-color: #5935a4;
    }

    /* Typing dots */
    .dot {
        height: 8px;
        width: 8px;
        background-color: #b899f1;
        border-radius: 50%;
        display: inline-block;
        margin: 0 2px;
        opacity: 0;
        animation: dot-fade 1.5s infinite ease-in-out;
    }

    .dot:nth-child(1) {
        animation-delay: 0s;
    }

    .dot:nth-child(2) {
        animation-delay: 0.5s;
    }

    .dot:nth-child(3) {
        animation-delay: 1s;
    }

    @keyframes dot-fade {

        0%,
        80%,
        100% {
            opacity: 0;
            transform: translateY(0);
        }

        40% {
            opacity: 1;
            transform: translateY(-5px);
        }
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="chatbot-wrapper text-center">
        <h2 class="fw-bold mb-4" style="color:#6f42c1;">
            Ask <span style="color:#3a2d5c;">BookSpace AI</span>
        </h2>

        <div class="chat-container">

            <!-- Message Area -->
            <div id="message-history" class="message-history">
                <div class="ai-message message">
                    Hello! I'm your BookSpace AI Assistant. I can help you find book recommendations, author facts, or
                    explain
                    literary concepts. Ask me anything!
                </div>

                <!-- Typing indicator -->
                <div id="typing-indicator" class="ai-message message d-none">
                    <span class="dot"></span><span class="dot"></span><span class="dot"></span>
                </div>
            </div>

            <!-- Input -->
            <form id="chat-form" class="p-3 border-top bg-white">
                <div class="input-group">
                    <input type="text" id="user-input" class="form-control rounded-pill px-3"
                        placeholder="Type your message here..." required>
                    <button type="submit" id="send-button" class="btn btn-send ms-2" disabled>
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    const apiKey = "YAIzaSyA6IYaleLMwVFMIQGXiuDSqv4kbT0DlmFI"; // 🔹 Replace with your real API key
    const apiUrl =
        `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}`;

    const messageHistoryDiv = document.getElementById("message-history");
    const chatForm = document.getElementById("chat-form");
    const userInput = document.getElementById("user-input");
    const sendButton = document.getElementById("send-button");
    const typingIndicator = document.getElementById("typing-indicator");

    let chatHistory = [];

    userInput.addEventListener("input", () => {
        sendButton.disabled = userInput.value.trim() === "";
    });

    function scrollToBottom() {
        messageHistoryDiv.scrollTop = messageHistoryDiv.scrollHeight;
    }

    function addMessage(text, sender) {
        const div = document.createElement("div");
        div.className = sender === "user" ? "user-message message" :
            sender === "error" ? "error-message" : "ai-message message";
        div.innerHTML = text;
        messageHistoryDiv.appendChild(div);
        scrollToBottom();
        return div;
    }

    async function typeMessage(text, target) {
        let i = 0;
        target.innerHTML = "";
        const speed = 15;
        return new Promise(resolve => {
            function typing() {
                if (i < text.length) {
                    target.innerHTML += text.charAt(i) === "\n" ? "<br>" : text.charAt(i);
                    i++;
                    scrollToBottom();
                    setTimeout(typing, speed);
                } else resolve();
            }
            typing();
        });
    }

    async function callGemini(prompt) {
        typingIndicator.classList.remove("d-none");
        scrollToBottom();

        try {
            const payload = {
                contents: [...chatHistory, {
                    role: "user",
                    parts: [{
                        text: prompt
                    }]
                }]
            };

            const res = await fetch(apiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            });

            typingIndicator.classList.add("d-none");

            if (!res.ok) throw new Error(`API error: ${res.status}`);

            const data = await res.json();
            const candidate = data.candidates?. [0]?.content?.parts?. [0]?.text ||
                "Sorry, I didn't understand that.";

            chatHistory.push({
                role: "user",
                parts: [{
                    text: prompt
                }]
            });
            chatHistory.push({
                role: "model",
                parts: [{
                    text: candidate
                }]
            });

            const bubble = addMessage("", "ai");
            await typeMessage(candidate, bubble);

        } catch (err) {
            typingIndicator.classList.add("d-none");
            addMessage("⚠️ Connection error. Please try again.", "error");
            console.error(err);
        }
    }

    chatForm.addEventListener("submit", e => {
        e.preventDefault();
        const prompt = userInput.value.trim();
        if (!prompt) return;
        addMessage(prompt, "user");
        userInput.value = "";
        sendButton.disabled = true;
        callGemini(prompt);
    });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>