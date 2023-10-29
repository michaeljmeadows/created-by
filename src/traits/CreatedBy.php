<?php

declare(strict_types=1);

namespace michaeljmeadows\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait CreatedBy
{
    public static function bootCreatedBy()
    {
        static::creating(function (Model $model) {
            $model->created_by ??= auth()->id();
        });

        static::updating(function (Model $model) {
            $model->updated_by ??= auth()->id();
        });

        static::deleting(function (Model $model) {
            $model->deleted_by = auth()->id();
            $model->saveQuietly();
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
