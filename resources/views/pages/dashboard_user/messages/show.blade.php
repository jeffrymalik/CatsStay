@extends('layout.main')

@section('title', 'Chat with {{ $conversation["sitter"]["name"] }} - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/messages.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

<div class="chat-container">
    <div class="chat-wrapper">
        
        {{-- Chat Header --}}
        <div class="chat-header">
            <a href="{{ route('messages.index') }}" class="back-button-chat">
                <i class="fas fa-arrow-left"></i>
            </a>
            
            <div class="chat-header-info">
                <div class="chat-avatar">
                    <img src="{{ $conversation['sitter']['photo'] }}" alt="{{ $conversation['sitter']['name'] }}">
                    @if($conversation['sitter']['is_online'])
                        <span class="online-indicator"></span>
                    @endif
                </div>
                <div class="chat-header-text">
                    <h2 class="chat-name">{{ $conversation['sitter']['name'] }}</h2>
                    <p class="chat-status">
                        @if($conversation['sitter']['is_online'])
                            <span class="status-online">
                                <i class="fas fa-circle"></i>
                                Online
                            </span>
                        @else
                            <span class="status-offline">
                                Last seen {{ \Carbon\Carbon::parse($conversation['sitter']['last_seen'])->diffForHumans() }}
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="chat-header-actions">
                <a href="{{ route('sitter.profile', $conversation['sitter']['id']) }}" class="btn-header-action" title="View Profile">
                    <i class="fas fa-user"></i>
                </a>
                <a href="{{ route('my-request.index') }}" class="btn-header-action" title="View Booking">
                    <i class="fas fa-ticket"></i>
                </a>
            </div>
        </div>

        {{-- Booking Info Banner --}}
        <div class="booking-info-banner">
            <i class="fas fa-info-circle"></i>
            <span>Regarding booking <strong>{{ $conversation['booking_code'] }}</strong></span>
        </div>

        {{-- Messages Area --}}
        <div class="messages-area" id="messagesArea">
            @php
                $currentDate = null;
            @endphp

            @foreach($conversation['messages'] as $message)
                @php
                    $messageDate = \Carbon\Carbon::parse($message['timestamp'])->format('Y-m-d');
                    $showDateSeparator = $currentDate !== $messageDate;
                    $currentDate = $messageDate;
                @endphp

                {{-- Date Separator --}}
                @if($showDateSeparator)
                    <div class="date-separator">
                        <span>{{ \Carbon\Carbon::parse($message['timestamp'])->format('l, d F Y') }}</span>
                    </div>
                @endif

                {{-- Message Bubble --}}
                <div class="message-wrapper {{ $message['sender_type'] === 'user' ? 'sent' : 'received' }}">
                    @if($message['sender_type'] === 'sitter')
                        <div class="message-avatar">
                            <img src="{{ $conversation['sitter']['photo'] }}" alt="{{ $conversation['sitter']['name'] }}">
                        </div>
                    @endif

                    <div class="message-bubble">
                        <p class="message-text">{{ $message['message'] }}</p>
                        <div class="message-meta">
                            <span class="message-time">{{ \Carbon\Carbon::parse($message['timestamp'])->format('H:i') }}</span>
                            @if($message['sender_type'] === 'user')
                                @if($message['is_read'])
                                    <i class="fas fa-check-double read"></i>
                                @else
                                    <i class="fas fa-check"></i>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Scroll to bottom button --}}
            <button id="scrollToBottom" class="scroll-to-bottom hidden">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>

        {{-- Message Input --}}
        <div class="message-input-container">
            <form id="messageForm" class="message-form">
                @csrf
                <div class="message-input-wrapper">
                    <button type="button" class="btn-attachment" title="Attach file (coming soon)">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    
                    <textarea 
                        id="messageInput" 
                        name="message" 
                        placeholder="Type a message..." 
                        rows="1"
                        class="message-input"
                    ></textarea>
                    
                    <button type="submit" class="btn-send" id="sendButton" disabled>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@section('js')
<script>
    const conversationId = {{ $conversation['id'] }};
    const sitterName = "{{ $conversation['sitter']['name'] }}";
    const sitterPhoto = "{{ $conversation['sitter']['photo'] }}";
</script>
<script src="{{ asset('js/messages.js') }}"></script>
@endsection