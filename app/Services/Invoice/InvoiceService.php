<?php

namespace App\Services\Invoice;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InvoiceService
{
    protected int $user_id;
    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @throws \Exception
     */
    public function generate_invoice(): object | null
    {
        try {
            DB::beginTransaction();

            // Find or create a cart for the user
            $cart = Cart::where([['user_id', '=', $this->user_id], ['status', '=', 0]])->firstOrFail();

            // Check if the item already exists in cart_items
            $cart->load('cart_items');
            if($cart->cart_items->isEmpty() || $cart->cart_items->count() == 0){
                return null;
            }
            $amount = 0;
            foreach ($cart->cart_items as $cart_item) {
                $amount += $cart_item->unit_price * $cart_item->qty;
            }
            if ($amount <= 0) {
                return null;
            }
            $order = Order::create([
               'user_id' => $this->user_id,
               'total' => $amount,
               'amount' => $amount,
               'uuid' => Str::uuid(),
            ]);
            foreach ($cart->cart_items as $cart_item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart_item->product_id,
                    'unit_price' => $cart_item->unit_price,
                    'qty' => $cart_item->qty,
                    'product_name' => $cart_item->product->name,
                    'product_price' => $cart_item->product->price,
                    'product_image' => $cart_item->product->thambnail ?? $cart_item->product->image,
                ]);
                $cart_item->delete();
            }
            $cart->delete();


            DB::commit(); // Commit the transaction

            return $order;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback in case of error
            Log::error($e->getMessage());
            return null;
        }
    }

}
