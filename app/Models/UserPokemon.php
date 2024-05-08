<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPokemon extends Model
{
    use HasFactory;

    protected $table = 'user_pokemons';

    protected $fillable = [
        'user_id',
        'pokemon',
        'type',
    ];


}
