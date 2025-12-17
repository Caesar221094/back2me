<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ReportClaimed extends Notification
{
    use Queueable;

    public function __construct(protected Report $report)
    {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'report_claimed',
            'report_id' => $this->report->id,
            'message' => 'Laporan #' . $this->report->id . ' diklaim oleh user',
        ];
    }
}
