@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('الإشعارات') }}</div>

                <div class="card-body">
                    @if($notifications->count() > 0)
                        <div class="notifications-list">
                            @foreach($notifications as $notification)
                                <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}" data-id="{{ $notification->id }}">
                                    <div class="notification-header">
                                        <div class="notification-info">
                                            <h3 class="notification-title">{{ $notification->title }}</h3>
                                            <div class="notification-meta">
                                                <span class="notification-type {{ $notification->type }}">
                                                    @if($notification->type == 'alert')
                                                        تنبيه
                                                    @elseif($notification->type == 'announcement')
                                                        إعلان
                                                    @elseif($notification->type == 'warning')
                                                        تحذير
                                                    @elseif($notification->type == 'admin')
                                                        إداري
                                                    @endif
                                                </span>
                                                <span class="notification-date">{{ $notification->created_at->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                        @if(!$notification->is_read)
                                            <button class="mark-read-btn" data-id="{{ $notification->id }}">
                                                <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/check.svg" alt="Mark as Read">
                                            </button>
                                        @endif
                                    </div>
                                    <div class="notification-content">
                                        {{ $notification->message }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <img src="https://raw.githubusercontent.com/FortAwesome/Font-Awesome/6.x/svgs/solid/bell-slash.svg" alt="">
                            <h2>لا توجد إشعارات</h2>
                            <p>لم تتلق أي إشعارات بعد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark notification as read
        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const notificationId = this.dataset.id;
                markAsRead(notificationId, this);
            });
        });

        // Mark notification as read when clicked
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.addEventListener('click', function(e) {
                if (!e.target.classList.contains('mark-read-btn')) {
                    const notificationId = this.dataset.id;
                    const markReadBtn = this.querySelector('.mark-read-btn');
                    if (markReadBtn) {
                        markAsRead(notificationId, markReadBtn);
                    }
                }
            });
        });

        function markAsRead(notificationId, button) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notificationItem = button.closest('.notification-item');
                    notificationItem.classList.remove('unread');
                    notificationItem.classList.add('read');
                    button.remove();
                    
                    // Update notification count in header
                    const badge = document.querySelector('.notification-badge');
                    if (badge) {
                        const count = parseInt(badge.textContent) - 1;
                        if (count > 0) {
                            badge.textContent = count;
                        } else {
                            badge.remove();
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
        }
    });
</script>
@endsection