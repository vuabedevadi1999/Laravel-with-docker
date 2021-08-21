<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeStudentMain extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $student;
    public $user;
    public function __construct(Student $student,$user)
    {
        $this->student = $student;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('phamducdo9@gmail.com')
        ->subject("Thông báo trúng tuyển")
        ->markdown('emails.student.welcome-email');
    }
}
