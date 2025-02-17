<?php

namespace App\Domain\Entities;

class Address {
    public string $street;
    public string $number;
    public string $neighborhood;
    public string $complement;
    public string $zipCode; 

    public function __construct(string $street, string $number, string $neighborhood, string $complement = '', string $zipCode)
    {
        $this->street       = $street;
        $this->number       = $number;
        $this->neighborhood = $neighborhood;
        $this->complement   = $complement;
        $this->zipCode      = $zipCode;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getNeighborhood(): string
    {
        return $this->neighborhood;
    }

    public function setNeighborhood(string $neighborhood): void
    {
        $this->neighborhood = $neighborhood;
    }

    public function getComplement(): string
    {
        return $this->complement;
    }

    public function setComplement(string $complement): void
    {
        $this->complement = $complement;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    public function toPersistenceArray(): array
    {
        return [
            'street'       => $this->street,
            'number'       => $this->number,
            'neighborhood' => $this->neighborhood,
            'complement'   => $this->complement ?? '',
            'zip_code'     => $this->zipCode,
        ];
    }
}