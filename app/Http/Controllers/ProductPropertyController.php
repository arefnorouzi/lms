<?php

namespace App\Http\Controllers;

use App\Http\Requests\Property\StorePropertyRequest;
use App\Interfaces\ProductPropertyInterface;
use App\Models\ProductProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductPropertyController extends Controller
{
    protected ProductPropertyInterface $productProperty;
    public function __construct(ProductPropertyInterface $productProperty){
        $this->productProperty = $productProperty;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request)
    {
        $request = $request->validated();
        try {
            $model = $this->productProperty->store_item($request);
            return response()->json(['model' => $model], status: 201);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductProperty $productProperty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductProperty $productProperty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductProperty $productProperty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): object
    {

        try {
            ProductProperty::where('id', $id)->forceDelete();
            return response()->json(status: 204);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
