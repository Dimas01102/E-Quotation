<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    protected $table = 'quotation_items';

    public $timestamps = true;

    protected $fillable = [
        'id_quotation',
        'coll_no',
        'rfq_no',
        'vendor',
        'no_item',
        'material_no',
        'description',
        'qty',
        'uom',
        'currency',
        'net_price',
        'incoterm',
        'destination',
        'remark_1',
        'remark_2',
        'lead_time_weeks',
        'payment_term',
        'quotation_date',
    ];

    protected $casts = [
        'qty'       => 'float',
        'net_price' => 'float',
    ];

    /**
     * Relasi ke Quotation
     * quotation_items.id_quotation → quotations.id_quotation
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'id_quotation', 'id_quotation');
    }
}