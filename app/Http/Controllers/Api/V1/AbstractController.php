<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use LaravelJsonApi\Core\Document\Error;

class AbstractController extends Controller
{
    public function throwAPIError(string $detail, int $status, string $title, ?string $pointer): void
    {
        abort(Error::fromArray([
        "detail" => $detail,
        "source" => [
        "pointer" => $pointer
        ],
        "status" => $status,
        "title" => $title
        ]));
    }
}
