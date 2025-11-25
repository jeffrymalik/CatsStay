// ===================================
// MESSAGES - JAVASCRIPT
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    // Initialize chat if we're on chat page
    if (document.getElementById('messagesArea')) {
        initializeChat();
    }
});

// ===================================
// CHAT INITIALIZATION
// ===================================

function initializeChat() {
    const messagesArea = document.getElementById('messagesArea');
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const scrollToBottomBtn = document.getElementById('scrollToBottom');

    // Scroll to bottom on page load
    scrollToBottom(messagesArea, false);

    // Auto-resize textarea
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
        
        // Enable/disable send button
        sendButton.disabled = this.value.trim() === '';
    });

    // Send message on Enter (Shift+Enter for new line)
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (this.value.trim() !== '') {
                messageForm.dispatchEvent(new Event('submit'));
            }
        }
    });

    // Handle form submission
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        sendMessage(messageInput.value.trim());
    });

    // Scroll to bottom button
    if (scrollToBottomBtn) {
        scrollToBottomBtn.addEventListener('click', function() {
            scrollToBottom(messagesArea, true);
        });

        // Show/hide scroll button based on scroll position
        messagesArea.addEventListener('scroll', function() {
            const isNearBottom = messagesArea.scrollHeight - messagesArea.scrollTop - messagesArea.clientHeight < 100;
            
            if (isNearBottom) {
                scrollToBottomBtn.classList.add('hidden');
            } else {
                scrollToBottomBtn.classList.remove('hidden');
            }
        });
    }
}

// ===================================
// SEND MESSAGE
// ===================================

function sendMessage(message) {
    if (!message) return;

    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const messagesArea = document.getElementById('messagesArea');

    // Disable input while sending
    messageInput.disabled = true;
    sendButton.disabled = true;

    // Create message bubble immediately (optimistic UI)
    const messageWrapper = createMessageBubble('user', message, 'Just now', false);
    messagesArea.appendChild(messageWrapper);

    // Scroll to show new message
    scrollToBottom(messagesArea, true);

    // Clear input
    messageInput.value = '';
    messageInput.style.height = 'auto';

    // Simulate sending (in real app, this would be AJAX)
    setTimeout(function() {
        // Re-enable input
        messageInput.disabled = false;
        sendButton.disabled = false;
        messageInput.focus();

        // TODO: In real implementation, send to server via AJAX
        // fetch(`/messages/${conversationId}/send`, {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').content
        //     },
        //     body: JSON.stringify({ message: message })
        // })
        // .then(response => response.json())
        // .then(data => {
        //     // Update message with server data (ID, timestamp, etc)
        //     console.log('Message sent:', data);
        // });
        
    }, 300);
}

// ===================================
// CREATE MESSAGE BUBBLE
// ===================================

function createMessageBubble(senderType, message, time, isRead) {
    const wrapper = document.createElement('div');
    wrapper.className = `message-wrapper ${senderType === 'user' ? 'sent' : 'received'}`;

    let bubbleHTML = '';

    // Add avatar for received messages
    if (senderType === 'sitter') {
        bubbleHTML += `
            <div class="message-avatar">
                <img src="${sitterPhoto}" alt="${sitterName}">
            </div>
        `;
    }

    // Message bubble
    bubbleHTML += `
        <div class="message-bubble">
            <p class="message-text">${escapeHtml(message)}</p>
            <div class="message-meta">
                <span class="message-time">${time}</span>
                ${senderType === 'user' ? (isRead ? '<i class="fas fa-check-double read"></i>' : '<i class="fas fa-check"></i>') : ''}
            </div>
        </div>
    `;

    wrapper.innerHTML = bubbleHTML;
    return wrapper;
}

// ===================================
// SCROLL TO BOTTOM
// ===================================

function scrollToBottom(element, smooth = true) {
    if (smooth) {
        element.scrollTo({
            top: element.scrollHeight,
            behavior: 'smooth'
        });
    } else {
        element.scrollTop = element.scrollHeight;
    }
}

// ===================================
// UTILITY FUNCTIONS
// ===================================

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatTimestamp(timestamp) {
    const date = new Date(timestamp);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);

    if (diffMins < 1) {
        return 'Just now';
    } else if (diffMins < 60) {
        return `${diffMins} min ago`;
    } else if (diffHours < 24) {
        return `${diffHours}h ago`;
    } else if (diffDays < 7) {
        return `${diffDays}d ago`;
    } else {
        return date.toLocaleDateString();
    }
}

// ===================================
// SIMULATE TYPING INDICATOR (Optional)
// ===================================

function showTypingIndicator() {
    const messagesArea = document.getElementById('messagesArea');
    const typingIndicator = document.createElement('div');
    typingIndicator.className = 'message-wrapper received typing-indicator';
    typingIndicator.id = 'typingIndicator';
    typingIndicator.innerHTML = `
        <div class="message-avatar">
            <img src="${sitterPhoto}" alt="${sitterName}">
        </div>
        <div class="message-bubble typing-bubble">
            <div class="typing-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    `;
    messagesArea.appendChild(typingIndicator);
    scrollToBottom(messagesArea, true);
}

function hideTypingIndicator() {
    const indicator = document.getElementById('typingIndicator');
    if (indicator) {
        indicator.remove();
    }
}

// ===================================
// SIMULATE RECEIVING MESSAGE (Demo)
// ===================================

function simulateReceiveMessage(message, delay = 2000) {
    setTimeout(function() {
        const messagesArea = document.getElementById('messagesArea');
        const now = new Date();
        const time = now.toTimeString().slice(0, 5);
        
        const messageWrapper = createMessageBubble('sitter', message, time, true);
        messagesArea.appendChild(messageWrapper);
        scrollToBottom(messagesArea, true);
        
        // Play notification sound (optional)
        // playNotificationSound();
    }, delay);
}

// ===================================
// NOTIFICATION SOUND (Optional)
// ===================================

function playNotificationSound() {
    const audio = new Audio('/sounds/notification.mp3');
    audio.volume = 0.3;
    audio.play().catch(e => {
        // Ignore if sound fails to play
        console.log('Notification sound failed:', e);
    });
}

// Export functions for potential external use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        sendMessage,
        createMessageBubble,
        scrollToBottom,
        showTypingIndicator,
        hideTypingIndicator,
        simulateReceiveMessage
    };
}