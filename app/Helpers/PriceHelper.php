<?php
if (!function_exists('format_price')) {
    function format_price($amount, $decimal = 2)
    {
        $formattedAmount = $amount;
        switch ($amount) {
            case $amount > 1000000:
                $formattedAmount = round(floatval($amount / 1000000), $decimal);
                return $formattedAmount . ' میلیون ';
            case $amount > 100000:
                $formattedAmount = round(floatval($amount / 1000), $decimal);
                return $formattedAmount . ' هزار';
            default:
                return number_format($amount);
        }
    }
}
