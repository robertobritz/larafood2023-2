<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $repository;

    public function __construct(Product $product)
    {
        $this->repository = $product;

        $this->middleware(['can:products']); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->repository->latest()->paginate();

        return view('admin.pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateProduct $request)
    {   
        $data = $request->all();

        $tenant = auth()->user()->tenant;

        if ($request->hasFile('image') && $request->image->isValid()){
            $data['image'] = $request->image->store("tenants/{$tenant->uuid}/products", 'public');
        }

        $this->repository->create($data);

        return redirect()->route('products.index');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$product = $this->repository->find($id)) {
            return redirect()->back();
        }
        
        // dd($product);

        return view('admin.pages.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!$product = $this->repository->find($id)) {
            return redirect()->back();
        }

        return view('admin.pages.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateProduct $request, $id)
    {
        if (!$product = $this->repository->find($id)) {
            return redirect()->back();
        }

        $data = $request->all();

        $tenant = auth()->user()->tenant;

        if ($request->hasFile('image') && $request->image->isValid()){
            if (Storage::disk('public')->exists($product->image)){
                Storage::disk('public')->delete($product->image);
           }
        }
        $data['image'] = $request->image->store("tenants/{$tenant->uuid}/products", 'public');

        $product->update($data);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$product = $this->repository->find($id)) {
            return redirect()->back();
        }
        //dd($product->image);
        if (Storage::disk('public')->exists($product->image)){
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $products = $this->repository
                            ->where(function($query) use ($request) {
                                if($request->filter){
                                    $query->orWhere('description', 'LIKE',"%{$request->filter}%");
                                    $query->orWhere('title','LIKE',"%{$request->filter}%");
                                }

                            })
                            ->latest()
                            ->paginate();

        return view('admin.pages.products.index', compact('products', 'filters'));
    }
}
