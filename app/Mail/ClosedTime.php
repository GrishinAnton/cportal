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
    protected $week;

    /**
     * @var array
     */
    protected $weeks;

    /**
     * @var array
     */
    protected $months;

    /**
     * @var array
     */
    protected $personalInfo;

    /**
     * Create a new message instance.
     *
     * ClosedTime constructor.
     * @param $week
     * @param $weeks
     */
    public function __construct($week, $weeks, $months, $personalInfo)
    {
        $this->week = $week;
        $this->weeks = $weeks;
        $this->months = $months;
        $this->personalInfo = $personalInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Отчет по закрытому времени за неделю | 2UP')
            ->with([
                'week' => $this->week,
                'weeks' => $this->weeks,
                'months' => $this->months,
                'firstName' => $this->personalInfo->first_name,
                'lastName' => $this->personalInfo->last_name,
            ])
            ->view('emails.closed_time');
    }
}
