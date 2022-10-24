<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;
use App\Mail\ContactMail;
use App\Mail\ContactResponse;
use Illuminate\Support\Facades\Mail;

class ContactForm extends Component
{
    public $name, $email, $subject, $message;
    public $data = [];

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required|min:10|max:3000',
    ];

    function refreshInputs()
    {
        $this->name = '';
        $this->email = '';
        $this->subject = '';
        $this->message = '';
    }
    public function save()
    {
        $data = $this->validate();

        // this mail to admin
         Mail::to(env('MAIL_FROM_ADDRESS'))->cc('info.bowofade@gmail.com')->send(new ContactResponse($data));

        // mail to user
        Mail::to($data['email'])->cc('info.bowofade@gmail.com')->send(new ContactMail($data));

        Contact::create($data);
        $this->refreshInputs();
        session()->flash('success', 'Message sent successfully, we will get back to as soon as possible');
    }
    public function render()
    {
        return view('livewire.contact-form');
    }
}
