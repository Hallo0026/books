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
        $books = Book::with('author')->where('user_id', Auth::id())->get();
        return Inertia::render('Books/Index', [
            'books' => $books,
        ]);
    }


    public function create()
    {
        $authors = Author::all();
        return Inertia::render('Books/Create', [
            'authors' => $authors,
        ]);
    }


    public function store(Request $request)
    {

        $book = new Book();

        $request->validate([
            'title' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'genre' => 'nullable|string|max:255',
            'author_id' => 'nullable|exists:authors,id',
        ]);

        $book->user_id = Auth::id();
        $book->title = $request->title;
        $book->published_year = $request->published_year;
        $book->genre = $request->genre;
        $book->author_id = $request->author_id;
        $book->save();

        return to_route('books.index');

        //return redirect()->route('books.index')->with('success', 'The book was created successfully!');
    }


    public function show(Book $book)
    {
        return Inertia::render('Books/Show', [
            'book' => $book->load('author'),
        ]);
    }


    public function edit(Book $book)
    {
        $authors = Author::all();
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
    
        $book->update($request->all());
    
        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }


    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}
