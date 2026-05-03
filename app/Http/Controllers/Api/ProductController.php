<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $products = Product::query()
            ->withCount('units')
            ->where('is_active', true)
            ->when(
                $request->filled('category'),
                fn ($query) => $query->where('category', $request->string('category')->toString())
            )
            ->orderBy('name')
            ->paginate(min((int) $request->integer('per_page', 12), 12))
            ->withQueryString();

        return ProductResource::collection($products);
    }

    public function show(string $slug): ProductResource
    {
        $product = Product::query()
            ->withCount('units')
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        return ProductResource::make($product);
    }
}
