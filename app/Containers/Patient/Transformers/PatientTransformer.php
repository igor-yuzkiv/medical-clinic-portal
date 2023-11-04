<?php

namespace App\Containers\Patient\Transformers;

use App\Containers\Patient\Models\Patient;
use App\Containers\User\Transformers\UserTransformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

/**
 *
 */
class PatientTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected array $defaultIncludes = [];

    /**
     * @var array|string[]
     */
    protected array $availableIncludes = ['doctors', 'user'];

    /**
     * @param Patient $patient
     * @return array
     */
    public function transform(Patient $patient): array
    {
        return [
            'id'         => (string)$patient->id,
            'name'       => $patient->name,
            'phone'      => $patient->phone,
            'email'      => $patient->email,
            'gender'     => $patient->gender,
            'source_id'  => $patient->source_id,
            'user_id'    => (string)$patient->user_id,
            'deleted_at' => $patient->deleted_at,
            'created_at' => $patient->created_at,
            'updated_at' => $patient->updated_at,
        ];
    }

    /**
     * @param Patient $patient
     * @return Collection
     */
    public function includeDoctors(Patient $patient): Collection
    {
        return $this->collection($patient->doctors, new UserTransformer);
    }

    /**
     * @param Patient $patient
     * @return Item
     */
    public function includeUser(Patient $patient): Item
    {
        return $this->item($patient->user, new UserTransformer);
    }
}
