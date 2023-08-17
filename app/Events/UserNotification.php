<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotification implements ShouldBroadcastNow
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $message;
	public $userId;

	public function __construct($message, $userId)
	{
		$this->message = $message;
		$this->userId = $userId;
	}

	public function broadcastOn()
	{
		return ['user-notification.' . $this->userId];
	}
}
