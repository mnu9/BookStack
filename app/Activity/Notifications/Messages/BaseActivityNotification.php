<?php

namespace BookStack\Activity\Notifications\Messages;

use BookStack\Activity\Models\Loggable;
use BookStack\Activity\Notifications\MessageParts\LinkedMailMessageLine;
use BookStack\App\MailNotification;
use BookStack\Users\Models\User;
use Illuminate\Bus\Queueable;

abstract class BaseActivityNotification extends MailNotification
{
    use Queueable;

    public function __construct(
        protected Loggable|string $detail,
        protected User $user,
    ) {
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'activity_detail' => $this->detail,
            'activity_creator' => $this->user,
        ];
    }

    /**
     * Build the common reason footer line used in mail messages.
     */
    protected function buildReasonFooterLine(string $language): LinkedMailMessageLine
    {
        return new LinkedMailMessageLine(
            url('/preferences/notifications'),
            trans('notifications.footer_reason', [], $language),
            trans('notifications.footer_reason_link', [], $language),
        );
    }
}
