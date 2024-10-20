<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::with('author')->get();
        return Inertia::render('Books/Index', [
            'books' => $books,
        ]);
    }


    public function create()
    {
        $userId = Auth::id();
        
        $authors = Author::where(function ($query) use ($userId) {

            $query->where('user_id', $userId)
                ->orWhere('user_id', null)
                ->orWhere('user_id', 0);
            }

        )->get();

        return Inertia::render('Books/Create', [
            'authors' => $authors,
        ]);
    }


    public function store(Request $request)
    {

        $book = new Book();

        $request->validate($book->rules, $book->feedback);

        $book->user_id = Auth::id();
        $book->title = $request->title;
        $book->published_year = $request->published_year;
        $book->total_pages = $request->total_pages;
        $book->pages_read = 0;
        $book->completed = false;
        $book->isbn = $request->isbn;
        $book->description = $request->description;
        $book->genre = $request->genre;
        $book->author_id = $request->author_id;

        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $imagePath = $request->file('cover_image')->store('cover_images', 'public');
            $book->cover = $imagePath;
        } else {
            $book->cover = 'img/default_book.png';
        }

        if($book->save()) {
            return redirect()->route('books.index')->with('success', 'Livro criado com sucesso!');
        } else {
            return false;
        }

    }


    public function show(Book $book)
    {
        return Inertia::render('Books/Show', [
            'book' => $book->load('author'),
        ]);
    }


    public function edit(Book $book)
    {
        $userId = Auth::id();
    
        $authors = Author::where(function ($query) use ($userId) {

            $query->where('user_id', $userId)
                ->orWhere('user_id', null)
                ->orWhere('user_id', 0);
            }

        )->get();

        return Inertia::render('Books/Edit', [
            'book' => $book,
            'authors' => $authors,
        ]);
    }


    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'genre' => 'nullable|string|max:255',
            'author_id' => 'required|exists:authors,id',
        ]);

        $book = Book::find($book->id)->where('user_id', Auth::id())->first()->get();

        if(!$book) {
            return redirect()->route('books.index')->with('error', 'Livro não encontrado.');
        }
    
        $book->update($request->all());
    
        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }


    public function destroy(Book $book)
    {
        $book = Book::find($book->id)->where('user_id', Auth::id())->first()->get();

        if(!$book) {
            return redirect()->route('books.index')->with('error', 'Livro não encontrado.');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro deletado com sucesso!');
    }


    public function updatePagesRead(Request $request, Book $book)
    {
        $request->validate([
            'pages_read' => 'required|integer|min:0',
        ]);

        $book_total_pages = $book->total_pages;

        if($request->pages_read > $book_total_pages) {
            return redirect()->back()->with('error', 'O número de páginas lidas não pode ser maior que o total de páginas do livro.');
        }

        $book->pages_read = $request->pages_read;
        $book->completed = $book->pages_read == $book->total_pages ? true : false;
        $book->save();

        if($book->completed) {
            return redirect()->route('books.index')->with('success', 'Parabéns! Você completou a leitura do livro!');
        } else {
            return redirect()->route('books.index')->with('success', 'Páginas atualizadas com sucesso!');
        }

    }


    public function updateImage(Request $request, Book $book)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('img'), $imageName);

        $book->image = $imageName;
        $book->save();

        return redirect()->route('books.index')->with('success', 'Imagem do livro atualizada com sucesso!');
    }


}
