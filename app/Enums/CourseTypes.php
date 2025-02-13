<?php

namespace App\Enums;

enum CourseTypes: string
{
    case VIDEO = 'ویدیو';
    case COURSE = 'دوره';
    case PACKAGE = 'پکیج';
    case FILE = 'فایل';

    public function cssClass(): string {
        return match($this) {
            self::VIDEO => 'text-red-500 bg-red-100 px-2 py-1 rounded',
            self::COURSE => 'text-green-500 bg-green-100 px-2 py-1 rounded',
            self::PACKAGE => 'text-green-500 bg-green-100 px-2 py-1 rounded',
            self::FILE => 'text-green-500 bg-green-100 px-2 py-1 rounded',
        };
    }

}
