<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'title',
        'message',
        'type',
        'receiver_id',
        'receiver_type',
        'sender_admin_id',
        'link',
        'date',
        'is_read',
        'target',
        'target_id',
    ];

    protected $attributes = [
        'is_read' => false,
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // علاقة Polymorphic مع التاجر أو المستخدم
    public function receiver()
    {
        return $this->morphTo();
    }

    // نطاق جاهز للتنبيهات غير المقروءة
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // تعليم التنبيه كمقروء
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}
