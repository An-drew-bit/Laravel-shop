<?php

namespace App\Jobs;

use App\Mail\ReestablishPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected $user,
        protected string $url
    )
    {
    }

    public function handle(): void
    {
        Mail::to($this->user)->send(new ReestablishPassword($this->url));
    }
}
