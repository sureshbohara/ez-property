<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqTableSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'display_on'  => 'account',
                'question'    => 'How do I create an account on Ghum Nepal Portal?',
                'answer'      => 'To create an account, click on the "Register" button located at the top right corner of our homepage. Fill in your name, email address, and password, then click "Sign Up". You will receive a verification email to activate your account.',
                'order_level' => 1,
                'status'      => true,
            ],
            [
                'display_on'  => 'account',
                'question'    => 'Can I sign up using Google, Facebook, or Apple ID?',
                'answer'      => 'Yes, Ghum Nepal Portal supports social login. On the login or registration page, click the "Login with Google" or "Login with Facebook" button to quickly create or access your account using your social media credentials.',
                'order_level' => 2,
                'status'      => true,
            ],
            [
                'display_on'  => 'account',
                'question'    => 'Do I need an account to book a hotel?',
                'answer'      => 'While you can browse properties without an account, you must create and log into an account to complete a booking. This ensures your booking details are secure and allows us to send you important updates regarding your stay.',
                'order_level' => 3,
                'status'      => true,
            ],
            [
                'display_on'  => 'account',
                'question'    => 'What should I do if I forget my password?',
                'answer'      => 'If you forget your password, click on the "Login" button, then select "Forgot Password". Enter your registered email address, and we will send you a link to reset your password.',
                'order_level' => 4,
                'status'      => true,
            ],
            [
                'display_on'  => 'account',
                'question'    => 'Can I change my email address after signing up?',
                'answer'      => 'Currently, for security reasons, you cannot change your primary email address directly from your profile settings. If you absolutely need to update your email, please contact our customer support team for assistance.',
                'order_level' => 5,
                'status'      => true,
            ],
            [
                'display_on'  => 'account',
                'question'    => 'Why am I unable to log in to my account?',
                'answer'      => 'If you are having trouble logging in, ensure you are using the correct email and password. Check if Caps Lock is on. If the issue persists, try resetting your password or ensure that your email address is properly verified.',
                'order_level' => 6,
                'status'      => true,
            ],
            [
                'display_on'  => 'account',
                'question'    => 'How do I update my profile information?',
                'answer'      => 'To update your profile, log in to your account, go to your Dashboard, and click on the "Settings" tab. From there, you can update your name, phone number, profile picture, and other personal details.',
                'order_level' => 7,
                'status'      => true,
            ],
            [
                'display_on'  => 'account',
                'question'    => 'Can I delete my account permanently?',
                'answer'      => 'Yes, you can request account deletion. Please contact our customer support team, and they will assist you in permanently deleting your account and associated data, provided there are no active or upcoming bookings.',
                'order_level' => 8,
                'status'      => true,
            ],
            [
                'display_on'  => 'account',
                'question'    => 'Why do I need to verify my email address?',
                'answer'      => 'Email verification is required to ensure the security of your account and to confirm that the email address belongs to you. It helps prevent spam, fraud, and ensures you receive important booking notifications.',
                'order_level' => 9,
                'status'      => true,
            ],
            [
                'display_on'  => 'account',
                'question'    => 'How do I verify my email?',
                'answer'      => 'After signing up, a verification link is sent to your email inbox. Simply open the email from Ghum Nepal Portal and click the "Verify Email Address" button. If you didn’t receive it, check your spam folder or request a resend link from the login page.',
                'order_level' => 10,
                'status'      => true,
            ],
        ];

        foreach ($faqs as $faqData) {
            Faq::updateOrCreate(['question' => $faqData['question']], $faqData);
        }
    }
}