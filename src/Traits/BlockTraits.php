<?php
// src/Traits/BlockTraits.php

namespace App\Traits;

trait BlockTraits
{
    public function getVehicleType(): ?string
    {
        return "two-wheelers";
    }

    public function getNumberOfGears(): ?int
    {
        return 3;
    }
}
