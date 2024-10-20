<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'published_year', 'genre', 'author_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public $rules = [
        'title' => 'required|string|max:255',
        'published_year' => 'nullable|integer',
        'genre' => 'nullable|string|max:255',
        'author_id' => 'nullable|exists:authors,id',
        'isbn' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:4096',
        'total_pages' => 'required|integer|min:1',
    ];

    public $feedback = [
        'title.required' => 'O campo título é obrigatório.',
        'title.string' => 'O campo título deve ser uma string.',
        'title.max' => 'O campo título não deve exceder 255 caracteres.',
        'published_year.integer' => 'O campo ano de publicação deve ser um número inteiro.',
        'genre.string' => 'O campo gênero deve ser uma string.',
        'genre.max' => 'O campo gênero não deve exceder 255 caracteres.',
        'author_id.exists' => 'O autor selecionado é inválido.',
        'isbn.string' => 'O campo ISBN deve ser uma string.',
        'isbn.max' => 'O campo ISBN não deve exceder 255 caracteres.',
        'description.string' => 'O campo descrição deve ser uma string.',
        'description.max' => 'O campo descrição não deve exceder 255 caracteres.',
        'cover_image.image' => 'A imagem da capa deve ser uma imagem.',
        'cover_image.mimes' => 'A imagem da capa deve ser um arquivo do tipo: jpeg, png, jpg ou svg.',
        'cover_image.max' => 'A imagem da capa não deve ser maior que 4MB.',
        'total_pages.required' => 'O campo número de páginas é obrigatório.',
        'total_pages.integer' => 'O campo número de páginas deve ser um número inteiro.',
        'total_pages.min' => 'O campo total de páginas deve ser no mínimo 1.',
    ];

}
