<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemBatchCategory extends Model
{
    protected $table      = 'items_batch_categories';
    protected $primaryKey = 'id_item_batch_category';

    // ✅ FIX: tabel items_batch_categories TIDAK punya timestamps
    public $timestamps = false;

    protected $fillable = ['id_item', 'id_batch_category', 'quantity'];

    public function masterItem()
    {
        return $this->belongsTo(MasterItem::class, 'id_item', 'id_item');
    }

    public function batchCategory()
    {
        return $this->belongsTo(BatchCategory::class, 'id_batch_category', 'id_batch_category');
    }
}