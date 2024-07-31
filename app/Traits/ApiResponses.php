<?php
namespace App\Traits;

trait ApiResponses
{
    protected function ok($message, $data)
    {
        return $this->success($message, $data, 200);
    }
    protected function success($message, $data, $status = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status
        ], $status);
    }
    protected function error($message, $status)
    {
        return response()->json([
            'message' => $message,
            'status' => $status
        ], $status);
    }

}