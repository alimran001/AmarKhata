<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'initial_balance',
        'current_balance',
        'account_number',
        'bank_name',
        'branch',
        'description',
        'is_default',
    ];

    protected $casts = [
        'initial_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function transferFrom(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_id')
            ->where('type', 'transfer');
    }

    public function transferTo(): HasMany
    {
        return $this->hasMany(Transaction::class, 'transfer_to_account_id')
            ->where('type', 'transfer');
    }
}
