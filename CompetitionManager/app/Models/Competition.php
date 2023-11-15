<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $table = 'competitions';
    
    protected $fillable = ['name', 'year', 'description'];
    public $timestamps = true;

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($competition) {
            $competition->rounds->each(function ($round) {
                $round->delete();
            });
        });
    }
}
