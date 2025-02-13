<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\RemoveFromCartRequest;
use App\Interfaces\CartInterface;
use App\Interfaces\ProductInterface;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected CartInterface $cartRepository;
    protected ProductInterface $productRepository;
    public function __construct(CartInterface $cartRepository, ProductInterface $productRepository){
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function index(){
        try {
            $cart = $this->cartRepository->user_cart(user_id: auth()->id());
            $cart->load('cart_items');
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $cart = null;
        }
        return view('cart.index', compact('cart'));
    }

    public function add(AddToCartRequest $request): object
    {
        $request = $request->validated();
        try{
            $product = $this->productRepository->find_for_add_to_cart(product_id: $request['product_id']);
            $price = $product->price;
            if($product->offer_price && $product->offer_end_date > today()->format('Y-m-d')){
                $price = $product->offer_price;
            }
            $response = $this->cartRepository->add_to_cart(user_id: auth()->id(),data: [
                'qty' => $request['qty'],
                'product_id' => $product->id,
                'unit_price' => $price,
            ]);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(status: 400);
        }
        if($response)
        {
            return response()->json(status: 201);
        }
        return response()->json(status: 400);
    }

    public function remove(RemoveFromCartRequest $request): object
    {
        $request = $request->validated();
        try{
            $this->cartRepository->remove_from_cart(user_id: auth()->id(), item_id: $request['item_id']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(status: 400);
        }
        return response()->json(status: 204);
    }
}
