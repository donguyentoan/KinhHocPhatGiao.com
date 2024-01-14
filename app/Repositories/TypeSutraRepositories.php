<?php

namespace App\Repositories;

use App\Models\Type;




class TypeSutraRepositories
{
    public function getAllTypeSutra()
    {
        return DB::table('sutraes')
            ->join('languages', 'sutraes.language_id', '=', 'languages.id')
            ->select('sutraes.language_id', 'languages.name')
            ->get();
    }
    public function getTypeSutraByID($id)
    {
        return Type::find($id);
    }

    
}