<?php

namespace App\Test\Unit\Loan\Domain\Model\Strategy\Fee;

use App\Loan\Domain\Model\Strategy\Fee\FeeCalculator24Months;
use App\Loan\Domain\Model\Entity\Loan;
use App\Loan\Domain\Model\Service\FeeBreakpointsDataService;
use App\Loan\Domain\Model\Strategy\Fee\FeeCalculatorHelper;
use PHPUnit\Framework\TestCase;

class FeeCalculator24MonthsTest extends TestCase
{
    public function testCalculatingFeeFor24Months(): void
    {
        $mockHelper = $this->createMock(FeeCalculatorHelper::class);
        $mockHelper->method('calculateFeeLinear')->willReturn(449.33);

        $mockBreakpointsData = $this->createMock(FeeBreakpointsDataService::class);
        $mockBreakpointsData->method('getFeeBreakpointsByTerm')->with(24)->willReturn([
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
            ]);

        $feeCalculator24Months = new FeeCalculator24Months($mockHelper, $mockBreakpointsData->getFeeBreakpointsByTerm(24));
        
        self::assertEquals(70.0, $feeCalculator24Months->calculate(new Loan(24, 1000)));
        self::assertEquals(320.0, $feeCalculator24Months->calculate(new Loan(24, 8000)));
        self::assertEquals(800.0, $feeCalculator24Months->calculate(new Loan(24, 20000)));
        self::assertEquals(449.33, $feeCalculator24Months->calculate(new Loan(24, 12345.67)));
    }

}