<?php

declare(strict_types=1);

namespace App\Loan\Domain\Model\Strategy\Fee;

use App\Loan\Domain\Model\Entity\Loan;

interface FeeCalculator
{
    /**
     * @return float The calculated total fee.
     */
    public function calculate(Loan $application): float;
}