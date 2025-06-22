<?php

namespace App\Notifications;

use App\Helpers\TelegramHelper;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification as Notification;
use NotificationChannels\Telegram\TelegramMessage;

class VisitPlanned extends BaseNotification implements ShouldQueue
{
    private Visit $visit;

    // Snapshot the datetime attribute to cancel the notification when it is changed
    private string $datetime;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
        $this->datetime = $visit->datetime;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'telegram'];
    }

    /**
     * Determine if the notification should be sent.
     */
    public function shouldSend(object $notifiable, string $channel): bool
    {
        $visit = Visit::find($this->visit->id);
        return $visit != null && $visit->datetime == $this->datetime;
    }

    public function toDatabase(User $user): array
    {
        return [
            'visit_id' => $this->visit->id,
        ];
    }

    public function toTelegram(User $user)
    {
        $message = __('notifications.planned_visit', [
            'restaurant' => TelegramHelper::modelLink($this->visit->restaurant),
            'datetime' => $this->visit->datetime,
        ]);
        $notes = str($this->visit->notes)->trim();
        return TelegramMessage::create()
            ->to($user->tg_id)
            ->content('🍔 ' . $message . PHP_EOL)
            ->lineIf($notes->isNotEmpty(), strval($notes))
            ->button(__('notifications.open'), route('visits.show', $this->visit->id));
    }

    /**
     * Create a notification with a fixed delay before the given visit.
     */
    public static function tryNotify(Visit $visit): bool
    {
        $hours = config('lunch.visit_notification_delay');
        $notifyAt = Carbon::parse($visit->datetime)->subHours($hours);
        if ($notifyAt->isBefore(now()))
            return false;
        Notification::send(User::get()->filter(function (User $user) {
            return $user->can('view visits');
        }), new self($visit)->delay($notifyAt));
        return true;
    }
}
