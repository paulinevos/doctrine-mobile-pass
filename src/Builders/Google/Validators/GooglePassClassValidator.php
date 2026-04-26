<?php

namespace Vos\DoctrineMobilePass\Builders\Google\Validators;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Vos\DoctrineMobilePass\Exceptions\InvalidPass;

abstract class GooglePassClassValidator
{
    /**
     * @return array<string, Assert\Required|Assert\Optional> 
     */
    abstract protected function fields(): array;

    /**
     * @param  array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function validate(array $payload): array
    {
        $fields = $this->fields();

        $violations = Validation::createValidator()->validate(
            $payload,
            new Assert\Collection(allowExtraFields: true, fields: $fields),
        );

        if (count($violations) > 0) {
            $messages = array_map(
                fn ($v) => $v->getPropertyPath().': '.$v->getMessage(),
                iterator_to_array($violations),
            );
            throw new InvalidPass(implode("\n", $messages));
        }

        return array_intersect_key($payload, $fields);
    }
}
