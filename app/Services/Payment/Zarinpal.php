<?php

namespace App\Services\Payment;

use App\Enums\OrderStatuses;
use Illuminate\Support\Facades\Log;

class Zarinpal
{

    public function create_payment($order)
    {
        $data = array("merchant_id" => "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx",
            "amount" => intval($order->amount * 10),
            "callback_url" => route('zarinpal_callabck'),
            "description" => "فاکتور $order->id",
            "metadata" => ["orderId" => $order->uuid, "mobile" => $order->user->mobile],
        );
        $jsonData = json_encode($data);
        $response = self::curl_request(action_name: 'request', data: $jsonData);
        if($response && empty($response['errors']) && $response["data"]["code"] == 100)
        {
            $order->bank_trans_id = $response['data']["authority"];
            $order->status = OrderStatuses::PROCESSING->value;
            $order->update();
            return $response['data']["authority"];
        }
        return false;
    }

    public function verify($Authority, $order)
    {
        $data = array(
            "merchant_id" => "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx",
            "authority" => $Authority, "amount" => intval($order->amount * 10)
        );
        $jsonData = json_encode($data);
        $response = self::curl_request(action_name: 'verify', data: $jsonData);
        if($response && empty($response['errors']) && $response["data"]["code"] == 100)
        {
            Log::info("callback was ok");
            $order->bank_payment_code = $response['data']["ref_id"];
            $order->status = OrderStatuses::PAID->value;
            $order->purchased_at = now();
            $order->update();
            return true;
        }
        return false;
    }


    protected function curl_request(string $action_name, $data)
    {
        $ch = curl_init("https://sandbox.zarinpal.com/pg/v4/payment/$action_name.json");
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ));
        try {
            $result = curl_exec($ch);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return null;
        }
        $err = curl_error($ch);
        if ($err){
            Log::error($err);
        }
        Log::info("result is ok");
        Log::info($result);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);
        curl_close($ch);

        return $result;
    }
}
