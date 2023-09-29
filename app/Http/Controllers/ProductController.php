<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

use Inertia\Response;

class ProductController extends Controller
{
    public function __construct(public ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $products = Product::all();
        return Inertia::render('Product/ProductIndexComponent', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Product/ProductCreateComponent');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->productService->store(auth()->user(), $request->validated(), $request->file);
        return redirect()->route('products.index')->with('message', 'Created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): Response
    {
        return Inertia::render('Product/ProductEditComponent', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->productService->update($product, $request->validated(), $request->file);
        return redirect()->route('products.index')->with('message', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->file()->delete();
        $product->delete();
        sleep(1);
        return redirect()->route('products.index')->with('message', 'Deleted successfully');
    }
}
