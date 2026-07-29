<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'restaurant_id',
    'user_id',
    'type',
    'message',
    'status',
    'admin_note',
])]
class Feedback extends Model
{
    use HasFactory;

    public const TYPE_BUG = 'bug';

    public const TYPE_SUGGESTION = 'suggestion';

    public const TYPE_OTHER = 'other';

    public const STATUS_NEW = 'new';

    public const STATUS_REVIEWED = 'reviewed';

    public const STATUS_RESOLVED = 'resolved';

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
