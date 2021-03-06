<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryNote extends Model
{
    //
    protected $table = "categories_notes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description',
    ];

    public function notes()
    {
        return $this->hasMany('App\Models\Note','category_id');
    }
}
