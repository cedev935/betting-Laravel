<?php

namespace App\Http\Traits;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait Translatable
{
    public static function booted()
    {
        if (Auth::getDefaultDriver() != 'admin') {
            $lang = app()->getLocale();
            $languageId = Language::where('short_name', $lang)->first();
            $defaultLang = Language::first();
            static::addGlobalScope('language', function (Builder $builder) use ($languageId, $defaultLang) {
                if ($languageId) {
                    $builder->where('language_id', $languageId->id);
                } else {
                    $builder->where('language_id', $defaultLang->id);
                }
            });
        }
    }
}
