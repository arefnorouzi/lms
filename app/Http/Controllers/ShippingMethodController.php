<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shipping\UpdateShippingRequest;
use App\Interfaces\ShippingInterface;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShippingMethodController extends Controller
{
    protected ShippingInterface $shippingRepository;
    public function __construct(ShippingInterface $shippingRepository){
        $this->shippingRepository = $shippingRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $model = $this->shippingRepository->get_items();
        }
        catch (\Exception $e)
        {
            $model = null;
        }
        return view('admin.shipping.index', compact('model'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingMethod $shippingMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingMethod $shippingMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShippingRequest $request, ShippingMethod $shipping)
    {
        $request = $request->validated();
        try {
            $shipping->update($request);
            session()->flash('message', 'ایتم با موفقیت بروزرسانی شد');
        }catch (\Exception $e)
        {
            session()->flash('error', $e->getMessage());

        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingMethod $shippingMethod)
    {
        //
    }
}
