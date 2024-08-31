<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Book extends Model
{
    use HasFactory;

    //protected $fillable = ['title', 'published_year', 'genre', 'author_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_books')
                    ->withPivot('is_read')
                    ->withTimestamps();
    }


}
