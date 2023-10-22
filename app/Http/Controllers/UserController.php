<?php

namespace App\Http\Controllers;

use App\Abstractions\Serializer\DataArraySerializer;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

/**
 *
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->orderBy(
                $request->input('orderBy', 'created_at'),
                $request->input('order', 'desc')
            );

        if ($request->input("filters")) {
            $users->filter($request->input("filters"));
        }

        if ($request->boolean('paginate', true)) {
            $users = $users->paginate($request->input('per_page', 10));
        } else {
            if ($request->input("limit")) {
                $users->limit($request->input("limit"));
            }
            $users = $users->get();
        }

        $includes = explode(",", $request->get('includes', ""));

        return fractal($users)
            ->serializeWith(DataArraySerializer::class)
            ->parseIncludes($includes)
            ->withResourceName("data")
            ->transformWith(new UserTransformer())
            ->respond();
    }
}
