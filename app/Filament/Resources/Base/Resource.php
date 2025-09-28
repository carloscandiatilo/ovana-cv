<?php

namespace App\Filament\Resources\Base;

use Filament\Resources\Resource as BaseResource;
use Illuminate\Support\Str;

abstract class Resource extends BaseResource
{
    public static function canAccess(): bool
    {
        $modelName = Str::snake(class_basename(static::getModel()));
        return auth()->user()->can("visualizar_{$modelName}");
    }

    public static function canCreate(): bool
    {
        $modelName = Str::snake(class_basename(static::getModel()));
        return auth()->user()->can("criar_{$modelName}");
    }

    public static function canEdit($record): bool
    {
        $modelName = Str::snake(class_basename(static::getModel()));
        return auth()->user()->can("editar_{$modelName}");
    }

    public static function canDelete($record): bool
    {
        $modelName = Str::snake(class_basename(static::getModel()));
        return auth()->user()->can("eliminar_{$modelName}");
    }
}