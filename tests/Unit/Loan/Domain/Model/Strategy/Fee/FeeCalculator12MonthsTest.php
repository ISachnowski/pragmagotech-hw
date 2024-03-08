<?php

namespace App\Test\Unit\Loan\Domain\Model\Strategy\Fee;

use App\Loan\Domain\Model\Strategy\Fee\FeeCalculator12Months;
use App\Loan\Domain\Model\Entity\Loan;
use App\Loan\Domain\Model\Service\FeeBreakpointsDataService;
use App\Loan\Domain\Model\Strategy\Fee\FeeCalculatorHelper;
use PHPUnit\Framework\TestCase;

class FeeCalculator12MonthsTest extends TestCase
{
    public function testCalculatingFeeFor12Months(): void
    {
        $mockHelper = $this->createMock(FeeCalculatorHelper::class);
        $mockHelper->method('calculateFeeLinear')->willReturn(249.33);

        $mockBreakpointsData = $this->createMock(FeeBreakpointsDataService::class);
        $mockBreakpointsData->method('getFeeBreakpointsByTerm')->with(12)->willReturn([
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
            ]);

        $feeCalculator12Months = new FeeCalculator12Months($mockHelper, $mockBreakpointsData->getFeeBreakpointsByTerm(12));
        
        self::assertEquals(50.0, $feeCalculator12Months->calculate(new Loan(12, 1000)));
        self::assertEquals(160.0, $feeCalculator12Months->calculate(new Loan(12, 8000)));
        self::assertEquals(400.0, $feeCalculator12Months->calculate(new Loan(12, 20000)));
        self::assertEquals(249.33, $feeCalculator12Months->calculate(new Loan(12, 12345.67)));
    }

}