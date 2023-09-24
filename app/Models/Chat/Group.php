<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    use HasFactory;
    protected $table='acc_com_groups';

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}
