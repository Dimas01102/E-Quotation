<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitedSupplierCategory extends Model
{
    protected $table      = 'invited_supplier_categories';
    protected $primaryKey = 'id_invited_supplier';

    public $timestamps = true;

    protected $fillable = ['id_supplier', 'id_batch_category', 'invited_at', 'status'];

    protected $casts = ['invited_at' => 'datetime'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id');
    }

    public function batchCategory()
    {
        return $this->belongsTo(BatchCategory::class, 'id_batch_category', 'id_batch_category');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'id_invited_supplier', 'id_invited_supplier');
    }
}