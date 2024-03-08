<?php

declare(strict_types=1);

namespace App\Loan\Domain\Model\Strategy\Fee;

class FeeCalculatorHelper
{

    /**
     * @return float Calculated fee on linearly between the lower bound and upper bound that they fall between.
     */
    public function calculateFeeLinear(array $feeBreakpoints, int $lowerBreakpoint, int $higherBreakpoint, float $amount) : float {
        $breakpointFeeDiff = $feeBreakpoints[$higherBreakpoint] - $feeBreakpoints[$lowerBreakpoint];
        $overBreakpointAmount = $amount - $lowerBreakpoint;
        $partOfBreakpointSize = $overBreakpointAmount / ($higherBreakpoint - $lowerBreakpoint);
    
        return $this->roundUpFee($feeBreakpoints[$lowerBreakpoint] + ($breakpointFeeDiff * $partOfBreakpointSize), $amount);
    }

    /**
     * @return float Rounded up fee that fee + loan amount is an exact multiple of 5.
     */
    public function roundUpFee(float $fee, float $amount) : float {
        $summary = $fee + $amount;
        $roundedTo5 = ceil($summary / 5) * 5;

        return round($roundedTo5 - $amount, 2);
    }
}