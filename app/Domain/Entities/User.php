<?php

namespace App\Domain\Entities;

class User {
    public string $name;
    public string $email;
    public string $password;
    public string $cpf;
    public string $phone_number;
    public array $addresses; 

    public function __construct(string $name, string $email, string $password, string $cpf, string $phone_number, array $addresses = [])
    {
        $this->name         = $name;
        $this->email        = $email;
        $this->password     = $password;
        $this->cpf          = $cpf;
        $this->phone_number = $phone_number;
        $this->addresses    = $addresses;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function setAddresses(array $addresses): void
    {
        $this->addresses = $addresses;
    }
}