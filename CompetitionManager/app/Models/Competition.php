<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;
    protected $table = 'competitions';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($competition) {
            $competition->rounds()->delete();
        });
    }
}
