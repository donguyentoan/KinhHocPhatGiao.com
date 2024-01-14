<?php

namespace App\Repositories;


use App\Models\Athor;
use Illuminate\Support\Facades\DB;



class AuthorSutraRepositories
{
    public function getAuthor()
    {
        $author = Athor::All();

        return $author;

    }
    public function getAuthorByID($id)
    {
        $author = Athor::find($id);

        return $author;

    }

    public function create(array $data){

        $file = $data['image'];
        $fileName = time() . $file->getClientOriginalName();
        $path = 'productsphotos';
        $file->move($path, $fileName);

        $authorData = [
            'name' => $data['name'],
            'information' => $data['information'],
            'image' => $fileName,
        ];

        $athor = Athor::create($authorData);

        return $athor;

    }
}