<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class AeoDocument extends Model
{
protected $fillable = [
'aeo_question_id', 'dept', 'nama_dokumen', 'no_sop_wi_std_form_other', 'files',
'created_by', 'updated_by',
];


protected $casts = [
'files' => 'array', // JSON -> array
];


public function question(): BelongsTo
{
return $this->belongsTo(AeoQuestion::class, 'aeo_question_id');
}


public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
public function updater(): BelongsTo { return $this->belongsTo(User::class, 'updated_by'); }
}