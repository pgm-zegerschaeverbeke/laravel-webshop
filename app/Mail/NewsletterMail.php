<?php

namespace App\Mail;

use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $featuredProducts;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->featuredProducts = Product::query()
            ->available()
            ->featured()
            ->with('category', 'brand')
            ->inRandomOrder()
            ->get();
    }

    public function build()
    {
        return $this->subject('Weekly Newsletter - ' . config('app.name', 'Our Website'))
            ->view('emails.newsletter');
    }
}

