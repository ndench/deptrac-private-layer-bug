<?php

namespace App\Location\Model;

use App\Location\Public\LocationInterface;

readonly class Location implements LocationInterface
{
    public function __construct(
        private string $id,
        private string $name,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
