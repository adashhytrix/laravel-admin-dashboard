<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminCatalogController extends Controller
{
    // GET /api/admin/categories
    public function categories(Request $request)
    {
        if (!$request->user()->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin access required.',
            ], 403);
        }

        $query = Category::query()
            ->withCount('products');

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query
            ->latest()
            ->paginate(
                min(max((int) $request->input('per_page', 10), 1), 100)
            );

        return response()->json([
            'success' => true,
            'message' => 'Categories fetched successfully.',
            'data' => $categories->items(),
            'pagination' => [
                'current_page' => $categories->currentPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
                'last_page' => $categories->lastPage(),
            ],
        ], 200);
    }
    public function storeProduct(Request $request)
    {
        if (!$request->user()->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin access required.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'alpha_dash',
                'unique:products,slug',
            ],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'status' => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $validated['slug'] = $validated['slug']
            ?? Str::slug($validated['name']);

        // Ensure the generated slug is unique too.
        if (
            !isset($validator->validated()['slug']) &&
            Product::where('slug', $validated['slug'])->exists()
        ) {
            $validated['slug'] .= '-' . Str::lower(Str::random(6));
        }

        $product = Product::create($validated);

        $product->load('category:id,name');

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
            'data' => $product,
        ], 201);
    }
    }
