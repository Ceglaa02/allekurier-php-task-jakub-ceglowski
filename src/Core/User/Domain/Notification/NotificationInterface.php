<?php

namespace App\Core\User\Domain\Notification;

interface NotificationInterface
{
    public function sendEmail(string $recipient, string $subject, string $message): void;
}
