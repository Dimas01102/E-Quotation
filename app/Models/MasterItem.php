<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterItem extends Model
{
    protected $table      = 'master_items';
    protected $primaryKey = 'id_item';

    public $timestamps = false;

    protected $fillable = ['id_category', 'item_code', 'item_name', 'unit', 'description'];

    public function category()
    {
        return $this->belongsTo(MasterCategory::class, 'id_category', 'id_master_category');
    }

    public function itemBatchCategories()
    {
        return $this->hasMany(ItemBatchCategory::class, 'id_item', 'id_item');
    }
}