<?php

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN ='open';
    case RESOLVED= 'resolved';
    case REJECTED = 'rejected';
}

// class TicketStatus
// {
//     const OPEN ='open';
//     const RESOLVED= 'resolved';
//     const REJECTED = 'rejected';
// }