<?php

namespace App\Events;

use App\Models\Bill;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $bill;
    /**
     * Create a new event instance.
     */
    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }
    /**
     * Xác định kênh mà sự kiện này sẽ được phát.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new Channel('order.' . $this->bill->id);
    }


    /**
     * Xác định dữ liệu mà sự kiện sẽ phát đi.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'status' => $this->bill->status,
            'order_id' => $this->bill->id,
        ];
    }
}
