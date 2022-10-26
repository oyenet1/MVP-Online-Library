<?php

namespace App\Http\Livewire;

use App\Models\Bind;
use App\Models\Book;
use App\Models\User;
use Livewire\Component;
use App\Models\Borrower;
use Livewire\WithPagination;

class Books extends Component
{

    use WithPagination;

    public $perPage = 10;

    // types of book

    public  $cid;
    public $show = false;
    public $update = false;
    public $modal = false;

    public $search;

    public $data = [];

    protected $listeners = [
        'delete' => 'delete',
        'show' => 'alert'
    ];

    // refreshinputs after saved
    function refreshInputs()
    {
        $this->title = '';
        $this->author = '';
        $this->quantity = '';
        $this->cover = '';
        $this->isBind = '';
    }

    // show modal
    public function show()
    {
        $this->modal = true;
    }

    public function borrow()
    {
        $data = $this->validate();
        $saved = Book::create($data);

        $this->modal = false;

        if ($saved) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Record saved Successfully',
                'title' => 'Confirmed',
                'timer' => 2000,
            ]);

            $this->refreshInputs();
        }
    }

    // returning binding books
    function return($id)
    {
        $book = Book::findOrFail($id);
        $this->cid = $book->id;
        $true = Book::find($this->cid)->update([
            'isBind' => false,
        ]);

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Book has been returned',
                'title' => 'Returned',
                'timer' => 4000,
            ]);
        }
    }

    // returns book borrows
    function returnBook($id)
    {
        $data = Borrower::findOrFail($id);
        $data['status'] = 'returned';
        $data['date_returned'] = date('Y-m-d H:i:s');

        $data->update();

        $book = Borrower::find($id)->book()->first();
        $true = $book->increment('quantity');

        $user = User::where('id', $data->user_id)->update(['can_borrow' => true]);

        // check in increased
        if ($true && $user) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Book has been returned',
                'title' => 'Marked Return',
                'timer' => 2000,
            ]);
        }
    }

    function lost($id)
    {
        $data = Borrower::findOrFail($id);
        $data['status'] = 'lost';
        $data['date_lost'] = date('Y-m-d H:i:s');

        $data->update();

        $user = User::where('id', auth()->user()->id)->update(['can_borrow' => false]);

        // check in increased
        if ($user) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Book has been reported Lost',
                'title' => 'Lost',
                'timer' => 2000,
            ]);
        }
    }




    public function render()
    {
        $term = '%' . $this->search . '%';
        $books = Book::where('authors', 'LIKE', $term)->orWhere('title', 'LIKE', $term)->orWhere('isbn', 'LIKE', $term)->orWhere('published_at', 'LIKE', $term)->paginate(5);
        return view('livewire.books', compact(['books']));
    }
}