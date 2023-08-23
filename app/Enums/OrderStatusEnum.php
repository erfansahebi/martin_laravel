<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case Canceled = 0;
    case AcceptedAndOnTheWayToTheOrigin = 1;
    case OnTheWayToTheDestination = 2;
    case Done = 3;
    case Pending = 4;
}
