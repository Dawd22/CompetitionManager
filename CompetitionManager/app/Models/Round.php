<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Competition;
use App\Models\Competitor;

class Round extends Model
{
    protected $table = 'rounds';
    protected $fillable = ['competition_id', 'round_name', 'description', 'location', 'beginning', 'end'];
    public $timestamps = true;

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($round) {
            $round->competitors()->delete();
        });
    }

    public function competitors()
    {
        return $this->hasMany(Competitor::class);
    }
}
