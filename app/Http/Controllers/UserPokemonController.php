<?php

namespace App\Http\Controllers;

use App\Models\UserPokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPokemonController extends Controller
{
    public function addPokemon(Request $request)
    {
        $request->validate([
            'pokemon' => ['required'],
            'type' => ['required']
        ]);

        /** @var UserPokemon $userPokemon */
        $userPokemon = UserPokemon::create([
            'user_id' => Auth::id(),
            'pokemon' => $request->pokemon,
            'type' => $request->type
        ]);

        return response()->json([
            'success' => true,
            'data' => $userPokemon
        ]);
    }

    public function removePokemon(Request $request)
    {
        $request->validate([
            'pokemon' => ['required'],
            'type' => ['required']
        ]);

        $deleted = UserPokemon::where([
            ['user_id', '=', Auth::id()],
            ['pokemon', '=', $request->pokemon],
            ['type', '=', $request->type]
        ])->delete();

        return response()->json([
            'success' => $deleted
        ]);
    }
}
