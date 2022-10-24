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

    public $title, $author, $quantity, $cover, $isBind, $all,  $cid;
    public $show = false;
    public $update = false;
    public $modal = false;

    Public $search;

    // public $returned = true;

    public $binded = [];
    public $borrowed = [];
    public $data = [];

    protected $listeners = [
        'delete' => 'delete',
        'show' => 'alert'
    ];

    protected $rules = [
        'title' => 'required',
        'author' => 'required',
        'quantity' => 'required|int|min:1|max:2000',
        'cover' => 'nullable|url',
        'isBind' => 'required|boolean'
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

    public function save()
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

    public function edit($id)
    {
        $book = Book::findOrFail($id);

        $this->cid = $book->id;
        $this->title = $book->title;
        $this->author = $book->author;
        $this->quantity = $book->quantity;
        $this->cover = $book->cover;
        $this->isBind = $book->isBind;
        $this->update = true;
        $this->modal = true;
    }

    function update()
    {

        $cid = $this->cid;
        $book = $this->validate();
        $true = Book::find($cid)->update($book);

        $this->modal = false;

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Book Updated Successfully',
                'title' => 'Confirmed',
                'timer' => 2000,
            ]);
        }
    }

    // bind book
    function bind($id)
    {
        $book = Book::findOrFail($id);
        $this->cid = $book->id;
        $true = Book::find($this->cid)->update([
            'isBind' => true,
        ]);

        if ($true) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Book has been sent for binding',
                'title' => 'Binded',
                'timer' => 2000,
            ]);
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

    function overdue($id)
    {
        $data = Borrower::findOrFail($id);
        $data['status'] = 'overdue';

        $data['date_returned'] = null;

        $data->update();

        $user = User::where('id', auth()->user()->id)->update(['can_borrow' => false]);

        // check in increased
        if ($user) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Book marked for Payment Overdue',
                'title' => 'Overdue',
                'timer' => 2000,
            ]);
        }
    }


    public function confirmDelete($id)
    {

        $this->dispatchBrowserEvent('swal:success', [
            'icon' => 'success',
            'text' => 'Record deleted Successfully',
            'title' => 'Confirmed',
            'timer' => 2000
        ]);

        $this->delete($id);
    }

    public function delete($id)
    {
        Book::where('id', $id)->delete();
    }




    public function render()
    {
        $search = '%'. $this->search . '%';
        $this->all = Book::where('title', 'LIKE', $search)->orWhere('author', 'LIKE', $search)->orWhere('quantity', 'LIKE', $search)->get();
        $this->binded = Book::where('isBind',  true)->get();
        $available = Book::where('isBind',  false)->paginate($this->perPage);
        $this->borrowed = Borrower::all();

        $books = Book::where('isBind',  false)->paginate($this->perPage);
        $losts = Borrower::where('status',  'lost')->paginate($this->perPage);
        $overdues = Borrower::where('status',  'overdue')->paginate($this->perPage);
        $binds = Book::where('isBind',  true)->paginate($this->perPage);
        $borrowers = Borrower::where('status', 'LIKE', $search)->paginate($this->perPage);
        return view('livewire.books', compact(['books', 'binds', 'borrowers', 'available', 'losts', 'overdues']));
    }
}
