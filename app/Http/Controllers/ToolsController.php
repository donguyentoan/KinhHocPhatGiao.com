<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ToolsController extends Controller
{
    private const SLUG_TO_VIEW = [
        'may-niem-phat' => 'tools.may-niem-phat',
        'ngoi-thien' => 'tools.ngoi-thien',
        'chuong-mo' => 'tools.chuong-mo',
        'lan-chuoi-hat' => 'tools.lan-chuoi-hat',
        'nhac-thien' => 'tools.nhac-thien',
        'su-kien-trong-nam' => 'tools.su-kien-trong-nam',
        'lien-he-ho-tro' => 'tools.lien-he-ho-tro',
    ];

    public function show(string $slug): View
    {
        if (! isset(self::SLUG_TO_VIEW[$slug])) {
            abort(404);
        }

        return view(self::SLUG_TO_VIEW[$slug]);
    }
}
