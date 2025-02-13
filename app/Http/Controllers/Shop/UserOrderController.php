<?php

namespace App\Http\Controllers\Shop;

use App\Enums\OrderStatuses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Interfaces\OrderInterface;
use App\Interfaces\ShippingInterface;
use App\Models\Order;
use App\Services\Invoice\InvoiceService;
use Illuminate\Support\Facades\Log;

class UserOrderController extends Controller
{
    protected OrderInterface $orderRepository;
    protected ShippingInterface $shippingRepository;
    public function __construct(OrderInterface $orderRepository, ShippingInterface $shippingRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->shippingRepository = $shippingRepository;
    }

    public function index()
    {
        try {
            $orders = $this->orderRepository->user_orders(user_id: auth()->id());
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $orders = null;
        }
        return view('order.index', compact('orders'));
    }

    public function show(string $uuid)
    {
        $uuid = trim($uuid);
        try {
            $order = $this->orderRepository->user_order(user_id: auth()->id(), uuid: $uuid);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect('/order')->with('error', 'فاکتور پیدا نشد');
        }
        $order->load('order_items');
        try {
            $shipping_methods = $this->shippingRepository->select_items();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $shipping_methods = [];
        }
        $user = [
            "name" => auth()->user()->name,
            "mobile" => auth()->user()->mobile,
            "address" => auth()->user()->address,
            "zip_code" => auth()->user()->zip_code,
        ];
        return view('order.show', compact(
            'order', 'shipping_methods', 'user'
        ));
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $invoice_service = new InvoiceService(user_id: auth()->id());
            $order = $invoice_service->generate_invoice();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(status: 400);
        }
        if ($order)
        {
            Log::info($order["uuid"]);
            return response()->json(['order_id' => $order["uuid"]], status: 201);
        }
        return response()->json(status: 400);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $request = $request->validated();
        if($order->user_id != auth()->id())
        {
            return response()->json(status: 403);
        }
        if (in_array($order->status, array(OrderStatuses::SHIPPED->value, OrderStatuses::PAID->value)))
        {
            return response()->json(status: 403);
        }
        try {
            $shipping_method = $this->shippingRepository->find_active_item(id: $request['shipping_method']);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['error' => 'لطفا روش ارسال را انتخاب نمایید'], status: 400);
        }
        $user = auth()->user();

        try {
            $user->name = $request['name'];
            $user->address = $request['address'];
            $user->zip_code = $request['zip_code'];
            $user->update();
            $order->customer_address = $request['address'];
            $order->customer_phone = $request['phone'];
            $order->customer_zip_code = $request['zip_code'];
            $order->customer_name = $request['name'];
            $order->shipping_method_id = $shipping_method->id;
            $order->shipping_cost = $shipping_method->price;
            $order->amount = intval($order->total + $shipping_method->price);
            $order->update();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['error' => 'خطایی در بروزرسانی فاکتور رخ داد'], status: 400);
        }

        return response()->json(['message' => 'فاکتور آماده پرداخت است']);
    }
}
