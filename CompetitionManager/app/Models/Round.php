<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;
    protected $table = 'rounds';
    public $primaryKey = 'id';
    public $foreignKey = 'competition_id';
    public $timestamps = true;

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
