<?php

namespace App\Http\Controllers;

use App\Models\Sutraes;
use Illuminate\Http\Request;
use App\Repositories\SutraRepositories;
use App\Repositories\AuthorSutraRepositories;

class homeController extends Controller
{
    public function __construct(SutraRepositories $sutraRepository ,  AuthorSutraRepositories $authorsutraRepository  )
    {
        $this->sutraRepository = $sutraRepository;
        $this->authorsutraRepository = $authorsutraRepository;
       

    }
    
    public function index()
    {
        // $sutras = $this->sutraRepository->getAllSutra();
        $sutraslimitDeDu = Sutraes::paginate(8);
        $sutraslimitCapNhap = Sutraes::paginate(6);

      
        return view('home' , ['sutras' => $sutraslimitCapNhap , "sutraslimit" => $sutraslimitDeDu ]);

    }
    public function getByID($id)
    {
        $sutra = Sutraes::findOrFail($id);
        $contentChunks = explode('**', $sutra->content);
        return view('sutraDetail', compact('sutra', 'contentChunks'));
    }
}
