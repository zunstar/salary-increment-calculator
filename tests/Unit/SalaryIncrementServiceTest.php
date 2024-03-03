<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\SalaryIncrementService;

class SalaryIncrementServiceTest extends TestCase
{
    private $salaryIncrementService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->salaryIncrementService = new SalaryIncrementService();
    }

    /**
     * @test
     */
    public function 연봉_인상률_성공_테스트()
    {
        $previousSalary = 50000;
        $currentSalary = 55000;
        $expectedIncrementRate = 10.0;

        $incrementRate = $this->salaryIncrementService->calculateIncrementRate($previousSalary, $currentSalary);

        $this->assertEquals($expectedIncrementRate, $incrementRate);
    }

    /**
     * @test
     */
    public function 연봉_인상률_실패_테스트()
    {
        $previousSalary = 50000;
        $currentSalary = 55000;
        $incorrectIncrementRate = 20.0;

        $incrementRate = $this->salaryIncrementService->calculateIncrementRate($previousSalary, $currentSalary);

        $this->assertNotEquals($incorrectIncrementRate, $incrementRate);
    }

    /**
     * @test
     */
    public function 연봉_감소률_성공_테스트()
    {
        $previousSalary = 55000;
        $currentSalary = 50000;
        $expectedIncrementRate = -9.090909090909092;

        $incrementRate = $this->salaryIncrementService->calculateIncrementRate($previousSalary, $currentSalary);

        $this->assertEquals($expectedIncrementRate, $incrementRate);
    }

    /**
     * @test
     */
    public function 연봉_감소률_실패_테스트()
    {
        $previousSalary = 55000;
        $currentSalary = 50000;
        $expectedIncrementRate = -19.090909090909092;

        $incrementRate = $this->salaryIncrementService->calculateIncrementRate($previousSalary, $currentSalary);

        $this->assertNotEquals($expectedIncrementRate, $incrementRate);
    }
}
