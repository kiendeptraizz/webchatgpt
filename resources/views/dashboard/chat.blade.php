@extends('layouts.app')

@section('title', 'Chat với tư vấn viên - WebChatGPT')

@section('styles')
<style>
    .dashboard-sidebar {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .dashboard-sidebar .nav-link {
        color: #333;
        padding: 12px 20px;
        border-radius: 5px;
        margin-bottom: 5px;
        transition: all 0.3s ease;
    }

    .dashboard-sidebar .nav-link:hover {
        background-color: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
    }

    .dashboard-sidebar .nav-link.active {
        background-color: var(--primary-color);
        color: white;
    }

    .dashboard-sidebar .nav-link i {
        width: 24px;
        text-align: center;
        margin-right: 10px;
    }

    .chat-container {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 200px);
        min-height: 600px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .chat-header {
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
    }

    .message {
        margin-bottom: 20px;
        max-width: 80%;
    }

    .message-user {
        margin-left: auto;
        background-color: var(--primary-color);
        color: white;
        border-radius: 18px 18px 0 18px;
        padding: 12px 15px;
    }

    .message-ai {
        margin-right: auto;
        background-color: #f1f1f1;
        color: #333;
        border-radius: 18px 18px 18px 0;
        padding: 12px 15px;
    }

    .message-time {
        font-size: 0.7rem;
        color: rgba(255,255,255,0.7);
        text-align: right;
        margin-top: 5px;
    }

    .message-ai .message-time {
        color: #999;
    }

    .chat-input {
        padding: 15px 20px;
        border-top: 1px solid #eee;
    }

    .chat-input form {
        display: flex;
        align-items: center;
    }

    .chat-input input {
        flex: 1;
        border: none;
        padding: 12px 15px;
        border-radius: 30px;
        background-color: #f1f1f1;
        margin-right: 10px;
    }

    .chat-input input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.3);
    }

    .chat-input button {
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-options {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .chat-option {
        background-color: #f1f1f1;
        border: none;
        border-radius: 20px;
        padding: 8px 15px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .chat-option:hover {
        background-color: #e1e1e1;
    }

    .typing-indicator {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .typing-indicator span {
        height: 8px;
        width: 8px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
        animation: typing 1s infinite;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {
        0% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="dashboard-sidebar p-4">
                <div class="text-center mb-4">
                    <img src="https://placehold.co/100x100" alt="User Avatar" class="rounded-circle mb-3">
                    <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                    @if(isset($activeSubscription) && $activeSubscription)
                        <p class="text-muted mb-0">{{ $activeSubscription->package->name }}</p>
                    @else
                        <p class="text-muted mb-0">Chưa đăng ký gói</p>
                    @endif
                </div>

                <hr>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Tổng quan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('chat') }}">
                            <i class="fas fa-comments"></i> Chat với tư vấn viên
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('referrals') }}">
                            <i class="fas fa-user-friends"></i> Giới thiệu bạn bè
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-history"></i> Lịch sử chat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i> Cài đặt
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-credit-card"></i> Thanh toán
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-question-circle"></i> Hỗ trợ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </li>
                </ul>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Chat với tư vấn viên</h2>
                <div>
                    <button class="btn btn-outline-secondary me-2">
                        <i class="fas fa-save me-2"></i> Lưu chat
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Chat mới
                    </button>
                </div>
            </div>

            <!-- Chat Container -->
            <div class="chat-container">
                <div class="chat-header">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Tư vấn viên</h5>
                            <small class="text-muted">Thường phản hồi trong vòng 30 phút</small>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Cài đặt">
                            <i class="fas fa-cog"></i>
                        </button>
                    </div>
                </div>

                <div class="chat-messages" id="chat-messages">
                    @if(count($messages) > 0)
                        @foreach($messages as $message)
                            <div class="message {{ $message->is_from_admin ? 'message-ai' : 'message-user' }}">
                                <p class="mb-1">{{ $message->content }}</p>
                                <div class="message-time">
                                    {{ $message->created_at->format('H:i') }}
                                    @if($message->is_auto_reply)
                                        <span class="badge bg-secondary ms-1">Tự động</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-chat text-center p-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5>Bắt đầu cuộc trò chuyện</h5>
                            <p class="text-muted">Gửi tin nhắn để được hỗ trợ từ đội ngũ tư vấn viên của chúng tôi.</p>
                        </div>
                    @endif
                </div>

                <div class="chat-input">
                    <form id="chat-form">
                        <input type="text" id="message-input" placeholder="Nhập tin nhắn của bạn..." autofocus>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chat-messages');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');

        // Scroll to bottom of chat
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Initial scroll
        scrollToBottom();

        // Send message
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const content = messageInput.value.trim();
            if (!content) return;

            // Clear input
            messageInput.value = '';

            // Add message to UI immediately
            addMessage(content, false);

            // Send to server
            fetch('{{ route("chat.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // If there's an auto-reply, add it to the UI
                    if (data.auto_reply) {
                        setTimeout(() => {
                            addMessage(data.auto_reply.content, true, true);
                        }, 1000);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Add message to UI
        function addMessage(content, isAdmin = false, isAutoReply = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isAdmin ? 'message-ai' : 'message-user'}`;

            const now = new Date();
            const time = now.getHours().toString().padStart(2, '0') + ':' +
                        now.getMinutes().toString().padStart(2, '0');

            let autoReplyBadge = '';
            if (isAutoReply) {
                autoReplyBadge = '<span class="badge bg-secondary ms-1">Tự động</span>';
            }

            messageDiv.innerHTML = `
                <p class="mb-1">${content}</p>
                <div class="message-time">${time} ${autoReplyBadge}</div>
            `;

            chatMessages.appendChild(messageDiv);
            scrollToBottom();
        }

        // Poll for new messages every 10 seconds
        function pollMessages() {
            fetch('{{ route("chat.messages") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI with new messages
                        chatMessages.innerHTML = '';
                        data.messages.forEach(message => {
                            addMessage(message.content, message.is_from_admin, message.is_auto_reply);
                        });
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error polling messages:', error);
                });
        }

        // Poll every 10 seconds
        setInterval(pollMessages, 10000);
    });
</script>
@endsection