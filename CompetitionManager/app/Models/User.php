<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Competitor;

class User extends Authenticatable
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->competitors()->delete();
        });

    }

    public function competitors()
    {
        return $this->hasMany(Competitor::class);
    }
}
