<?php

namespace App\Containers\User\Action;

use App\Abstractions\Action\ActionInterface;
use App\Containers\Patient\Models\Patient;
use App\Containers\User\DTO\UserDto;
use App\Containers\User\Enums\UserRoleEnum;
use App\Containers\User\Models\User;
use App\Containers\User\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Spatie\Fractalistic\ArraySerializer;

/**
 *
 */
class RegistryUserAction implements ActionInterface
{
    /**
     * @param UserDto $userDto
     */
    public function __construct(private readonly UserDto $userDto)
    {
    }

    /**
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        $user = User::query()
            ->where(function ($query) {
                $query->where('login', $this->userDto->login)
                    ->orWhere('phone', $this->userDto->phone);
            })
            ->first();

        if ($user) {
            $user->is_active = true;
            $user->save();

            return response()->json([
                "status"  => false,
                'message' => 'User already exists',
                'user'    => $this->getUserResponse($user)
            ], 400);
        }

        $data = $this->userDto->toArray();
        $data["password"] = bcrypt($data["password"]);
        $data["is_active"] = true;

        $user = User::create($data);
        $this->matchWithPatient($user);

        return response()->json($this->getUserResponse($user), 200);
    }

    /**
     * @param User $user
     * @return void
     */
    private function matchWithPatient(User $user): void
    {
        if ($user->role !== UserRoleEnum::PATIENT) {
            return;
        }

        $patient = Patient::where('phone', $user->phone)->first();
        if ($patient) {
            $patient->user_id = $user->id;
            $patient->save();
        }
    }

    /**
     * @param User $user
     * @return array
     */
    private function getUserResponse(User $user): array
    {
        return fractal($user)
            ->transformWith(new UserTransformer())
            ->serializeWith(ArraySerializer::class)
            ->toArray();
    }
}
