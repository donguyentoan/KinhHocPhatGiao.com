<?php

namespace App\Support;

final class ToolSlugs
{
    public const SLUG_TO_VIEW = [
        'may-niem-phat' => 'tools.may-niem-phat',
        'ngoi-thien' => 'tools.ngoi-thien',
        'lan-chuoi-hat' => 'tools.lan-chuoi-hat',
        'nhac-thien' => 'tools.nhac-thien',
        'su-kien-trong-nam' => 'tools.su-kien-trong-nam',
        'lien-he-ho-tro' => 'tools.lien-he-ho-tro',
        'doc-kinh' => 'tools.doc-kinh',
        'hai-loc-phap-cu' => 'tools.hai-loc-phap-cu',
        'truc-nghiem-phat-giao' => 'tools.truc-nghiem-phat-giao',
    ];

    /** @return list<string> */
    public static function all(): array
    {
        return array_keys(self::SLUG_TO_VIEW);
    }

    public static function isValid(string $slug): bool
    {
        return isset(self::SLUG_TO_VIEW[$slug]);
    }
}
