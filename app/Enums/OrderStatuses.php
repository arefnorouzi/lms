<?php

namespace App\Enums;

enum OrderStatuses: string
{
    case PENDING = 'پرداخت نشده';
    case PROCESSING = 'درحال پردازش';
    case PAID = "پرداخت شده";

    case SHIPPED = "ارسال شده";

    public function cssClass(): string {
        return match($this) {
            self::PENDING => 'text-red-500 bg-red-100 px-2 py-1 rounded',
            self::PROCESSING => 'text-red-500 bg-red-100 px-2 py-1 rounded',
            self::PAID => 'text-green-500 bg-green-100 px-2 py-1 rounded',
            self::SHIPPED => 'text-green-500 bg-green-100 px-2 py-1 rounded',
        };
    }


}
