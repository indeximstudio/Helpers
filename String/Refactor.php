<?php

namespace Indeximstudio\Helpers\String;

class Refactor
{
    public static function createAlias(string $title): string
    {
        $title = str_replace([',', '.', '(', ')', '&', '   ', '  ', ' '], ['', '', '', '', '', '-', '-', '-'], $title);

        return strtolower($title);
    }
}
