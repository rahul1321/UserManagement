<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ChatValidator.
 *
 * @package namespace App\Validators;
 */
class ChatValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'from_user_id' => 'required',
            'to_user_id' => 'required',
            'message' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
