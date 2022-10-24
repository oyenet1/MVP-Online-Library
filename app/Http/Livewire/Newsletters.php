<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Newsletter;
use GuzzleHttp\Promise\Create;

class Newsletters extends Component
{

    public $email;

    public function refreshInput(){
        $this->email = '';
    }

public function subscribe()
{
    $data = $this->validate([
        'email' => 'required|email|unique:newsletters'
    ]);

   Newsletter::updateOrCreate($data);
    $this->refreshInput();
    session()->flash('success', 'You have successfully subscribed');
}

    public function render()
    {
        return view('livewire.newsletters');
    }
}
