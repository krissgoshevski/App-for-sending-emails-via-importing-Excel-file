<?php namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $row;
    private $language;
    public $subject;
    public $addresses;
    public $services;
    public $circuit_ids;
   // public $email;

    public function __construct($row, $language, $subject, $addresses, $services, $circuit_ids)
    {
        $this->row = $row;
        $this->language = $language;
        $this->subject = $subject;
        $this->addresses = $addresses;
        $this->services = $services;
 
        $this->circuit_ids = $circuit_ids;

    }



    public function build()
    {
        return $this->view($this->getView())
            ->from('testing@testing.com')
            ->cc('testing@testing.com')
            ->subject($this->getSubject());
    }

    protected function getView()
    {
        return $this->language === 'mk' ? 'emails.email' : 'emails.email-en';
    }
    protected function getSubject()
    {
        return $this->subject;
    } 
}


