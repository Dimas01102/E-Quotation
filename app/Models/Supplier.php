<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    public $timestamps = true;

    protected $fillable = ['user_id', 'company_name', 'npwp', 'address', 'phone'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function invitedSupplierCategories()
    {
        return $this->hasMany(InvitedSupplierCategory::class, 'id_supplier', 'id');
    }

    public function quotations()
    {
        return $this->hasManyThrough(
            Quotation::class,
            InvitedSupplierCategory::class,
            'id_supplier',
            'id_invited_supplier',
            'id',
            'id_invited_supplier'
        );
    }
}