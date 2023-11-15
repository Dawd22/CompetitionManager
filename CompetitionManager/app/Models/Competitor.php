<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Round;
use App\Models\User;

class Competitor extends Model
{
    protected $table = 'competitors';

    protected $fillable = ['user_id', 'round_id'];
    public $timestamps = true;
    
    public function round()
    {
        return $this->belongsTo(Round::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
