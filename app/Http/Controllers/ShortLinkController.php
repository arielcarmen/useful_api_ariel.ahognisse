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

        $random_code = '';
        if (!$request->has('custom_code') ||  empty($request->custom_code)) {
            do {
                $random_code = fake()->regexify('[A-Za-z0-9_-]{10}');
                $existing_link = ShortLink::where('code', $random_code)->first();
            } while ($existing_link);
        }

        $shortlink = ShortLink::create([
            'original_url' => $request->original_url,
            'code' => $request->custom_code ?? $random_code,
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

    public function show(Request $request, string $code)
    {
        $shortlink = ShortLink::where('code', $code)->first();

        if (!$shortlink) {
            return response('Link not found', 404);
        }
        $shortlink = ShortLink::where('code', $code)->first();

        if (!$shortlink) {
            return response('Link not found', 404);
        }

        $shortlink->increment('clicks');

        return redirect($shortlink->original_url, 302);
    }

    public function delete(Request $request, int $id)
    {
        $shortlink = ShortLink::find($id);

        if (!$shortlink) {
            return response('Link not found', 404);
        }

        if ($shortlink->user_id !== Auth::id()) {
            return response('You can\'t delete this link', 403);
        }

        $shortlink->delete();

        return response(['message' => 'Link deleted successfully'], 200);
    }
}
