<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class DiskUsageOverviewValidatorValidator.
 *
 * @package namespace App\Validators;
 */
class DiskUsageOverviewValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id'        => 'required',
            'total_size'     => 'required',
            'number_of_file' => 'required',
        ],
        
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required|exists,disk_usage_overviews'
        ],
    ];
}
