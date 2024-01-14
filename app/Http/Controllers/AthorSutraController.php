<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AuthorSutraRepositories;

class AthorSutraController extends Controller
{
   
    protected $authorsutraRepository;

    public function __construct( AuthorSutraRepositories $authorsutraRepository )
    {
        $this->authorsutraRepository = $authorsutraRepository;
       

    }
    public function showAuthor()
    {
        $authorsutras = $this->authorsutraRepository->getAuthor();

      
        return view('author' , ['author' => $authorsutras]);

    }
    public function showIF($id)
    {
        $authorsutra = $this->authorsutraRepository->getAuthorByID($id);

      
        return view('authorIF' , ['author' => $authorsutra]);

    }

    public function index()
    {
        
        $authorsutras = $this->authorsutraRepository->getAuthor();

      
        return view('tacGia' , ['author' => $authorsutras]);

    }

    public function addAuthorSutra()
    {
        return view('addAuthor');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'information' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            
        ]);

        $product = $this->authorsutraRepository->create($validatedData);

        return redirect()->route('author');
    }

    
    
}
