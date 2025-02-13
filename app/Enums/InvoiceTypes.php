<?php

namespace App\Enums;

enum InvoiceTypes: string {
    case DEPOSIT = 'واریز';
    case CASH_BACK = 'کش بک';
    case WITHDRAW = 'برداشت';

    public function cssClass(): string {
        return match($this) {
            self::DEPOSIT => 'text-red-500 bg-red-100 px-2 py-1 rounded',
            self::CASH_BACK => 'text-red-500 bg-red-100 px-2 py-1 rounded',
            self::WITHDRAW => 'text-green-500 bg-green-100 px-2 py-1 rounded',
        };
    }
}
