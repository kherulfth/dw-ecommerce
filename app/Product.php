<?php

namespace App;

// use App\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $guarded = [];

    public function getStatusLabelAttribute(){
        if ($this->status == 0) {
            return '<span class="badge badge-secondary">Draft</span>';
        }

        return '<span class="badge badge-success">Aktif</span>';

    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function setSlugAttribute($value){
        $this->attributes['slug'] = Str::slug($value);
    }
}
