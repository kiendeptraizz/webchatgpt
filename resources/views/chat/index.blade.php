@extends('layouts.app')

@section('title', 'Chat với hỗ trợ viên - WebChatGPT')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="chat-avatar me-3">
                            <i class="fas fa-headset fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Hỗ trợ trực tuyến</h5>
                            <small>Chúng tôi thường phản hồi trong vòng 30 phút</small>
                        </div>
                    </div>
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
                                                {{ $message->created_at->format('H:i') }}
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
                                        <h5>Bắt đầu cuộc trò chuyện</h5>
                                        <p class="text-muted">Gửi tin nhắn để được hỗ trợ từ đội ngũ của chúng tôi.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="chat-input">
                            <form id="chat-form" class="d-flex">
                                <input type="text" id="message-input" class="form-control" placeholder="Nhập tin nhắn của bạn..." required>
                                <button type="submit" class="btn btn-primary ms-2">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4 shadow-sm border-0 rounded-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Câu hỏi thường gặp</h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Làm thế nào để nâng cấp gói dịch vụ?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Để nâng cấp gói dịch vụ, bạn có thể vào phần "Quản lý gói" trong trang cá nhân và chọn "Nâng cấp". Sau đó, bạn sẽ được chuyển đến trang chọn gói và thanh toán.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Tôi có thể thanh toán bằng những phương thức nào?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Chúng tôi hỗ trợ nhiều phương thức thanh toán bao gồm thẻ tín dụng, chuyển khoản ngân hàng, ví điện tử (Momo, ZaloPay, VNPay) và tiền mặt (COD).
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Làm thế nào để liên hệ với đội ngũ hỗ trợ?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bạn có thể liên hệ với đội ngũ hỗ trợ của chúng tôi qua chat trực tuyến này, gửi email đến support@webchatgpt.vn hoặc gọi điện thoại đến số (84) 123 456 789 trong giờ làm việc.
                                </div>
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
    
    .message.user {
        justify-content: flex-end;
    }
    
    .message-content {
        max-width: 70%;
        padding: 10px 15px;
        border-radius: 18px;
        position: relative;
    }
    
    .message.user .message-content {
        background-color: #0d6efd;
        color: white;
        border-bottom-right-radius: 5px;
    }
    
    .message.admin .message-content {
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
</style>
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
            messageDiv.className = `message ${isAdmin ? 'admin' : 'user'}`;
            
            const now = new Date();
            const time = now.getHours().toString().padStart(2, '0') + ':' + 
                        now.getMinutes().toString().padStart(2, '0');
            
            let autoReplyBadge = '';
            if (isAutoReply) {
                autoReplyBadge = '<span class="badge bg-secondary ms-1">Tự động</span>';
            }
            
            messageDiv.innerHTML = `
                <div class="message-content">
                    <div class="message-text">${content}</div>
                    <div class="message-time">${time} ${autoReplyBadge}</div>
                </div>
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
                        // This is a simplified approach - in a real app you'd compare with existing messages
                        chatMessages.innerHTML = '';
                        data.messages.forEach(message => {
                            addMessage(message.content, message.is_from_admin, message.is_auto_reply);
                        });
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
