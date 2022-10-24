<?php

namespace App\Http\Livewire;

use App\Models\Book;
use App\Models\User;
use Livewire\Component;
use App\Models\Borrower;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;

class Borrows extends Component
{
    use WithPagination;
    public $data = [];
    public $perPage = 24;
    public $modal = false;
    public $collection = [];

    public $search;
    public $sort = 'asc';


    function borrow($id)
    {
        if (Gate::allows('borrow',)) {
            $book = Book::findOrFail($id);

            $this->data['user_id'] = auth()->user()->id;
            $this->data['book_id'] = $book->id;
            $this->data['date_borrowed'] = date('Y-m-d H:i:s');
            $this->data['status'] = 'reading';

            Borrower::create($this->data);

            // decrease the quantity of book by 1
            Book::find($book->id)->decrement('quantity');

            // update user can borrow field
            $user = User::where('id', auth()->user()->id)->update(['can_borrow' => false]);


            if ($user) {
                $this->dispatchBrowserEvent('swal:success', [
                    'icon' => 'success',
                    'text' => 'Book borrowed Successfully',
                    'title' => 'Borrowed',
                    'timer' => 2000
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'error',
                'text' => 'You have an outstanding book or payment',
                'title' => 'Access Denied',
                'button' => true,
                'dangerMode' => true
            ]);
        }
    }


    public function render()
    {
        $search = '%' . $this->search . '%';
        $collections = Book::where('title', 'LIKE', $search)->orWhere('author', 'LIKE', $search)->orderBy('updated_at', 'desc')->paginate($this->perPage);
        return view('livewire.borrows', compact(['collections']));
    }
}
