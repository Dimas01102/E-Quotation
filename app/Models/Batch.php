<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table      = 'batches';
    protected $primaryKey = 'id_batch';

    public $timestamps = true;

    protected $fillable = [
        'batch_number',   // kolom di DB tetap batch_number, tapi label UI = "No. RFQ"
        'title',
        'description',
        'deadline',
        'status',
        'created_by',
    ];

    protected $casts = [
    'deadline' => 'date:Y-m-d',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function batchCategories()
    {
        return $this->hasMany(BatchCategory::class, 'id_batch', 'id_batch');
    }

    /**
     * Cek apakah batch bisa diajukan penawaran oleh supplier.
     * Hanya bisa jika status = 'open' DAN deadline belum lewat.
     */
    public function isOpenForSubmission(): bool
    {
        return $this->status === 'open'
            && $this->deadline
            && $this->deadline->isFuture();
    }
}