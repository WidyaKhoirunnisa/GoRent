<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'image',
        'name',
        'nik',
        'phone',
        'address',
        'gender',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rentals(): HasMany{
        return $this->hasMany(Rental::class, 'user_id', 'user_id');
    }
}
