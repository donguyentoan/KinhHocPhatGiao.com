<?php

namespace App\Http\Controllers;


use App\Models\Sutraes;
use Illuminate\Http\Request;
use App\Repositories\SutraRepositories;
use Illuminate\Support\Facades\Storage;
use App\Repositories\AuthorSutraRepositories;

class SutraController extends Controller
{
    protected $sutraRepository;

    public function __construct(SutraRepositories $sutraRepository ,  AuthorSutraRepositories $authorsutraRepository  )
    {
        $this->sutraRepository = $sutraRepository;
        $this->authorsutraRepository = $authorsutraRepository;
       

    }
    

    public function index()
    {
        
        $sutras = $this->sutraRepository->getAllSutraAD();

      
        return view('kinhPhat' , ['sutras' => $sutras]);

    }

    public function getByID($id)
    {
        $sutra = Sutraes::findOrFail($id);
        $contentChunks = explode('**', $sutra->content);
        return view('sutraDetail', compact('sutra', 'contentChunks'));
    }
    public function addSutra()
    {
        $authorsutras = $this->authorsutraRepository->getAuthor();
        return view('add' , ["authorsutras" => $authorsutras ]);
    }

    public function store(Request $request)
    {
      
        $validatedData = $request->validate([
            'name' => 'required',
            'content' => 'required',
            'language_id' => 'required',
            'athor_id' => 'required',
            'type_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = $this->sutraRepository->create($validatedData);

        return redirect()->route('index');
        
    }
    public function removeByID($id) {
        
        $sutras = $this->sutraRepository->removeSutraByID($id);
        return redirect('/dashboard');
      
    }
}
