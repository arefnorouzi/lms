<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected OrderInterface $orderRepository;
    public function __construct(OrderInterface $orderRepository){
        $this->orderRepository = $orderRepository;
    }

    public function index(){
        try {
            $orders = $this->orderRepository->all_items();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $orders = null;
        }
        return view('admin.index', compact('orders'));
    }
}
