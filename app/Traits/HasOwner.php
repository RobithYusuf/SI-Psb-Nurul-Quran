<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

trait HasOwner
{
    protected static function bootHasOwner()
    {
        if (auth()->check()) {
            // ini agar data baru otomatis isi user_id dg id user yg login.
            static::creating(function ($model) {
                $model->user_id = auth()->id();
            });

            // ini agar tiap query ditambah where('user_id', auth()->id())
            // ifnya bisa disesuaikan atau dihilangkan terserah
            if (!auth()->user()->is_admin) {
                static::addGlobalScope(new HasOwnerScope);
            }
        }
    }
}

class HasOwnerScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (auth()->user()->hasRole('santri')) {
            $builder->where($model->qualifyColumn('user_id'), auth()->id());
        } else {
            // No additional condition is added, so all data is returned.
        }
    }
}
