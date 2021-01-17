<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ApiInputValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\ApiInput */
        $value = htmlspecialchars($value);
        if (null === $value || '' === $value || !is_numeric($value)) {
            return;
        }

        $value = intval($value);

        if ($value < 0) {
            return;
        }

        return $value;
        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
