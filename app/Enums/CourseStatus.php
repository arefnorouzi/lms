<?php

namespace App\Enums;

enum CourseStatus: string {
    case RECORDEING = 'درحال ضبط';
    case COMPLETED = 'تکمیل شده';

    public function cssClass(): string {
        return match($this) {
            self::RECORDEING => 'text-red-500 bg-red-100 px-2 py-1 rounded',
            self::COMPLETED => 'text-green-500 bg-green-100 px-2 py-1 rounded',
        };
    }
}

