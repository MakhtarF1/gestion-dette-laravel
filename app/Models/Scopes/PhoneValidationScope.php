<?php

namespace App\Scopes;

use App\Services\ValidateSenegalPhone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PhoneValidationScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where(function ($query) use ($model) {
            $validator = ValidateSenegalPhone::getInstance();

            // Apply the scope to ensure all phone numbers are valid Senegalese numbers
            $query->where(function ($query) use ($validator, $model) {
                foreach ($query->getBindings() as $binding) {
                    if ($validator->validate('phone', $binding)) {
                        continue;
                    } else {
                        throw new \Exception("Invalid Senegalese phone number detected in {$model->getTable()}.");
                    }
                }
            });
        });
    }
}
