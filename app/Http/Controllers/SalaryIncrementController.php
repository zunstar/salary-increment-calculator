<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\SalaryIncrementService;
use App\Http\Requests\SalaryIncrementRequest;

class SalaryIncrementController extends Controller
{
    protected $salaryIncrementService;

    public function __construct(SalaryIncrementService $salaryIncrementService)
    {
        $this->salaryIncrementService = $salaryIncrementService;
    }
    
    public function calculateIncrementRate(SalaryIncrementRequest $request) : JsonResponse
    {
        try {
            $previousSalary = $request->input('previousSalary');
            $currentSalary = $request->input('currentSalary');

            $incrementRate = (($currentSalary - $previousSalary) / $previousSalary) * 100;

            return response()->json([
                'previousSalary' => $previousSalary,
                'currentSalary' => $currentSalary,
                'incrementRate' => round($incrementRate, 2)
            ],Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json(['error' => '서버 오류가 발생했습니다.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
