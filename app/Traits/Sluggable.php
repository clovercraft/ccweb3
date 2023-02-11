<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Util;

trait HasSlug
{
    protected string $sluggable = 'name';

    public function getAttributes()
    {
        $this->mergeAttributesFromCachedCasts();
        $this->attributes['slug'] = Util::makeSlug($this->attributes[$this->sluggable]);
        return $this->attributes;
    }
}
