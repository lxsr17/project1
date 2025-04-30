<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // تحديد الجدول (اختياري إذا كان الاسم مطابق)
    protected $table = 'notifications';

    // الأعمدة التي يمكن تعبئتها
    protected $fillable = [
        'title',
        'message',
        'is_read',
    ];

    // القيم الافتراضية (اختياري)
    protected $attributes = [
        'is_read' => false,
    ];

    // كاست: تحويل is_read إلى boolean تلقائياً
    protected $casts = [
        'is_read' => 'boolean',
    ];

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
