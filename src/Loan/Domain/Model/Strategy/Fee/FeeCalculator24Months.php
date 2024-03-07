<?php

declare(strict_types=1);

namespace App\Loan\Domain\Model\Strategy\Fee;

use App\Loan\Domain\Model\Entity\Loan;

class FeeCalculator24Months implements FeeCalculator
{
    private $feeCalculatorHelper;

    private $feeBreakpoints = [
        1000 => 70,
        2000 => 100,
        3000 => 120,
        4000 => 160,
        5000 => 200,
        6000 => 240,
        7000 => 280,
        8000 => 320,
        9000 => 360,
        10000 => 400,
        11000 => 440,
        12000 => 480,
        13000 => 520,
        14000 => 560,
        15000 => 600,
        16000 => 640,
        17000 => 680,
        18000 => 720,
        19000 => 760,
        20000 => 800
    ];

    public function __construct(FeeCalculatorHelper $feeCalculatorHelper)
    {
        $this->feeCalculatorHelper = $feeCalculatorHelper;
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