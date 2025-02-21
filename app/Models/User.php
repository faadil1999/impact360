<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enum\Space;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = [
        'roles.permissions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Checks that the model has a role that is in the given space.
     */
    public function belongsToSpace(Space|string $space): bool
    {
        return $this->roles()->where('space', $space)->exists();
    }

    /**
     * Function for returning the first role of user
     *
     *
     */
    public function currentRole()
    {
        return $this->roles()->first();
    }

    /**
     * Function for checking if user is Founder
     *
     * @return Attribute
     */
    public function isFounder(): Attribute
    {
        return Attribute::make(get: fn() => $this->roles()->where('space', Space::Founder->value)->exists());
    }

    /**
     * Function for checking if user is Member
     *
     * @return Attribute
     */
    public function isMember(): Attribute
    {
        return Attribute::make(get: fn() => $this->roles()->where('space', Space::Member->value)->exists());
    }
}
