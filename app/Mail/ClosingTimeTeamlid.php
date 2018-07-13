<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClosingTimeTeamlid extends Mailable
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
     * @var array
     */
    protected $teamleadUsers;

    /**
     * Create a new message instance.
     *
     * ClosedTime constructor.
     * @param $week
     * @param $weeks
     */
    public function __construct($week, $weeks, $months, $personalInfo, $teamleadUsers)
    {
        $this->week = $week;
        $this->weeks = $weeks;
        $this->months = $months;
        $this->personalInfo = $personalInfo;
        $this->teamleadUsers = $teamleadUsers;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Отчет по закрытому времени за неделю Тимлиды| 2UP')
            ->with([
                'week' => $this->week,
                'weeks' => $this->weeks,
                'months' => $this->months,
                'firstName' => $this->personalInfo->first_name,
                'lastName' => $this->personalInfo->last_name,
                'teamleadUsers' => $this->teamleadUsers,
            ])
            ->view('emails.closed_time_teamlid');
    }
}
