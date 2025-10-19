<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AeoQuestion extends Model
{
    protected $fillable = ['subcriteria', 'question', 'keterangan', 'jawaban', 'files'];

    protected $casts = [
        'files' => 'array',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(AeoDocument::class);
    }
}
