<?php

namespace App\Test\Unit\Loan\Domain\Model\Strategy\Fee;

use App\Loan\Domain\Model\Strategy\Fee\FeeCalculatorHelper;
use PHPUnit\Framework\TestCase;

class FeeCalculatorHelperTest extends TestCase
{
    public function testCalculatingFeeLinearlyBeetwenBounds(): void
    {
        $feeBreakpoints =[
            1000 => 200,
            2000 => 230,
            3000 => 300,
            5000 => 420,
            6500 => 510
        ];

        $helper = new FeeCalculatorHelper();
        self::assertSame(215.0, $helper->calculateFeeLinear($feeBreakpoints, 1000, 2000, 1500));
        self::assertSame(285.0, $helper->calculateFeeLinear($feeBreakpoints, 2000, 3000, 2750));
        self::assertSame(369.75, $helper->calculateFeeLinear($feeBreakpoints, 3000, 5000, 4120.25));
    }

    public function testRoundingUpFee(): void
    {
        $helper = new FeeCalculatorHelper();
        self::assertSame(55.0, $helper->roundUpFee(53, 2000));
        self::assertSame(60.44, $helper->roundUpFee(56, 1234.56));
        self::assertSame(261.78, $helper->roundUpFee(261.23, 6533.22));
    }

}