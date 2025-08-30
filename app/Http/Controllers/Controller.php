<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected int $limit;
    protected int $page;

    public function __construct(Request $request)
    {
        $this->limit = max((int) $request->get('limit', 10), 1);
        $this->page = max((int) $request->get('page', 1), 1);
    }

    final public function success($data, string $message = 'OK', int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'content' => $data,
        ], $code);
    }

    final public function denied(string $message = 'Forbidden', int $code = Response::HTTP_FORBIDDEN): array
    {
        return [
            'code' => $code,
            'message' => $message,
        ];
    }
}
