<?php

namespace App\Enums;

enum PaymentStatus: string {
    case PENDING = 'پرداخت نشده';
    case PAID = 'پرداخت شده';

    public function cssClass(): string {
        return match($this) {
            self::PENDING => 'text-red-500 bg-red-100 px-2 py-1 rounded',
            self::PAID => 'text-green-500 bg-green-100 px-2 py-1 rounded',
        };
    }
}
