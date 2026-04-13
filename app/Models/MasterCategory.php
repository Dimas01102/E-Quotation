<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterCategory extends Model
{
    protected $table      = 'master_category';
    protected $primaryKey = 'id_master_category';

    public $timestamps = false;

    protected $fillable = ['name', 'description'];

    public function masterItems()
    {
        return $this->hasMany(MasterItem::class, 'id_category', 'id_master_category');
    }

    public function batchCategories()
    {
        return $this->hasMany(BatchCategory::class, 'id_master_category', 'id_master_category');
    }
}