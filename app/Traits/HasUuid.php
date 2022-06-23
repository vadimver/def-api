<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model): void {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
