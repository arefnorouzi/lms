<?php

namespace App\Http\Controllers\Payment;

use App\Enums\OrderStatuses;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Payment\Zarinpal;
use App\Services\sms\Melipayamak;
use App\Services\SmsSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZarinpalController extends Controller
{
    public function pay(Order $order)
    {
        if ($order->user_id != auth()->id() || in_array($order->status, [OrderStatuses::PAID->value, OrderStatuses::SHIPPED->value]))
        {
            abort(code: 403);
        }

        try {
            $zarinpal_service = new Zarinpal();
            $trans_id = $zarinpal_service->create_payment($order);
            if($trans_id)
            {
                //return redirect('https://www.zarinpal.com/pg/StartPay/' . $trans_id);
                return redirect('https://sandbox.zarinpal.com/pg/StartPay/' . $trans_id);
            }
            else
            {
                Log::error("transId is: $trans_id");
            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }
        return redirect('/order/' . $order->uuid);
    }

    public function callback(Request $request)
    {
        if (isset($request['Authority']) && strlen($request['Authority']) > 5)
        {
            $Authority = trim($request['Authority']);
            try {
                $order = Order::where([['bank_trans_id', '=', $Authority], ['status', '=', OrderStatuses::PROCESSING->value]])
                    ->firstOrFail();
                $zarinpal_service = new Zarinpal();
                $bool_response = $zarinpal_service->verify($Authority, $order);
                if($bool_response)
                {
                    $body_id = 299846;

                    if ($order->user->mobile)
                    {
                        $sms_service = new Melipayamak(
                            body_id: $body_id, to: $order->user->mobile,
                            args: array($order->customer_name, str($order->id))
                        );
                        $sms_service->send_sms();
                    }
                    return redirect('/order/' . $order->uuid)->with('message', 'فاکتور با موفقیت پرداخت شد');
                }
                return redirect('/order/' . $order->uuid)->with('error', 'متاسفانه پرداخت با خطا مواجه شد');
            }
            catch (\Exception $e)
            {
                Log::error($e->getMessage());
            }
            return redirect('/order')->with('error', 'متاسفانه پرداخت با خطا مواجه شد');

        }
        abort(code: 403);
    }
}
