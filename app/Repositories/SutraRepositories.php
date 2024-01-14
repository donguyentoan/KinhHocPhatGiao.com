<?php

namespace App\Repositories;

use App\Models\Sutraes;
use Illuminate\Support\Facades\DB;



class SutraRepositories
{
    public function getAllSutra()
    {
        return  DB::table('sutraes')
        ->join('types', 'sutraes.type_id', '=', 'types.id')
        ->join('languages', 'sutraes.language_id', '=', 'languages.id')
        ->join('athors', 'sutraes.athor_id', '=', 'athors.id')
        ->select('sutraes.id' ,'sutraes.image', 'sutraes.name', 'sutraes.content', 'types.name as type_name', 'languages.name as language_name', 'athors.name as athors_name')
        ->get();

    }
    public function getAllSutraAD()
    {
        return  DB::table('sutraes')
        ->join('types', 'sutraes.type_id', '=', 'types.id')
        ->join('languages', 'sutraes.language_id', '=', 'languages.id')
        ->join('athors', 'sutraes.athor_id', '=', 'athors.id')
        ->select('sutraes.id' ,'sutraes.image', 'sutraes.name', 'sutraes.content', 'types.name as type_name', 'languages.name as language_name', 'athors.name as athors_name')
        ->paginate(5);

    }

    public function getSutraByID($sutraId)
    {
        return DB::table('sutraes')
        ->join('types', 'sutraes.type_id', '=', 'types.id')
        ->join('languages', 'sutraes.language_id', '=', 'languages.id')
        ->join('athors', 'sutraes.athor_id', '=', 'athors.id')
        ->select('sutraes.id' ,'sutraes.image', 'sutraes.name', 'sutraes.content', 'types.name as type_name', 'languages.name as language_name', 'athors.name as athors_name')
        ->where('sutraes.id', $sutraId)
        ->first();

    }
    public function removeSutraByID($sutraId)
    {
        return DB::table('sutraes')->where('id', $sutraId)->delete();

    }


    public function splitText($text, $max_length)
     {
    $words = explode(" ", $text);
    $result = [];
    $current_line = "";

    foreach ($words as $word) {
        if (strlen($current_line) + strlen($word) <= $max_length) {
            if (!empty($current_line)) {
                $current_line .= " ";
            }
            $current_line .= $word;
        } else {
            $result[] = $current_line;
            $current_line = $word;
            }
        }

        if (!empty($current_line)) {
            $result[] = $current_line;
        }

            return $result;
        

    }

    public function create(array $data)
    {
        $file = $data['image'];
        $fileName = time() . $file->getClientOriginalName();
        $path = 'productsphotos';
        $file->move($path, $fileName);


        $max_size = 1750;
        $output_array = $this->splitText($data['content'], $max_size);
        $joined_text = implode("**", $output_array);
        
        $productData = [
            'name' => $data['name'],
            'content' => $joined_text,
            'language_id' => $data['language_id'],
            'athor_id' => $data['athor_id'],
            'type_id' => $data['type_id'],
            'image' => $fileName,
        ];

        $Sutra = Sutraes::create($productData);

        return $Sutra;
    }

    
}