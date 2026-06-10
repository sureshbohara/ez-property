<?php

namespace App\Services\Admin;

use App\Models\Subscriber;
use App\Mail\MarketingMail;
use Illuminate\Support\Facades\Mail;

class MarketingService
{
    public function getSubscribers()
    {
        return Subscriber::active()->latest()->paginate(20);
    }

    public function sendBulkEmail($subject, $content){
        $subscribers = Subscriber::active()->get();

        if ($subscribers->isEmpty()) {
            return ['status' => false, 'message' => 'No active subscribers found.'];
        }

         foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new MarketingMail($subject, $content));
            } catch (\Exception $e) {
                \Log::error("Failed to send email to {$subscriber->email}: " . $e->getMessage());
            }
        }

        return [
            'status' => true, 
            'message' => 'Emails queued successfully to ' . $subscribers->count() . ' subscribers.'
        ];
    }
}