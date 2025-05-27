<?php

namespace App\Enums;

enum IssueState: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
}
