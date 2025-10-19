<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AeoDocument extends Model
{
    protected $fillable = [
        'aeo_question_id', 'document_type', 'dept', 'nama_dokumen', 'no_sop_wi_std_form_other', 'files',
        'is_valid', 'validation_notes', 'validation_files', 'validated_at', 'validated_by',
        'aeo_manager_valid', 'aeo_manager_notes', 'aeo_manager_validated_at', 'aeo_manager_validated_by', 'due_date',
        'status',
        'created_by', 'updated_by',
    ];

    protected $casts = [
        'files' => 'array', // JSON -> array
        'validation_files' => 'array', // JSON -> array
        'is_valid' => 'boolean',
        'aeo_manager_valid' => 'boolean',
        'validated_at' => 'datetime',
        'aeo_manager_validated_at' => 'datetime',
        'due_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        // Ensure new documents are always created as invalid
        static::creating(function ($document) {
            if ($document->document_type === 'new') {
                $document->is_valid = false;
                $document->validated_at = null;
                $document->validated_by = null;
                // Set status to draft if not already set
                if (empty($document->status)) {
                    $document->status = 'draft';
                }
            }

            // Master documents are automatically validated but AEO Manager approval is manual
            if ($document->document_type === 'master') {
                $document->is_valid = true;
                // AEO Manager validation remains manual - do not auto-set
                // Set status to in_review if not already set (needs AEO Manager approval)
                if (empty($document->status)) {
                    $document->status = 'in_review';
                }
            }
        });

        // Ensure new documents cannot be updated to valid status
        static::updating(function ($document) {
            if ($document->document_type === 'new' && $document->isDirty('is_valid') && $document->is_valid) {
                $document->is_valid = false;
                $document->validated_at = null;
                $document->validated_by = null;
            }
        });
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(AeoQuestion::class, 'aeo_question_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function aeoManagerValidator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aeo_manager_validated_by');
    }
}
