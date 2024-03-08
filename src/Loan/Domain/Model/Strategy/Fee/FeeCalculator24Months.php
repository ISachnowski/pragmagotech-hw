<?php

declare(strict_types=1);

namespace App\Loan\Domain\Model\Strategy\Fee;

use App\Loan\Domain\Model\Entity\Loan;

class FeeCalculator24Months implements FeeCalculator
{
    private $feeCalculatorHelper;
    private $feeBreakpoints;

    public function __construct(FeeCalculatorHelper $feeCalculatorHelper, array $feeBreakpoints)
    {
        $this->feeCalculatorHelper = $feeCalculatorHelper;
        $this->feeBreakpoints = $feeBreakpoints;
    }

    /**
     * @return float The calculated total fee on 24 months.
     */
    public function calculate(Loan $loan): float {
        $lowerBreakpoint = key($this->feeBreakpoints);
        $fee = 0;
        foreach ($this->feeBreakpoints as $key => $value) {
            if ($key == $loan->amount())
                return $this->feeBreakpoints[$key];
            else if ($key > $loan->amount()){
                $fee = $this->feeCalculatorHelper->calculateFeeLinear(
                    $this->feeBreakpoints,
                    $lowerBreakpoint,
                    $key,
                    $loan->amount()
                );
                break;
            } else {
                $lowerBreakpoint = $key;
            }
        }

        return $fee;
    }
}