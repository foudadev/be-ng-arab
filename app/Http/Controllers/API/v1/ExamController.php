<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Exam\ExamAPIStoreFormRequest;
use App\Models\Exam;
//use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\ExamService;
use App\Http\Resources\v1\QuestionResource;
use App\Http\Resources\v1\ExamResource;

class ExamController extends Controller {

    /**
     * @var ExamService
     */
    protected ExamService $examService;

    /**
     * QuestionController constructor.
     * @param ExamService $examService
     */
    public function __construct(ExamService $examService) {
        $this->examService = $examService;
    }

    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     * @param ExamAPIStoreFormRequest $request
     * @bodyParam  level enum in(junior,senior,expert) required
     * @bodyParam  question_category_id string required
     * @return JsonResponse
     */
    public function store(ExamAPIStoreFormRequest $request) {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $conditions = ['status' => 'active', 'question_category_id' => $data['question_category_id']];

        $exam = Exam::create($data);
        $questions = $this->examService->createQuestions($data['level'], $conditions);

        return response()->json(['exam' => new ExamResource($exam->refresh()), 'questions' => QuestionResource::collection($questions)]);
    }

}
