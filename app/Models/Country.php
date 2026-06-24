<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'flag',
        'status',
    ];

    protected function acsrImagePath(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) =>
            $attributes['flag']
                ? asset('upload/flag_images/' . $attributes['flag'])
                : asset('upload/flag_images/default.png')
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
}
