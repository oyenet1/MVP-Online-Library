<?php

namespace App\Http\Livewire;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class AllBooks extends Component
{
    use WithPagination;
    
    public function render()
    {
        $books = Book::paginate(7);
        return view('livewire.all-books', compact(['books']));
    }
}
