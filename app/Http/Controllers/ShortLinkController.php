<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlShortenRequest;
use Illuminate\Http\Request;
use App\Models\ShortLink;
use Illuminate\Support\Facades\Auth;

class ShortLinkController extends Controller
{
    public function index(Request $request)
    {
        $links = Auth::user()->links;

        return response($links->map->only(['id', 'original_url', 'code', 'clicks', 'created_at']), 200);
    }

    public function shorten(UrlShortenRequest $request)
    {
        $request->validated();

        $shortlink = ShortLink::create([
            'original_url' => $request->original_url,
            'code' => $request->custom_code ?? fake()->regexify('[A-Za-z0-9_]{10}'),
            'user_id' => Auth::id(),
        ]);

        $data = [
            'id' => $shortlink->id,
            'user_id' => $shortlink->user_id,
            'original_url' => $shortlink->original_url,
            'code' => $shortlink->code,
            'created_at' => $shortlink->created_at,
        ];

        return response($data, 201);
    }

    public function show(Request $request) {}

    public function delete(Request $request) {}
}
