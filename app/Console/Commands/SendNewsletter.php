<?php

namespace App\Console\Commands;

use App\Mail\NewsletterMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNewsletter extends Command
{
    protected $signature = 'newsletter:send';

    public function handle()
    {
        $users = User::where('is_admin', false)->get();
        
        foreach ($users as $user) {
            Mail::to($user->email)->send(new NewsletterMail($user));
        }
        
        return Command::SUCCESS;
    }
}

