<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfqTemplate extends Model
{
    protected $table = 'rfq_templates';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'file_name',
        'file_path',
        'is_active',
        'uploaded_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}