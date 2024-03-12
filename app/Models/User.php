<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * doc: https://laravel.com/docs/10.x/eloquent#mass-assignment
     * alternatively, use User::guard(), make changes, then User::reguard() in shell
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'password',
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
    ];

    // accesser for admin
    // Attribute::make method lets users defind custom behaviour for model attributes
    protected function isAdmin(): Attribute
    {
        $admins = ['yidan.eden.wang@gmail.com'];
        return Attribute::make(
            // if the user email is included in the $admins list, return true
            get: fn () => in_array($this->email, $admins)
        );
    }

    // relation between a user and their tickets
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Encrypt password before saving to the database.
     */
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }
     /**
     * Capitalize the name attribute when retrieving it.
     */
    // protected function getNameAttribute($value)
    // {
    //     return strtoupper($value);
    // }
}
