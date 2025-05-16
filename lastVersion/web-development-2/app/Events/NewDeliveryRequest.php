<?php
namespace App\Events;

use App\Models\Inbox;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NewDeliveryRequest implements ShouldBroadcast
{
    use SerializesModels;

    public $inbox;

    public function __construct(Inbox $inbox)
    {
        $this->inbox = $inbox;
    }

    public function broadcastOn()
    {
        return new Channel('driver-channel-' . $this->inbox->driver_id);
    }

    public function broadcastAs()
    {
        return 'new-delivery';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->inbox->message,
            'order_id' => $this->inbox->order_id,
        ];
    }
}
