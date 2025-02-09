<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NaturalLanguageProcessor;
use App\Services\EmailService;
use App\Services\SchedulerService;
use App\Services\TodoListService;
use App\Services\FAQService;

class ChatbotController extends Controller
{
    protected $nlp;
    protected $emailService;
    protected $schedulerService;
    protected $todoListService;
    protected $faqService;

    public function __construct(
        NaturalLanguageProcessor $nlp,
        EmailService $emailService,
        SchedulerService $schedulerService,
        TodoListService $todoListService,
        FAQService $faqService
    ) {
        $this->nlp = $nlp;
        $this->emailService = $emailService;
        $this->schedulerService = $schedulerService;
        $this->todoListService = $todoListService;
        $this->faqService = $faqService;
    }

    public function processMessage(Request $request)
    {
        $userMessage = $request->input('message');
        $intent = $this->nlp->determineIntent($userMessage);

        switch ($intent) {
            case 'compose_email':
                return response()->json(['message' => $this->emailService->composeEmail($userMessage)]);
            case 'send_email':
                return response()->json(['message' => $this->emailService->sendEmail($userMessage)]);
            case 'search_email':
                return response()->json(['message' => $this->emailService->searchEmail($userMessage)]);
            case 'schedule_appointment':
                return response()->json(['message' => $this->schedulerService->scheduleAppointment($userMessage)]);
            case 'manage_todo':
                return response()->json(['message' => $this->todoListService->manageTodoList($userMessage)]);
            case 'faq':
                return response()->json(['message' => $this->faqService->answerFAQ($userMessage)]);
            default:
                return response()->json(['message' => "I'm sorry, I didn't understand that request. Can you please rephrase?"]);
        }
    }
}