<?php

namespace App\Transformers;

use App\Models\User;
use App\Utils\TransformersUtil;
use League\Fractal\TransformerAbstract;

/**
 *
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected array $defaultIncludes = [];

    /**
     * @var array
     */
    protected array $availableIncludes = [];

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user): array
    {
        return [
            'id'                         => (string)$user->id,
            'name'                       => $user->name,
            'login'                      => $user->login,
            'email'                      => $user->email,
            'phone'                      => $user->phone,
            'role'                       => $user->role,
            'is_active'                  => (boolean)$user->is_active,
            'last_activity_at'           => $user->last_activity_at,
            'last_activity_at_formatted' => $user->last_activity_at ? TransformersUtil::dateTimeFormatted($user->last_activity_at) : '',
            'source_id'                  => $user->source_id,
            'gender'                     => $user->gender,
            'deleted_at'                 => $user->deleted_at,
            'created_at'                 => $user->created_at,
            'updated_at'                 => $user->updated_at,
        ];
    }
}
