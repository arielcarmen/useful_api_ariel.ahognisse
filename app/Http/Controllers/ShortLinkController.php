<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;

class ShortLinkController extends Controller
{
    public function index(Request $request)
    {
        $links = ShortLink::all();

        return response($links->map->only(['id', 'original_link','code', 'created_at']), 200);
    }

    public function shorten(Request $request) {

    }

    public function show(Request $request) {}

    public function delete(Request $request) {}
}
