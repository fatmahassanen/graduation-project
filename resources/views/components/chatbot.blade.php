<style>
    #chatbot-container {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    /* ── Toggle Button ── */
    #chatbot-toggle {
        width: 62px;
        height: 62px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%);
        border: none;
        box-shadow: 0 6px 24px rgba(26,58,110,0.45);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        color: white;
        font-size: 26px;
        position: relative;
    }

    #chatbot-toggle:hover {
        transform: scale(1.1) translateY(-2px);
        box-shadow: 0 10px 32px rgba(26,58,110,0.55);
    }

    /* Pulse ring */
    #chatbot-toggle::before {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 2px solid rgba(208,131,1,0.6);
        animation: chatPulse 2.5s ease infinite;
    }

    @keyframes chatPulse {
        0%, 100% { transform: scale(1);    opacity: 0.8; }
        50%       { transform: scale(1.15); opacity: 0; }
    }

    /* ── Chat Window ── */
    #chatbot-window {
        display: none;
        position: fixed;
        bottom: 100px;
        right: 24px;
        width: 370px;
        max-width: calc(100vw - 30px);
        height: 540px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 16px 50px rgba(26,58,110,0.22);
        flex-direction: column;
        overflow: hidden;
        animation: slideUp 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 1px solid rgba(26,58,110,0.08);
    }

    #chatbot-window.show { display: flex; }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(24px) scale(0.96); }
        to   { opacity: 1; transform: translateY(0)   scale(1); }
    }

    /* ── Header ── */
    #chatbot-header {
        background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%);
        color: white;
        padding: 18px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 20px 20px 0 0;
        flex-shrink: 0;
    }

    .chatbot-header-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chatbot-header-avatar {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        border: 2px solid rgba(255,255,255,0.3);
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .chatbot-header-text h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #fff;
    }

    .chatbot-header-text p {
        margin: 0;
        font-size: 0.72rem;
        color: rgba(255,255,255,0.7);
    }

    .chatbot-online-dot {
        width: 8px; height: 8px;
        background: #4ade80;
        border-radius: 50%;
        display: inline-block;
        margin-right: 4px;
        box-shadow: 0 0 0 2px rgba(74,222,128,0.3);
    }

    #chatbot-close {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        font-size: 20px;
        cursor: pointer;
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
        transition: background 0.2s;
    }

    #chatbot-close:hover { background: rgba(255,255,255,0.25); }

    /* ── Messages Area ── */
    #chatbot-messages {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 18px 16px;
        background: #f4f7fc;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    #chatbot-messages::-webkit-scrollbar { width: 4px; }
    #chatbot-messages::-webkit-scrollbar-track { background: transparent; }
    #chatbot-messages::-webkit-scrollbar-thumb { background: rgba(26,58,110,0.2); border-radius: 4px; }

    .chatbot-message {
        display: flex;
        gap: 8px;
        animation: fadeIn 0.3s ease;
        max-width: 100%;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .chatbot-message.user { flex-direction: row-reverse; }

    .chatbot-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .chatbot-message.bot  .chatbot-avatar {
        background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%);
        color: white;
    }
    .chatbot-message.user .chatbot-avatar {
        background: #D08301;
        color: white;
    }

    .chatbot-bubble {
        max-width: 72%;
        padding: 10px 14px;
        border-radius: 16px;
        word-wrap: break-word;
        word-break: break-word;
        white-space: pre-wrap;
        line-height: 1.55;
        font-size: 0.88rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    }

    .chatbot-message.bot  .chatbot-bubble {
        background: white;
        color: #333;
        border-bottom-left-radius: 4px;
    }
    .chatbot-message.user .chatbot-bubble {
        background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }

    /* ── Input Area ── */
    #chatbot-input-area {
        padding: 14px 16px;
        background: white;
        border-top: 1px solid #eef2f7;
        display: flex;
        gap: 10px;
        align-items: flex-end;
        flex-shrink: 0;
    }

    #chatbot-input {
        flex: 1;
        border: 2px solid #e5e9f2;
        border-radius: 20px;
        padding: 10px 18px;
        font-size: 0.88rem;
        outline: none;
        transition: border-color 0.3s;
        resize: none;
        min-height: 42px;
        max-height: 110px;
        overflow-y: auto;
        line-height: 1.5;
        font-family: inherit;
        background: #f8faff;
    }

    #chatbot-input:focus {
        border-color: #1a3a6e;
        background: #fff;
    }

    #chatbot-send {
        width: 42px; height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%);
        border: none;
        color: white;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.3s;
        font-size: 16px;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(26,58,110,0.3);
    }

    #chatbot-send:hover:not(:disabled) {
        transform: scale(1.1);
        box-shadow: 0 5px 16px rgba(26,58,110,0.4);
    }

    #chatbot-send:disabled { opacity: 0.5; cursor: not-allowed; }

    /* ── Typing indicator ── */
    .chatbot-typing {
        display: flex;
        gap: 4px;
        padding: 10px 14px;
        background: white;
        border-radius: 16px;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    }

    .chatbot-typing span {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #1a3a6e;
        animation: typing 1.4s infinite;
    }

    .chatbot-typing span:nth-child(2) { animation-delay: 0.2s; }
    .chatbot-typing span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0);     opacity: 0.5; }
        30%           { transform: translateY(-8px);  opacity: 1; }
    }

    /* ── Mobile ── */
    @media (max-width: 640px) {
        #chatbot-container { bottom: 12px; right: 12px; }
        #chatbot-window {
            width: calc(100vw - 24px);
            height: 78vh;
            bottom: 12px; right: 12px; left: 12px;
            max-height: calc(100vh - 90px);
        }
        #chatbot-toggle { width: 56px; height: 56px; font-size: 22px; }
        .chatbot-bubble { max-width: 80%; }
    }
</style>

<div id="chatbot-container">
    <button id="chatbot-toggle" aria-label="Toggle Chatbot">
        <i class="fas fa-comment-dots"></i>
    </button>

    <div id="chatbot-window">
        <div id="chatbot-header">
            <div class="chatbot-header-info">
                <div class="chatbot-header-avatar">🤖</div>
                <div class="chatbot-header-text">
                    <h3>NCTU Assistant</h3>
                    <p><span class="chatbot-online-dot"></span>Online — Ready to help</p>
                </div>
            </div>
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
