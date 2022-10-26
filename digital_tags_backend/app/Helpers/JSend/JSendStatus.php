<?php

namespace App\Helpers\JSend;

enum JSendStatus: string
{
    case SUCCESS = 'success';
    case FAIL = 'fail';
    case ERROR = 'error';
}
