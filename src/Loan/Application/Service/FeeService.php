<?php

declare(strict_types=1);

namespace App\Loan\Application\Service;

use App\Loan\Domain\Model\Entity\Loan;
use App\Loan\Domain\Model\Service\FeeBreakpointsDataService;
use App\Loan\Domain\Model\Strategy\Fee\FeeCalculator;
use App\Loan\Domain\Model\Strategy\Fee\FeeCalculator12Months;
use App\Loan\Domain\Model\Strategy\Fee\FeeCalculator24Months;
use App\Loan\Domain\Model\Strategy\Fee\FeeCalculatorHelper;

class FeeService
{
    private FeeCalculator $feeCalculator;
    private FeeCalculatorHelper $feeCalculatorHelper;
    private FeeBreakpointsDataService $feeBreakpointsDataService;

    public function __construct(FeeCalculatorHelper $feeCalculatorHelper, FeeBreakpointsDataService $feeBreakpointsDataService)
    {
        $this->feeCalculatorHelper = $feeCalculatorHelper;
        $this->feeBreakpointsDataService = $feeBreakpointsDataService;
    }

    public function calculate (Loan $loan) {
        switch ($loan->term()) {
            case 12:
                $this->setFeeCalculator(new FeeCalculator12Months($this->feeCalculatorHelper, $this->feeBreakpointsDataService->getFeeBreakpointsByTerm(12)));
                break;
            case 24:
                $this->setFeeCalculator(new FeeCalculator24Months($this->feeCalculatorHelper, $this->feeBreakpointsDataService->getFeeBreakpointsByTerm(24)));
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