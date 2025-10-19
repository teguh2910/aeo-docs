<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AeoQuestion extends Model
{
    protected $fillable = [
        'subcriteria',
        'question',
        'keterangan',
        'jawaban',
        'files',
        'dept',
        'approval_1',
        'approval_1_at',
        'approval_1_by',
        'approval_1_notes',
        'approval_2',
        'approval_2_at',
        'approval_2_by',
        'approval_2_notes',
    ];

    protected $casts = [
        'files' => 'array',
        'approval_1' => 'boolean',
        'approval_2' => 'boolean',
        'approval_1_at' => 'datetime',
        'approval_2_at' => 'datetime',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(AeoDocument::class);
    }

    public function approval1By(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'approval_1_by');
    }

    public function approval2By(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'approval_2_by');
    }
}
