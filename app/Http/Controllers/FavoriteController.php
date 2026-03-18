<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle($id) {
        $user = auth()->user();
        $result = $user->favorites()->toggle($id);
        return response()->json([
            'status' => count($result['attached']) ? 'added' : 'removed'
            ]);
    }
}
