<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchCategory extends Model
{
    protected $table      = 'batch_categories';
    protected $primaryKey = 'id_batch_category';

    public $timestamps = false;

    protected $fillable = ['id_batch', 'id_master_category'];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'id_batch', 'id_batch');
    }

    public function masterCategory()
    {
        return $this->belongsTo(MasterCategory::class, 'id_master_category', 'id_master_category');
    }

    public function itemBatchCategories()
    {
        return $this->hasMany(ItemBatchCategory::class, 'id_batch_category', 'id_batch_category');
    }

    public function invitedSupplierCategories()
    {
        return $this->hasMany(InvitedSupplierCategory::class, 'id_batch_category', 'id_batch_category');
    }
}