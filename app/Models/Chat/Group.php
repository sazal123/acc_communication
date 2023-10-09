<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table='acc_com_groups';
    protected $fillable = [
        'uid',
        'udid',
        'chat_id',
        'company_id',
        'is_active',
        'created_by',
        'name',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}
