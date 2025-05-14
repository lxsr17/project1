<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'entity_id',
        'type',
        'description',
        'status',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addToHistory($message)
    {
        // تقدر تحط هنا منطق حفظ سجل إذا كنت مجهزه بجدول ثاني
        // لكن مؤقتاً خلها فاضية أو تسوي log فقط
        \Log::info("Report #{$this->id} => $message");
    }

    public function reportedEntity()
{
    switch ($this->type) {
        case 'store':
            return $this->belongsTo(Business::class, 'entity_id');
        case 'user':
            return $this->belongsTo(User::class, 'entity_id');
        case 'review':
            return $this->belongsTo(Review::class, 'entity_id');
        default:
            return null;
    }
}

}
