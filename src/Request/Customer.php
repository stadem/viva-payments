<?php

namespace Stadem\VivaPayments\Request;

use Stadem\VivaPayments\Traits\unsetData;
use Stadem\VivaPayments\Enums\RequestLang;
use InvalidArgumentException;

/**
 * Information about the customer.
 */
class Customer
{

    use unsetData;

    private const EX_CODE = 500;
    private ?string $email;
    private ?string $fullName;
    private ?string $phone;
    private ?string $countryCode;
    private string|RequestLang $requestLang;


    public function __construct(
        ?string $email = null,
        ?string $fullName = null,
        ?string $phone = null,
        ?string $countryCode = null,
        string|RequestLang $requestLang = null,
    ) {
        $this->setEmail($email)
            ->setFullName($fullName)
            ->setPhone($phone)
            ->setCountryCode($countryCode)
            ->setRequestLang($requestLang);
    }

    public function toArray(): array
    {
        //removing null values
        return $this->unsetData([
            'email' => $this->email,
            'fullName' => $this->fullName,
            'phone' => $this->phone,
            'countryCode' => $this->countryCode,
            'requestLang' => $this->requestLang,
        ]);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function setEmail(?string $email): static
    {
        if ($email && strlen($email) > 50) {
            throw new InvalidArgumentException('Customer\'s email value must be less than 50 characters.', self::EX_CODE);
        }

        $this->email = $email;

        return $this;
    }

    public function setFullName(?string $fullName): static
    {
        if ($fullName && strlen($fullName) > 50) {
            throw new InvalidArgumentException('Customer\'s email value must be less than 50 characters.', self::EX_CODE);
        }

        $this->fullName = $fullName;

        return $this;
    }

    public function setPhone(?string $phone): static
    {
        if ($phone && strlen($phone) > 30) {
            throw new InvalidArgumentException('Customer\'s phone value must be less than 30 characters.', self::EX_CODE);
        }

        $this->phone = $phone;

        return $this;
    }

    public function setCountryCode(?string $countryCode): static
    {
        if ($countryCode && strlen($countryCode) !== 2) {
            throw new InvalidArgumentException('Customer\'s country code value is invalid.', self::EX_CODE);
        }

        $this->countryCode = $countryCode;

        return $this;
    }

    public function setRequestLang(mixed $requestLang): static
    {
        
        $this->requestLang = $requestLang;

        return $this;
    }

}