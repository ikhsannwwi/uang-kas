<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class userProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profile';

    protected $guarded = ['id'];

    public function user(){
        return $this->hasMany(User::class, 'kode', 'user_kode');
    }
}
