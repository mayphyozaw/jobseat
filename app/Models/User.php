<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;


#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'photo',
        'role',
        'status',
    ];


    protected function acsrImagePath(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) =>
            $attributes['photo']
                ? asset('upload/user_images/' . $attributes['photo'])
                : asset('upload/user_images/default.png')
        );
    }


    protected function acsrStatus(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                return match ($attributes['status']) {
                    'active' => [
                        'text'  => 'Active',
                        'badge' => 'success', // Bootstrap class
                    ],
                    'inactive' => [
                        'text'  => 'Inactive',
                        'badge' => 'danger',
                    ],
                    default => [
                        'text'  => 'Unknown',
                        'badge' => 'secondary',
                    ],
                };
            }
        );
    }

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
}
