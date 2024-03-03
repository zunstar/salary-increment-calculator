<?php

namespace App\Services;

class SalaryIncrementService
{
    public function calculateIncrementRate(float $previousSalary,float $currentSalary): float
    {
        return (($currentSalary - $previousSalary) / $previousSalary) * 100;
    }
}