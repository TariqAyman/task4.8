<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiHelper
{
    public static function validate($request, $validation_data)
    {
        $validator = Validator::make($request->all(), $validation_data);
        if ($validator->fails()) {
            $data['errors'] = $validator->errors()->all();
            response()->json($data, 400)->send();
            exit;
        }
    }

    public static function output($data, $success = 1)
    {
        if ($success == 1) {
            return response()->json([
                'data' => (!isset($data) || empty($data)) ? [] : $data,
            ], 200);
        } else {
            return response()->json([
                'errors' => (empty($data)) ? [] : [$data],
            ], 400);
        }
    }

}
