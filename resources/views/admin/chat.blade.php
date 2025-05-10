@extends('layouts.admin')

@section('title', 'Chat với ' . $user->name . ' - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <a href="{{ route('admin.messages') }}" class="btn btn-sm btn-outline-primary me-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            Chat với {{ $user->name }}
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="m-0 font-weight-bold">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                    </div>
                    <span class="badge bg-primary">{{ count($messages) }} tin nhắn</span>
                </div>
                <div class="card-body p-0">
                    <div class="chat-container">
                        <div class="chat-messages" id="chat-messages">
                            @if(count($messages) > 0)
                                @foreach($messages as $message)
                                    <div class="message {{ $message->is_from_admin ? 'admin' : 'user' }}">
                                        <div class="message-content">
                                            <div class="message-text">{{ $message->content }}</div>
                                            <div class="message-time">
                                                {{ $message->created_at->format('H:i d/m/Y') }}
                                                @if($message->is_auto_reply)
                                                    <span class="badge bg-secondary ms-1">Tự động</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-chat">
                                    <div class="text-center p-5">
                                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                        <h5>Chưa có tin nhắn nào</h5>
                                        <p class="text-muted">Bắt đầu cuộc trò chuyện với người dùng này.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="chat-input">
                            <form id="chat-form" class="d-flex">
                                <input type="hidden" id="user-id" value="{{ $user->id }}">
                                <input type="text" id="message-input" class="form-control" placeholder="Nhập tin nhắn của bạn..." required>
                                <button type="submit" class="btn btn-primary ms-2">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin người dùng</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Thông tin cá nhân</h6>
                        <p><strong>Tên:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Ngày đăng ký:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6>Gói dịch vụ</h6>
                        @if($user->subscriptions->count() > 0)
                            @foreach($user->subscriptions as $subscription)
                                <div class="card bg-light mb-2">
                                    <div class="card-body py-2 px-3">
                                        <p class="mb-1"><strong>Gói:</strong> {{ $subscription->package->name ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Trạng thái:</strong>
                                            @if($subscription->active)
                                                <span class="badge bg-success">Đang hoạt động</span>
                                            @else
                                                <span class="badge bg-warning">Chưa kích hoạt</span>
                                            @endif
                                        </p>
                                        <p class="mb-0"><strong>Hết hạn:</strong> {{ $subscription->end_date->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Người dùng chưa đăng ký gói dịch vụ nào.</p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <h6>Câu trả lời nhanh</h6>
                        <div class="quick-replies">
                            <button type="button" class="btn btn-sm btn-outline-primary mb-2 me-2 quick-reply" data-reply="Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ hỗ trợ bạn ngay.">
                                Chào mừng
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary mb-2 me-2 quick-reply" data-reply="Vui lòng cung cấp thêm thông tin để chúng tôi có thể hỗ trợ bạn tốt hơn.">
                                Yêu cầu thông tin
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary mb-2 me-2 quick-reply" data-reply="Bạn có thể thanh toán qua chuyển khoản ngân hàng, MoMo, ZaloPay hoặc VNPay.">
                                Phương thức thanh toán
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary mb-2 me-2 quick-reply" data-reply="Cảm ơn bạn đã liên hệ. Chúc bạn một ngày tốt lành!">
                                Kết thúc
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lịch sử hoạt động</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Đăng ký tài khoản</h6>
                                <small class="text-muted">{{ $user->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        @foreach($user->subscriptions as $subscription)
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-0">Đăng ký gói {{ $subscription->package->name ?? 'N/A' }}</h6>
                                    <small class="text-muted">{{ $subscription->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        @endforeach
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Tin nhắn đầu tiên</h6>
                                <small class="text-muted">
                                    @if($messages->count() > 0)
                                        {{ $messages->sortBy('created_at')->first()->created_at->format('d/m/Y H:i') }}
                                    @else
                                        Chưa có tin nhắn
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        height: 500px;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
    }

    .chat-input {
        padding: 15px;
        border-top: 1px solid #e9ecef;
        background-color: #f8f9fa;
    }

    .message {
        display: flex;
        margin-bottom: 15px;
    }

    .message.admin {
        justify-content: flex-end;
    }

    .message-content {
        max-width: 70%;
        padding: 10px 15px;
        border-radius: 18px;
        position: relative;
    }

    .message.admin .message-content {
        background-color: #4e73df;
        color: white;
        border-bottom-right-radius: 5px;
    }

    .message.user .message-content {
        background-color: #f0f2f5;
        color: #212529;
        border-bottom-left-radius: 5px;
    }

    .message-time {
        font-size: 0.7rem;
        margin-top: 5px;
        opacity: 0.8;
        text-align: right;
    }

    .empty-chat {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #6c757d;
    }

    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0.5rem;
        height: 100%;
        width: 2px;
        background-color: #e9ecef;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }

    .timeline-marker {
        position: absolute;
        left: -1.5rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background-color: #4e73df;
        top: 0.25rem;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chat-messages');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const userId = document.getElementById('user-id').value;
        const quickReplies = document.querySelectorAll('.quick-reply');

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
            addMessage(content, true);

            // Send to server
            fetch('{{ route("admin.messages.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    user_id: userId,
                    content: content
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Error sending message');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Quick replies
        quickReplies.forEach(button => {
            button.addEventListener('click', function() {
                const replyText = this.getAttribute('data-reply');
                messageInput.value = replyText;
                messageInput.focus();
            });
        });

        // Add message to UI
        function addMessage(content, isAdmin = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isAdmin ? 'admin' : 'user'}`;

            const now = new Date();
            const time = now.getHours().toString().padStart(2, '0') + ':' +
                        now.getMinutes().toString().padStart(2, '0') + ' ' +
                        now.getDate().toString().padStart(2, '0') + '/' +
                        (now.getMonth() + 1).toString().padStart(2, '0') + '/' +
                        now.getFullYear();

            messageDiv.innerHTML = `
                <div class="message-content">
                    <div class="message-text">${content}</div>
                    <div class="message-time">${time}</div>
                </div>
            `;

            chatMessages.appendChild(messageDiv);
            scrollToBottom();
        }

        // Poll for new messages every 5 seconds
        function pollMessages() {
            fetch(`{{ route("admin.messages.get", $user->id) }}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI with new messages
                        // This is a simplified approach - in a real app you'd compare with existing messages
                        chatMessages.innerHTML = '';
                        data.messages.forEach(message => {
                            const isAdmin = message.is_from_admin;
                            const content = message.content;
                            const time = new Date(message.created_at).toLocaleString('vi-VN', {
                                hour: '2-digit',
                                minute: '2-digit',
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });

                            const messageDiv = document.createElement('div');
                            messageDiv.className = `message ${isAdmin ? 'admin' : 'user'}`;

                            let autoReplyBadge = '';
                            if (message.is_auto_reply) {
                                autoReplyBadge = '<span class="badge bg-secondary ms-1">Tự động</span>';
                            }

                            messageDiv.innerHTML = `
                                <div class="message-content">
                                    <div class="message-text">${content}</div>
                                    <div class="message-time">${time} ${autoReplyBadge}</div>
                                </div>
                            `;

                            chatMessages.appendChild(messageDiv);
                        });

                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error polling messages:', error);
                });
        }

        // Poll every 5 seconds
        setInterval(pollMessages, 5000);
    });
</script>
@endsection
