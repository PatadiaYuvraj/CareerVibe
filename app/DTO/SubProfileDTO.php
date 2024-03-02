<?php

namespace App\DTO;

class SubProfileDTO
{
    private array $names;

    public function __construct()
    {
        $this->names = [];
    }

    public function setNames(array $names): void
    {
        foreach ($names as $name) {
            array_push($this->names, ["name" => $name]);
        }
    }

    public function toArray(): array
    {
        return $this->names;
    }
}
