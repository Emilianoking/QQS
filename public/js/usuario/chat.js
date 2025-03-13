'use strict';

const chatMessages = document.getElementById('chat-messages');
const chatInput = document.getElementById('chat-input');
const chatSend = document.getElementById('chat-send');

function addMessage(content, isUser = false) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', isUser ? 'user-message' : 'bot-message');
    messageDiv.textContent = content;
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

async function sendMessageToAPI(message) {
    try {
        const response = await fetch('/xai', {  // Usa '/api/xai' para api.php
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (data.error) {
            addMessage(`Error: ${data.error}`, false);
        } else {
            const botReply = data.choices[0].message.content;
            addMessage(botReply, false);
        }
    } catch (error) {
        addMessage(`Error: ${error.message}`, false);
    }
}

chatSend.addEventListener('click', () => {
    const message = chatInput.value.trim();
    if (message) {
        addMessage(message, true);
        sendMessageToAPI(message);
        chatInput.value = '';
    }
});

chatInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter' && chatInput.value.trim()) {
        chatSend.click();
    }
});

addMessage('¡Hola! Soy Grok, creado por xAI. ¿En qué puedo ayudarte?', false);