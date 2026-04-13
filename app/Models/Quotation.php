<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table      = 'quotations';
    protected $primaryKey = 'id_quotation';

    public $timestamps = true;

    protected $fillable = [
        'id_invited_supplier', 'file_name', 'file_path',
        'submitted_at', 'total_price', 'status', 'note', 'po_file_path',
    ];

    protected $casts = ['submitted_at' => 'datetime'];

    public function invitedSupplier()
    {
        return $this->belongsTo(InvitedSupplierCategory::class, 'id_invited_supplier', 'id_invited_supplier');
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class, 'id_quotation', 'id_quotation');
    }
}