<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table='acc_com_chats';
    protected $fillable = [
        'uid',
        'udid',
        'is_group',
        'is_active',
    ];

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'acc_com_participants')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    // Optional relationship for group details
    public function group(): HasOne
    {
        return $this->hasOne(Group::class);
    }
}
