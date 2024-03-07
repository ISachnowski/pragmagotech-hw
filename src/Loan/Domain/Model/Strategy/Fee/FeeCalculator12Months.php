<?php

declare(strict_types=1);

namespace App\Loan\Domain\Model\Strategy\Fee;

use App\Loan\Domain\Model\Entity\Loan;

class FeeCalculator12Months implements FeeCalculator
{
    private $feeCalculatorHelper;

    private $feeBreakpoints = [
        1000 => 50,
        2000 => 90,
        3000 => 90,
        4000 => 115,
        5000 => 100,
        6000 => 120,
        7000 => 140,
        8000 => 160,
        9000 => 180,
        10000 => 200,
        11000 => 220,
        12000 => 240,
        13000 => 260,
        14000 => 280,
        15000 => 300,
        16000 => 320,
        17000 => 340,
        18000 => 360,
        19000 => 380,
        20000 => 400
    ];

    public function __construct(FeeCalculatorHelper $feeCalculatorHelper)
    {
        $this->feeCalculatorHelper = $feeCalculatorHelper;
    }

    /**
     * @return float The calculated total fee on 12 months.
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