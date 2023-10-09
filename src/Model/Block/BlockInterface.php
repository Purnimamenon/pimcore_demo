<?php
// src/Model/Product/BlockInterface.php

namespace App\Model\Block;


interface BlockInterface
{
    public function getVehicleType(): ?string;

    public function getNumberOfGears(): ?int;
}
