<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

#[Fillable(['name', 'instrument', 'notes'])]
class Pentagram extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return ['notes' => 'array'];
    }

    protected static function booted(): void
    {
        static::creating(function (Pentagram $p) {
            $p->created_by = Auth::id();
            $p->updated_by = Auth::id();
        });

        static::updating(function (Pentagram $p) {
            $p->updated_by = Auth::id();
        });

        static::deleting(function (Pentagram $p) {
            if (! $p->isForceDeleting()) {
                $p->deleted_by = Auth::id();
                $p->saveQuietly();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
