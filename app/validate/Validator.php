<?php

namespace App\Main;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{

    protected $errors;

    /**
     * Basic for validation.
     * @param $request
     * @param array $rules
     * @return Validator
     */
    public function validate($request, array $rules)
    {
        try{
            foreach ($rules as $field => $rule){
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            }
        }catch (NestedValidationException $e){
            $this->errors[$field] = $e->getMessages();
        }
        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    /**
     * Check if errors array is empty.
     *
     * Ensure all fields pass validation state
     * @return bool
     */
    public function failed(): bool
    {
        return !empty($this->errors);
    }
}