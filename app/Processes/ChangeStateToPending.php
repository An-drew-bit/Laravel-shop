<?php

namespace App\Processes;

use App\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;
use Domain\Order\States\PendingOrderState;

final class ChangeStateToPending implements OrderProcessContract
{
    public function handle(Order $order, $next): mixed
    {
        $order->status->transitionTo(
            new PendingOrderState($order)
        );

        return $next($order);
    }
}
