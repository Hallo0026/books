<?php

namespace App\Http\Controllers;

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
        $authors = Author::all();
        return Inertia::render('Books/Create', [
            'authors' => $authors,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'genre' => 'nullable|string|max:255',
            'author_id' => 'nullable|exists:authors,id',
        ]);

        Book::create($request->all());

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
