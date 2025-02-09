<?php

namespace App\Services;

class NaturalLanguageProcessor
{
    public function determineIntent($message)
    {
        $message = strtolower($message);
        
        if (strpos($message, 'email') !== false) {
            if (strpos($message, 'compose') !== false) {
                return 'compose_email';
            } elseif (strpos($message, 'send') !== false) {
                return 'send_email';
            } elseif (strpos($message, 'search') !== false) {
                return 'search_email';
            }
        } elseif (strpos($message, 'schedule') !== false || strpos($message, 'appointment') !== false) {
            return 'schedule_appointment';
        } elseif (strpos($message, 'todo') !== false || strpos($message, 'task') !== false) {
            return 'manage_todo';
        }
        
        return 'faq';
    }
}