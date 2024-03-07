<?php

declare(strict_types=1);

namespace App\Loan\Application\Service;

use App\Loan\Domain\Model\Entity\Loan;
use App\Loan\Domain\Model\Strategy\Fee\FeeCalculator;
use App\Loan\Domain\Model\Strategy\Fee\FeeCalculator12Months;
use App\Loan\Domain\Model\Strategy\Fee\FeeCalculator24Months;
use App\Loan\Domain\Model\Strategy\Fee\FeeCalculatorHelper;

class FeeService
{
    private FeeCalculator $feeCalculator;
    private FeeCalculatorHelper $feeCalculatorHelper;

    public function __construct(FeeCalculatorHelper $feeCalculatorHelper)
    {
        $this->feeCalculatorHelper = $feeCalculatorHelper;
    }

    public function calculate (Loan $loan) {
        switch ($loan->term()) {
            case 12:
                $this->setFeeCalculator(new FeeCalculator12Months($this->feeCalculatorHelper));
                break;
            case 24:
                $this->setFeeCalculator(new FeeCalculator24Months($this->feeCalculatorHelper));
                break;
            default:
                break;    
        }

        return $this->feeCalculator->calculate($loan);
    }

    private function setFeeCalculator(FeeCalculator $feeCalculator) {
        $this->feeCalculator = $feeCalculator;
    }
}