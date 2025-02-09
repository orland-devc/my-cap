<?php

namespace App\Models;
use Illuminate\Support\Facades\Cache;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Chat;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_activity' => 'datetime',

    ];

    public function sentReplies()
    {
        return $this->hasMany(TicketReply::class, 'sender_id');
    }

    public function receivedReplies()
    {
        return $this->hasMany(TicketReply::class, 'assigned_to_id');
    }

    // Relationship to get messages sent by this user
    public function sentMessages()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    // Relationship to get messages received by this user
    public function receivedMessages()
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    public function isOnline()
    {
        return Cache::get('user-is-online-' . $this->id, false);
    }

}
