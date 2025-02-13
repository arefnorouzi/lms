<?php

namespace App\Http\Controllers;

use App\Interfaces\BrandInterface;
use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    protected BrandInterface $brandRepository;
    public function __construct(BrandInterface $brandRepository){
        $this->brandRepository = $brandRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $model = $this->brandRepository->all_items(per_page: 20);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $model = null;
        }
        return view('admin.brand.index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $request = $request->validated();
        $image = null;
        if (isset($request['image'])) {
            $image = $request['image'];
            $request['image'] = null;
        }
        try {
            $model = $this->brandRepository->store_item($request);
            if($image)
            {
                $name = $request['slug'] . '-' . time(). '.' . strtolower($image->getClientOriginalExtension());
                // Upload image
                $file_path = $image->storeAs('brands', $name, 'product');
                $model->image = '/uploads/' . $file_path;
                $model->update();
            }
            session()->flash('message', 'رکورد با موفقیت ثبت شد');
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        return redirect()->route('admin.brand.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $request = $request->validated();

        $image = null;
        if (isset($request['image'])) {
            $image = $request['image'];
            $request['image'] = $brand->image;
        }
        try {
            $this->brandRepository->update_item($brand->id, $request);
            $brand = $brand->refresh();
            if($image)
            {
                $name = $request['slug'] . '-' . time(). '.' . strtolower($image->getClientOriginalExtension());
                // Upload image
                $file_path = $image->storeAs('brands', $name, 'product');
                $brand->image = '/uploads/' . $file_path;
                $brand->update();
            }
            session()->flash('message', 'رکورد با موفقیت بروزرسانی شد');
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        return redirect()->route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
            return response()->json(status: 204);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], status: 400);
        }
    }

    public function restore(Brand $brand): object
    {
        try {
            $brand->restore();
            return response()->json(status: 204);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], status: 400);
        }
    }
}
