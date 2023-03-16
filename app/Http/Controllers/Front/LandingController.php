<?php

namespace App\Http\Controllers\Front;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function index()
    {
        $items = Item::with(['type', 'brand'])->latest()->take(4)->get()->reverse();

        return view('landing', [
            'items' => $items
        ]);
    }
}
