<?php

namespace App\Http\Controllers;

use App\Helpers\CommentHelper;
use App\Models\Comment;
use App\Models\TelegramNotification;
use App\Models\User;
use App\Notifications\CommentReplyCreated;
use App\Notifications\UserCommentCreated;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramBotController extends Controller
{
    private static function requireAdmin()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin'))
            abort(404);
    }

    private static function sendRequest(string $method, array $parameters = []): Response
    {
        $token = config('services.telegram-bot-api.token');
        $methodUrl = "https://api.telegram.org/bot$token/$method";
        return Http::post($methodUrl, $parameters);
    }

    public function setup()
    {
        self::requireAdmin();
        $response = self::sendRequest('setWebhook', [
            'url' => route('telegram.webhook', absolute: true),
            'max_connections' => 5,
            'allowed_updates' => ['message'],
        ]);
        if (config('app.debug'))
            Collection::wrap($response->json())->dd();
        return $response->body();
    }

    public function info()
    {
        self::requireAdmin();
        $response = self::sendRequest('getWebhookInfo');
        if (config('app.debug'))
            Collection::wrap($response->json())->dd();
        return $response->body();
    }

    public function stub(Request $request)
    {
        self::requireAdmin();
        return '';
    }

    public function webhook(Request $request)
    {
        if ($request->has('message'))
            self::handleMessage($request->message);
        return '';
    }

    private static function sendMessage(
        int|string $chatId,
        string $text = '',
        ?array $button = null,
        ?\Closure $callback = null
    ): void {
        $message = TelegramMessage::create($text)->to($chatId);
        if ($button != null)
            $message->button($button[0], $button[1]);
        if ($callback != null)
            $callback($message);
        $message->send();
    }

    private static function handleMessage(array $message): void
    {
        $text = str(data_get($message, 'text', null))->trim();
        if ($text->isEmpty())
            return;
        if ($text->startsWith('/start'))
            return;
        $chatId = data_get($message, 'chat.id', null);
        $user = User::where('tg_id', $chatId)->first();
        if (!$user)
            return;
        $error = fn($key) => '❌ ' . __($key, locale: $user->locale);
        $replyChatId = data_get($message, 'reply_to_message.chat.id', null);
        $replyMessageId = data_get($message, 'reply_to_message.message_id', null);
        if (!$replyChatId || !$replyMessageId) {
            self::sendMessage($chatId, $error('telegram_bot.no_reply_notification'));
            return;
        }
        $tgn = TelegramNotification::where('chat_id', $replyChatId)->where('message_id', $replyMessageId)->first();
        if (!$tgn) {
            self::sendMessage($chatId, $error('telegram_bot.notification_does_not_support_reply'));
            return;
        }
        if ($tgn->reply_id) {
            self::sendMessage($chatId, $error('telegram_bot.you_have_already_replied'));
            return;
        }
        $notification = DB::table('notifications')->where('id', $tgn->notification_id)->first();
        if (!$notification) {
            self::sendMessage($chatId, $error('telegram_bot.notification_not_found'));
            return;
        }
        if (!\in_array($notification->type, [CommentReplyCreated::class, UserCommentCreated::class])) {
            self::sendMessage($chatId, $error('telegram_bot.notification_does_not_support_reply'));
            return;
        }
        if (!$user->can('create comments')) {
            self::sendMessage($chatId, $error('telegram_bot.you_cannot_create_comments'));
            return;
        }
        $data = json_decode($notification->data);
        $parent = Comment::find($data->comment_id);
        if (!$parent) {
            self::sendMessage($chatId, $error('telegram_bot.comment_not_found'));
            return;
        }

        $comment = new Comment;
        $comment->text = strval($text);
        $comment->parent_id = $parent->id;
        $comment->commentable_type = $parent->commentable_type;
        $comment->commentable_id = $parent->commentable_id;
        $comment->user_id = $user->id;
        $comment->save();

        $tgn->reply_id = data_get($message, 'message_id');
        $tgn->save();

        self::sendMessage(
            $replyChatId,
            '✅ ' . __('telegram_bot.reply_sent_successfully', locale: $user->locale),
            [__('telegram_bot.open', locale: $user->locale), CommentHelper::getRoute($comment)]
        );
    }
}
