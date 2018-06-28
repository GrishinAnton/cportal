<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClosedTime extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    protected $collection;

    /**
     * Create a new message instance.
     *
     * ClosedTime constructor.
     * @param $collection
     */
    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Отчет по закрытому времени за неделю')
            ->with([
                'collection' => $this->collection,
            ])
            ->view('emails.closed_time');
    }
}
