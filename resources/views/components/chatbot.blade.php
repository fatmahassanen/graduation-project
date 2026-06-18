<style>
    #chatbot-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    #chatbot-toggle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        color: white;
        font-size: 24px;
    }

    #chatbot-toggle:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.4);
    }

    #chatbot-window {
        display: none;
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 380px;
        max-width: 100%;
        height: 550px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        flex-direction: column;
        overflow: hidden;
        animation: slideUp 0.3s ease;
    }

    #chatbot-window.show {
        display: flex;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #chatbot-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 20px 20px 0 0;
        flex-shrink: 0;
    }

    #chatbot-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    #chatbot-close {
        background: transparent;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background 0.3s;
    }

    #chatbot-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    #chatbot-messages {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 20px;
        background: #f8f9fa;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .chatbot-message {
        display: flex;
        gap: 10px;
        animation: fadeIn 0.3s ease;
        max-width: 100%;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chatbot-message.user {
        flex-direction: row-reverse;
    }

    .chatbot-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .chatbot-message.bot .chatbot-avatar {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
    }

    .chatbot-message.user .chatbot-avatar {
        background: #D08301;
        color: white;
    }

    .chatbot-bubble {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 18px;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: pre-wrap;
        line-height: 1.5;
        font-size: 14px;
    }

    .chatbot-message.bot .chatbot-bubble {
        background: white;
        color: #333;
        border-bottom-left-radius: 4px;
    }

    .chatbot-message.user .chatbot-bubble {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }

    #chatbot-input-area {
        padding: 20px;
        background: white;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 10px;
        align-items: flex-end;
        flex-shrink: 0;
    }

    #chatbot-input {
        flex: 1;
        border: 2px solid #e5e7eb;
        border-radius: 20px;
        padding: 12px 20px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.3s;
        resize: none;
        min-height: 45px;
        max-height: 120px;
        overflow-y: auto;
        overflow-x: hidden;
        line-height: 1.5;
        font-family: inherit;
        word-wrap: break-word;
        word-break: break-word;
    }

    #chatbot-input:focus {
        border-color: #1e3c72;
    }

    #chatbot-send {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border: none;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        font-size: 18px;
        flex-shrink: 0;
    }

    #chatbot-send:hover:not(:disabled) {
        transform: scale(1.1);
    }

    #chatbot-send:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .chatbot-typing {
        display: flex;
        gap: 4px;
        padding: 12px 16px;
    }

    .chatbot-typing span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #1e3c72;
        animation: typing 1.4s infinite;
    }

    .chatbot-typing span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .chatbot-typing span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {
        0%, 60%, 100% {
            transform: translateY(0);
            opacity: 0.7;
        }
        30% {
            transform: translateY(-10px);
            opacity: 1;
        }
    }

    /* Mobile Responsiveness */
    @media (max-width: 640px) {
        #chatbot-container {
            bottom: 10px;
            right: 10px;
        }

        #chatbot-window {
            width: calc(100vw - 20px);
            height: 80vh;
            bottom: 10px;
            right: 10px;
            left: 10px;
            max-height: calc(100vh - 100px);
        }

        #chatbot-toggle {
            width: 55px;
            height: 55px;
            font-size: 22px;
        }

        #chatbot-header {
            padding: 15px;
        }

        #chatbot-header h3 {
            font-size: 16px;
        }

        #chatbot-messages {
            padding: 15px;
        }

        .chatbot-bubble {
            max-width: 80%;
            font-size: 13px;
        }

        #chatbot-input-area {
            padding: 15px;
        }

        #chatbot-input {
            font-size: 13px;
            padding: 10px 15px;
        }
    }
</style>

<div id="chatbot-container">
    <button id="chatbot-toggle" aria-label="Toggle Chatbot">
        <i class="fas fa-comment-dots"></i>
    </button>

    <div id="chatbot-window">
        <div id="chatbot-header">
            <h3>🤖 NCTU Assistant</h3>
            <button id="chatbot-close" aria-label="Close Chatbot">&times;</button>
        </div>

        <div id="chatbot-messages">
            <div class="chatbot-message bot">
                <div class="chatbot-avatar">🤖</div>
                <div class="chatbot-bubble">
                    Hello! I'm your NCTU virtual assistant. How can I help you today?
                </div>
            </div>
        </div>

        <div id="chatbot-input-area">
            <textarea 
                id="chatbot-input" 
                placeholder="Type your message..."
                autocomplete="off"
                rows="1"
            ></textarea>
            <button id="chatbot-send" aria-label="Send Message">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotWindow = document.getElementById('chatbot-window');
    const chatbotClose = document.getElementById('chatbot-close');
    const chatbotMessages = document.getElementById('chatbot-messages');
    const chatbotInput = document.getElementById('chatbot-input');
    const chatbotSend = document.getElementById('chatbot-send');

    // Toggle chatbot window
    chatbotToggle.addEventListener('click', () => {
        chatbotWindow.classList.toggle('show');
        if (chatbotWindow.classList.contains('show')) {
            chatbotInput.focus();
        }
    });

    chatbotClose.addEventListener('click', () => {
        chatbotWindow.classList.remove('show');
    });

    // Send message function
    async function sendMessage() {
        const message = chatbotInput.value.trim();
        if (!message) return;

        // Add user message to chat
        addMessage(message, 'user');
        chatbotInput.value = '';
        chatbotInput.style.height = 'auto';
        chatbotSend.disabled = true;

        // Show typing indicator
        const typingIndicator = addTypingIndicator();

        try {
            const response = await fetch('{{ route("chatbot.message") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ message: message }),
            });

            if (!response.ok) {
                const errData = await response.json();
                typingIndicator.remove();
                addMessage('Server Error: ' + (errData.message || 'Status ' + response.status), 'bot');
                chatbotSend.disabled = false;
                return;
            }

            const data = await response.json();

            // Remove typing indicator
            typingIndicator.remove();

            if (data.status === 'success' || data.success) {
                addMessage(data.reply, 'bot');
            } else {
                // Show the exact error message from the server
                addMessage(data.reply || 'Sorry, I encountered an error. Please try again.', 'bot');
            }
        } catch (error) {
            typingIndicator.remove();
            addMessage('JS Client Error: ' + error.message, 'bot');
        }

        chatbotSend.disabled = false;
    }

    // Add message to chat
    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message ${sender}`;

        const avatar = document.createElement('div');
        avatar.className = 'chatbot-avatar';
        avatar.textContent = sender === 'bot' ? '🤖' : '👤';

        const bubble = document.createElement('div');
        bubble.className = 'chatbot-bubble';
        bubble.textContent = text;

        messageDiv.appendChild(avatar);
        messageDiv.appendChild(bubble);
        chatbotMessages.appendChild(messageDiv);

        // Scroll to bottom
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    // Add typing indicator
    function addTypingIndicator() {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'chatbot-message bot';

        const avatar = document.createElement('div');
        avatar.className = 'chatbot-avatar';
        avatar.textContent = '🤖';

        const typingDiv = document.createElement('div');
        typingDiv.className = 'chatbot-typing';
        typingDiv.innerHTML = '<span></span><span></span><span></span>';

        messageDiv.appendChild(avatar);
        messageDiv.appendChild(typingDiv);
        chatbotMessages.appendChild(messageDiv);

        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;

        return messageDiv;
    }

    // Event listeners
    chatbotSend.addEventListener('click', sendMessage);
    chatbotInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Auto-resize textarea
    chatbotInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });
</script>
