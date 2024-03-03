<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\SalaryIncrementService;

/**
 * /api/calculate-increment-rate 엔드포인트 테스트
 */
class SalaryIncrementControllerTest extends TestCase
{
    protected $salaryIncrementService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->salaryIncrementService = new SalaryIncrementService();
    }
    
    /**
    *  @test
    */
    public function 올바른_입력값에_대한_성공적인_응답()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'previousSalary' => 50000,
            'currentSalary' => 55000,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'previousSalary' => 50000,
                'currentSalary' => 55000,
                'incrementRate' => 10.0,
            ]);
    }

    /**
     * @test
     */
    public function 숫자가_아닌_입력값previousSalary_currentSalary에대한_유효성_검사_실패()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'previousSalary' => "숫자가아닙니다",
            'currentSalary' => "또숫자가아닙니다",
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['previousSalary', 'currentSalary']);
    }

    /**
     * @test
     */
    public function 숫자가_아닌_입력값previousSalary에대한_유효성_검사_실패()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'previousSalary' => "숫자가아닙니다",
            'currentSalary' => 500000,
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['previousSalary']);
    }

    /**
     * @test
     */
    public function 숫자가_아닌_입력값currentSalary에대한_유효성_검사_실패()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'previousSalary' => 500000,
            'currentSalary' => "숫자가아닙니다",
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['currentSalary']);
    }

    /**
      * @test
     */
    public function 필수_입력값currentSalary_previousSalary누락에_대한_유효성_검사_실패()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['previousSalary', 'currentSalary']);
    }

    /**
      * @test
     */
    public function 필수_입력값previousSalary누락에_대한_유효성_검사_실패()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'currentSalary' => 55000,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['previousSalary']);
    }

    /**
      * @test
     */
    public function 필수_입력값currentSalary누락에_대한_유효성_검사_실패()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'previousSalary' => 55000,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['currentSalary']);
    }

    /**
     * @test
     */
    public function 음수_값previousSalary_currentSalary입력에_대한_유효성_검사_실패()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'previousSalary' => -100,
            'currentSalary' => -200,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['previousSalary', 'currentSalary']);
    }

    /**
     * @test
     */
    public function 빈_문자열previousSalary_currentSalary입력에_대한_유효성_검사_실패()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'previousSalary' => '',
            'currentSalary' => '',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['previousSalary', 'currentSalary']);
    }

    /**
     * 소수점 포함 숫자 입력에 대한 처리를 확인합니다.
     */
    public function 소수점_포함_숫자previousSalary_currentSalary_입력_처리()
    {
        $previousSalary = 50000.50;
        $currentSalary = 55000.75;
        $incrementRate = $this->salaryIncrementService->calculateIncrementRate($previousSalary, $currentSalary);

        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'previousSalary' => $previousSalary,
            'currentSalary' => $currentSalary,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'previousSalary' => $previousSalary,
                     'currentSalary' => $currentSalary,
                     'incrementRate' => $incrementRate
                 ]);
    }

    /**
     * @test
     */
    public function 직전_연봉이_0이하일_경우_유효성_검증_실패()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'previousSalary' => 0,
            'currentSalary' => 55000,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['previousSalary']);
    }

    /**
     * @test
     */
    public function 직전_연봉이_0초과일_경우_유효성_검증_성공()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'previousSalary' => 1,
            'currentSalary' => 55000,
        ]);

        $response->assertStatus(200);
    }

     /**
     * @test
     */
    public function 현재_연봉이_0미만일_경우_유효성_검증_실패()
    {
        $response = $this->postJson('/api/v1/calculate-increment-rate', [
            'previousSalary' => 50000,
            'currentSalary' => -1,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['currentSalary']);
    }
    
}
