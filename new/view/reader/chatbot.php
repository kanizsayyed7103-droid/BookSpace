<?php
require_once('../../controller/db/database.php');
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpace | AI Reading Assistant</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Cinzel+Decorative:wght@700&display=swap"
        rel="stylesheet">

    <style>
    :root {
        --color-deep-purple: #3a2d5c;
        --color-lavender: #a18cd1;
        --color-dusty-pink: #fbc2eb;
        --color-text: #2c2c2c;
        --color-light-text: #f0f0f0;
        --color-highlight: #51407d;
    }

    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: var(--color-lavender);
        color: var(--color-text);
    }

    .chat-container {
        max-width: 950px;
        margin: 40px auto;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: 0.3s ease-in-out;
    }

    .chat-header {
        background: linear-gradient(90deg, #835ed9ff, #8551d7ff);
        color: #fff;
        padding: 18px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'Cinzel Decorative', cursive;
        font-size: 1.2rem;
        letter-spacing: 0.5px;
    }

    .clear-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #fff;
        padding: 8px 14px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .clear-btn:hover {
        background: rgba(255, 255, 255, 0.35);
        transform: scale(1.05);
    }

    .chat-box {
        flex: 1;
        padding: 25px;
        overflow-y: auto;
        height: 500px;
        background-color: #faf9fe;
        scroll-behavior: smooth;
    }

    .chat-message {
        display: flex;
        margin-bottom: 15px;
        opacity: 0;
        animation: fadeInUp 0.4s ease forwards;
    }

    .user {
        justify-content: flex-end;
    }

    .bot {
        justify-content: flex-start;
    }

    .bubble {
        padding: 14px 18px;
        border-radius: 18px;
        max-width: 70%;
        line-height: 1.5;
        word-wrap: break-word;
        font-size: 15px;
        animation: slideIn 0.3s ease;
    }

    .user .bubble {
        background: linear-gradient(90deg, #6b46c1, #805ad5);
        color: #fff;
        border-bottom-right-radius: 4px;
    }

    .bot .bubble {
        background: #f2f2f6;
        color: #222;
        border-bottom-left-radius: 4px;
    }

    .chat-input {
        display: flex;
        border-top: 1px solid #eee;
        background: #f8f7fc;
    }

    .chat-input input {
        flex: 1;
        border: none;
        outline: none;
        padding: 15px;
        font-size: 15px;
        background: none;
    }

    .chat-input button {
        background: linear-gradient(90deg, #6b46c1, #805ad5);
        border: none;
        color: #fff;
        padding: 15px 25px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .chat-input button:hover {
        background: linear-gradient(90deg, #7b2ff7, #9d4edd);
    }

    .book-card {
        display: flex;
        align-items: center;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-top: 10px;
        overflow: hidden;
        max-width: 400px;
    }

    .book-card img {
        width: 90px;
        height: 120px;
        object-fit: cover;
    }

    .book-info {
        padding: 10px 15px;
    }

    .book-info h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #4a3c8a;
    }

    .book-info p {
        margin: 3px 0;
        font-size: 13px;
        color: #555;
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(10px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            transform: scale(0.95);
            opacity: 0.8;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="chat-container">
        <div class="chat-header">
            BookSpace AI Assistant
            <button id="clear-btn" class="clear-btn" title="Clear the conversation"> Clear</button>
        </div>

        <div id="chat-box" class="chat-box"></div>

        <div class="chat-input">
            <input id="user-input" type="text" placeholder="Ask me for book suggestions, summaries, or authors...">
            <button id="send-btn">Send</button>
        </div>
    </div>

    <script>
    const chatBox = document.getElementById("chat-box");
    const userInput = document.getElementById("user-input");
    const sendBtn = document.getElementById("send-btn");
    const clearBtn = document.getElementById("clear-btn");

    // Load chat history from localStorage
    window.onload = function() {
        const history = localStorage.getItem("chatHistory");
        if (history) {
            chatBox.innerHTML = history;
        } else {
            chatBox.innerHTML = `
                    <div class="chat-message bot">
                        <div class="bubble">👋 Hello, reader! I'm your BookSpace AI Assistant. Ask me for recommendations, summaries, or book details!</div>
                    </div>`;
        }
        chatBox.scrollTop = chatBox.scrollHeight;
    };

    sendBtn.addEventListener("click", sendMessage);
    userInput.addEventListener("keypress", e => {
        if (e.key === "Enter") sendMessage();
    });
    clearBtn.addEventListener("click", clearChat);

    async function sendMessage() {
        const message = userInput.value.trim();
        if (!message) return;

        appendMessage("user", message);
        userInput.value = "";

        appendMessage("bot", "⏳ Thinking...");

        try {
            const response = await fetch("../../controller/ai_handler.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    message
                })
            });

            const data = await response.json();
            chatBox.lastElementChild.remove();
            appendMessage("bot", data.reply || "Sorry, something went wrong.");
            if (data.book && data.book.title) appendBook(data.book);
        } catch (error) {
            chatBox.lastElementChild.remove();
            appendMessage("bot", "⚠️ Sorry, I ran into an issue. Please try again.");
        }

        saveChatHistory();
    }

    function appendMessage(sender, text) {
        const msg = document.createElement("div");
        msg.className = `chat-message ${sender}`;
        msg.innerHTML = `<div class="bubble">${text}</div>`;
        chatBox.appendChild(msg);
        chatBox.scrollTop = chatBox.scrollHeight;
        saveChatHistory();
    }

    function appendBook(book) {
        const bookCard = document.createElement("div");
        bookCard.className = "book-card";
        bookCard.innerHTML = `
                <img src="${book.cover}" alt="Book Cover">
                <div class="book-info">
                    <h4>${book.title}</h4>
                    <p>By ${book.author}</p>
                    <p>⭐ Rating: ${book.rating}</p>
                </div>`;
        const msg = document.createElement("div");
        msg.className = "chat-message bot";
        msg.appendChild(bookCard);
        chatBox.appendChild(msg);
        chatBox.scrollTop = chatBox.scrollHeight;
        saveChatHistory();
    }

    function saveChatHistory() {
        localStorage.setItem("chatHistory", chatBox.innerHTML);
    }

    function clearChat() {
        if (confirm("Do you really want to clear the chat history?")) {
            chatBox.innerHTML = `
                    <div class="chat-message bot">
                        <div class="bubble"> Chat cleared! How can I assist you next?</div>
                    </div>`;
            localStorage.removeItem("chatHistory");
        }
    }
    </script>
</body>

</html>