<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatuses;
use App\Http\Requests\Order\OrderStatusRequest;
use App\Interfaces\OrderInterface;
use App\Interfaces\ShippingInterface;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ZanySoft\LaravelPDF\Facades\PDF;

class OrderController extends Controller
{
    protected OrderInterface $orderRepository;
    protected ShippingInterface $shippingRepository;
    public function __construct(OrderInterface $orderRepository, ShippingInterface $shippingRepository){
        $this->orderRepository = $orderRepository;
        $this->shippingRepository = $shippingRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $model = $this->orderRepository->all_items(per_page: 20);
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            $model = [];
        }
        return view('admin.order.index', compact('model'));
    }

    public function archive()
    {
        try {
            $model = $this->orderRepository->all_items(per_page: 20);
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            $model = [];
        }
        return view('admin.order.archive', compact('model'));
    }

    public function print_orders(Request $request)
    {
        $invoiceIds = $request->input('invoice_ids', []);
        if (empty($invoiceIds)) {
            return redirect()->back()->with('error', 'No invoices selected.');
        }
        $invoices = Order::whereIn('id', $invoiceIds)->get();

        $pdf = PDF::loadView('invoices.multi', compact('invoices'), [
            'format' => 'A6'
        ]);

        return $pdf->download('multiple_invoices.pdf');
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
    public function show(Order $order)
    {

        try {
            $order->load(['order_items', 'user:id,name:mobile']);
            $statuses = OrderStatuses::cases();
            $shipping_methods = $this->shippingRepository->select_items();
        }
        catch (\Exception $e){
            session()->flash('error', $e->getMessage());
            return redirect()->route('admin.order.index');
        }
        return view('admin.order.show', compact('order', 'statuses', 'shipping_methods'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderStatusRequest $request, Order $order)
    {
        $request = $request->validated();
        try {
            $this->orderRepository->update_item($order->id, $request);
            session()->flash('message', "وضعیت فاکتور به: " . $request['status'] . " تغییر یافت");
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            session()->flash('error', $e->getMessage());
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        if (
            in_array($order->status, [OrderStatuses::PENDING->value, OrderStatuses::PROCESSING->value]) &&
            $order->purchased_at == null && $order->bank_payment_code == null
        ){
            try {
                $order->delete();
                session()->flash('message', 'آیتم با موفقیت حذف شد');
            }
            catch (\Exception $e)
            {
                session()->flash('error', $e->getMessage());
            }
            return redirect()->back();
        }
        session()->flash('error', 'امکان حذف آیتم وجود ندارد');
        return redirect()->back();
    }
}
