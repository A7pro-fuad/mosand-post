<?php

namespace App\Enums;



enum CategoryEnum: string
{
    case Blog = 'blog';
    case News = 'news';
    case Tutorials = 'tutorials';


    public function getLabel(): string
    {
        return match ($this) {
            self::Blog => 'blog',
            self::News => 'news',
            self::Tutorials => 'tutorials',
        };
    }

    public static function toArray(): array
    {
        return array_column(CategoryEnum::cases(), 'value', 'value');
    }
}
