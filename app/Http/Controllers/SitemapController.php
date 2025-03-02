<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        // static pages
        $staticUrls = [
            ['loc' => url('/'), 'lastmod' => now()->toAtomString()],
            ['loc' => url('/about'), 'lastmod' => now()->toAtomString()],
            ['loc' => url('/contact'), 'lastmod' => now()->toAtomString()],
        ];

        //posts
        $posts = Post::active()->latest()->get(["sku", "updated_at"])->map(function ($post) {
            return [
                'loc' => url('/blog/article/' . $post->sku),
                'lastmod' => $post->updated_at->toAtomString(),
            ];
        });

        // products
        $products = Product::active()->latest()->get(["sku", "updated_at"])
            ->map(function ($product) {
            return [
                'loc' => url('/shop/product/' . $product->sku),
                'lastmod' => $product->updated_at->toAtomString(),
            ];
        });

        // merge urls
        $urls = array_merge($staticUrls, $posts->toArray(), $products->toArray());

        // sitemap conent
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . $url['loc'] . '</loc>';
            $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
