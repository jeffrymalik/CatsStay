@extends('layout.main')

@section('title', 'Messages - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/messages.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

<div class="messages-container">
    <div class="messages-wrapper">
        
        {{-- Page Header --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-comment-dots"></i>
                    Messages
                </h1>
                <p class="page-subtitle">Chat with your pet sitters</p>
            </div>
            @if($totalUnread > 0)
            <div class="unread-badge-header">
                <span>{{ $totalUnread }} unread</span>
            </div>
            @endif
        </div>

        {{-- Search Bar --}}
        <div class="search-bar-container">
            <form action="{{ route('messages.index') }}" method="GET" class="search-form">
                <div class="search-input-wrapper">
                    <i class="fas fa-search"></i>
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search conversations..." 
                        value="{{ $search }}"
                        class="search-input"
                    >
                    @if($search)
                        <button type="button" onclick="clearSearch()" class="clear-search">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                </div>
            </form>
        </div>

        {{-- Conversations List --}}
        @if(count($conversations) > 0)
        <div class="conversations-list">
            @foreach($conversations as $conv)
            <a href="{{ route('messages.show', $conv['id']) }}" class="conversation-card {{ $conv['unread_count'] > 0 ? 'unread' : '' }}">
                {{-- Sitter Photo --}}
                <div class="conversation-avatar">
                    <img src="{{ $conv['sitter']['photo'] }}" alt="{{ $conv['sitter']['name'] }}">
                    @if($conv['sitter']['is_online'])
                        <span class="online-indicator"></span>
                    @endif
                </div>

                {{-- Conversation Info --}}
                <div class="conversation-content">
                    <div class="conversation-header">
                        <h3 class="conversation-name">{{ $conv['sitter']['name'] }}</h3>
                        <span class="conversation-time">{{ \Carbon\Carbon::parse($conv['last_message_time'])->diffForHumans() }}</span>
                    </div>
                    
                    <div class="conversation-footer">
                        <p class="conversation-preview">
                            @if($conv['last_message_sender'] === 'user')
                                <span class="you-label">You: </span>
                            @endif
                            {{ Str::limit($conv['last_message'], 50) }}
                        </p>
                        
                        @if($conv['unread_count'] > 0)
                            <span class="unread-badge">{{ $conv['unread_count'] }}</span>
                        @endif
                    </div>

                    {{-- Booking Code Badge --}}
                    <div class="booking-badge">
                        <i class="fas fa-ticket"></i>
                        {{ $conv['booking_code'] }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        @else
        {{-- Empty State --}}
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-comment-slash"></i>
            </div>
            @if($search)
                <h2 class="empty-title">No conversations found</h2>
                <p class="empty-description">
                    We couldn't find any conversations matching "{{ $search }}"
                </p>
                <button onclick="clearSearch()" class="btn-primary">
                    <i class="fas fa-times"></i>
                    Clear Search
                </button>
            @else
                <h2 class="empty-title">No messages yet</h2>
                <p class="empty-description">
                    When you book a sitter, you'll be able to chat with them here.<br>
                    Start by finding a sitter for your cat!
                </p>
                <a href="{{ route('select-service') }}" class="btn-primary">
                    <i class="fas fa-search"></i>
                    Find a Sitter
                </a>
            @endif
        </div>
        @endif

        {{-- Info Box --}}
        @if(count($conversations) > 0)
        <div class="info-box-messages">
            <i class="fas fa-info-circle"></i>
            <div class="info-content">
                <h4>Stay Connected</h4>
                <p>Chat with your sitters to discuss your cat's needs, schedule, and any special instructions.</p>
            </div>
        </div>
        @endif

        {{-- Back to Dashboard --}}
        <div class="back-button-wrapper">
            <a href="{{ route('user.dashboard') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Dashboard</span>
            </a>
        </div>

    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/messages.js') }}"></script>
<script>
function clearSearch() {
    window.location.href = "{{ route('messages.index') }}";
}
</script>
@endsection