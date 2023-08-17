<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminNotification implements ShouldBroadcastNow
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $message;
	public $adminId;

	public function __construct($message, $adminId)
	{
		$this->message = $message;
		$this->adminId = $adminId;
	}

	public function broadcastOn()
	{
		return ['admin-notification.' . $this->adminId];
	}
}
