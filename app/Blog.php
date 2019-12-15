<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $guarded = [];

    /**By default route @param is id
     * Now set to "slug"
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}