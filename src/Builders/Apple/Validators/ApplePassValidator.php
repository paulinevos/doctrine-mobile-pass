<?php

namespace Vos\DoctrineMobilePass\Builders\Apple\Validators;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Vos\DoctrineMobilePass\Exceptions\InvalidPass;

abstract class ApplePassValidator
{
    /**
     * @return array<string, Assert\Required|Assert\Optional> 
     */
    protected function fields(): array
    {
        return [
            'description' => new Assert\Required(new Assert\NotBlank()),
            'formatVersion' => new Assert\Required(new Assert\EqualTo(1)),
            'organizationName' => new Assert\Required(new Assert\NotBlank()),
            'passTypeIdentifier' => new Assert\Required(new Assert\NotBlank()),
            'serialNumber' => new Assert\Required(new Assert\NotBlank()),
            'teamIdentifier' => new Assert\Required(new Assert\NotBlank()),
            'webServiceURL' => new Assert\Optional(),
            'authenticationToken' => new Assert\Optional(new Assert\Length(min: 16)),
            'logoText' => new Assert\Optional(),
            'barcode' => new Assert\Optional(),
            'barcodes' => new Assert\Optional(),
            'relevantDate' => new Assert\Optional(),
            'locations' => new Assert\Optional(),
            'maxDistance' => new Assert\Optional(),
            'nfc' => new Assert\Optional(),
            'semantics' => new Assert\Optional(),
            'primaryFields' => new Assert\Optional(),
            'foregroundColor' => new Assert\Optional(),
            'backgroundColor' => new Assert\Optional(),
            'labelColor' => new Assert\Optional(),
            'userInfo' => new Assert\Optional(),
            'iconImagePath' => new Assert\Optional(),
            'icon@2xImagePath' => new Assert\Optional(),
            'icon@3xImagePath' => new Assert\Optional(),
            'logoImagePath' => new Assert\Optional(),
            'logo@2xImagePath' => new Assert\Optional(),
            'logo@3xImagePath' => new Assert\Optional(),
        ];
    }

    public function validate(array $compiledData): array
    {
        $fields = $this->fields();

        $violations = Validation::createValidator()->validate(
            $compiledData,
            new Assert\Collection(allowExtraFields: true, fields: $fields),
        );

        if (count($violations) > 0) {
            $messages = array_map(
                fn ($v) => $v->getPropertyPath().': '.$v->getMessage(),
                iterator_to_array($violations),
            );
            throw new InvalidPass(implode("\n", $messages));
        }

        return array_intersect_key($compiledData, $fields);
    }
}
