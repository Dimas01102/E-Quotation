<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    // Tabel: users
    // PK   : id (INT)
    protected $table   = 'users';
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'email', 'password', 'role', 'is_active'];

    protected $hidden = ['password'];

    protected $casts = [
        'is_active' => 'boolean',
        'password'  => 'hashed',
    ];

    // Matikan auto-timestamp Laravel agar pakai timestamp manual sesuai DDL
    public $timestamps = false;

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'user_id', 'id');
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class, 'created_by', 'id');
    }

    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isSupplier(): bool { return $this->role === 'supplier'; }
}