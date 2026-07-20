<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageTableSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title'            => 'About Us',
                'slug'             => 'about-us',
                'icon'             => 'bi-info-circle',
                'short_content'    => 'Learn about our company, mission, and the team behind our success.',
                'content'          => '<h2>Welcome to EzProperty</h2><p>We are a leading property management platform connecting hosts and travelers.</p><h3>Our Mission</h3><p>To provide the best homestay and rental experiences in Nepal.</p>',
                'meta_title'       => 'About Us - EzProperty',
                'meta_description' => 'Learn more about our company, mission, and values.',
                'meta_keywords'    => 'about us, ezproperty, nepal property',
                'show_in_menu'     => true,
                'show_in_footer'   => true,
                'is_featured'      => true,
                'order_level'      => 1,
                'status'           => true,
            ],
            [
                'title'            => 'Contact Us',
                'slug'             => 'contact-us',
                'icon'             => 'bi-envelope',
                'short_content'    => 'Get in touch with us for inquiries, support, or partnership opportunities.',
                'content'          => '<h2>Get in Touch</h2><p>Email us at support@ezproperty.com or call +977-1-XXXXXXX.</p><h3>Office Location</h3><p>Kathmandu, Nepal</p>',
                'meta_title'       => 'Contact Us - EzProperty',
                'meta_description' => 'Contact us for inquiries and support.',
                'meta_keywords'    => 'contact, support, ezproperty',
                'show_in_menu'     => true,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 2,
                'status'           => true,
            ],
            [
                'title'            => 'Terms and Conditions',
                'slug'             => 'terms-conditions',
                'icon'             => 'bi-file-earmark-text',
                'short_content'    => 'Please read these Host Terms and Conditions carefully before listing your property on EzProperty.',
                'content'          => '
                    <h2>1. Acceptance of Terms</h2>
                    <p>By accessing and using the EzProperty hosting platform, you agree to be bound by these Host Terms and Conditions. If you do not agree with any part of these terms, please do not proceed with the host upgrade or list your property on our platform.</p>
                    
                    <h2>2. Host Responsibilities</h2>
                    <p>As a host, you are responsible for maintaining a high standard of hospitality. Specifically, you agree to:</p>
                    <ul>
                        <li>Ensure your property is safe, clean, and accurately represented in your listing.</li>
                        <li>Comply with all local laws, regulations, and tax requirements regarding short-term rentals in Nepal.</li>
                        <li>Respond to guest inquiries and booking requests promptly.</li>
                        <li>Maintain necessary insurance coverage for your property and guests.</li>
                    </ul>
                    
                    <h2>3. Bookings and Cancellations</h2>
                    <p>Hosts are expected to honor confirmed bookings. While you can set your own cancellation policies, excessive or unjustified cancellations negatively impact guest trust and may result in penalties, including removal of your listing from the platform. EzProperty reserves the right to cancel any booking that violates our community standards.</p>
                    
                    <h2>4. Payments, Fees, and Payouts</h2>
                    <p>EzProperty charges a service fee for each completed booking to maintain and improve the platform. Payouts to hosts are processed according to the schedule outlined in your host dashboard. You are responsible for providing accurate payout information and for any taxes applicable to your rental income.</p>
                    
                    <h2>5. Liability and Damages</h2>
                    <p>EzProperty acts solely as an intermediary between hosts and guests. We are not liable for any property damage, theft, or personal injury that occurs on your property. Hosts are encouraged to set appropriate security deposits and utilize our Host Guarantee program if applicable.</p>
                    
                    <h2>6. Account Termination</h2>
                    <p>We reserve the right to suspend or terminate your host account if you violate these Terms and Conditions, engage in fraudulent activity, or receive consistent negative reviews regarding safety or hospitality.</p>
                ',
                'meta_title'       => 'Host Terms & Conditions',
                'meta_description' => 'Read the Host Terms and Conditions for EzProperty.',
                'meta_keywords'    => 'terms, conditions, host policy, ezproperty',
                'show_in_menu'     => false,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 3,
                'status'           => true,
            ],
            [
                'title'            => 'Privacy Policy',
                'slug'             => 'privacy-policy',
                'icon'             => 'bi-shield-check',
                'short_content'    => 'Your privacy matters to us. This policy explains how we handle and protect your personal data.',
                'content'          => '
                    <h2>1. Information We Collect</h2>
                    <p>When you become a host or a guest on EzProperty, we collect information necessary to provide our services. This includes:</p>
                    <ul>
                        <li><strong>Personal Details:</strong> Name, email address, phone number, and profile photo.</li>
                        <li><strong>Property Information:</strong> Address, amenities, photos, and pricing details for your listings.</li>
                        <li><strong>Payment Data:</strong> Bank account or payment method details to process payouts securely (we do not store full credit card numbers).</li>
                    </ul>
                    
                    <h2>2. How We Use Your Information</h2>
                    <p>Your information is used to verify your identity, facilitate secure bookings, process payments, provide customer support, and prevent fraud. We <strong>do not</strong> sell your personal information to third-party marketers.</p>
                    
                    <h2>3. Data Security</h2>
                    <p>We implement industry-standard security measures (such as SSL encryption) to protect your personal data. However, no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.</p>
                    
                    <h2>4. Sharing of Information</h2>
                    <p>We may share your information with third-party service providers who help us operate the platform (e.g., payment gateways, SMS providers). We may also disclose information if required by law or to protect the rights, property, or safety of EzProperty, our users, or others.</p>
                    
                    <h2>5. Your Rights</h2>
                    <p>You have the right to access, update, or request the deletion of your personal information. You can manage your data directly in your account settings or by contacting our support team.</p>

                    <h2>6. Cookies and Tracking</h2>
                    <p>We use cookies and similar technologies to enhance your browsing experience, analyze site traffic, and understand where our users are coming from. You can control cookies through your browser settings.</p>
                ',
                'meta_title'       => 'Privacy Policy',
                'meta_description' => 'Learn about how EzProperty protects your privacy and handles your data.',
                'meta_keywords'    => 'privacy, policy, data protection, ezproperty',
                'show_in_menu'     => false,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 4,
                'status'           => true,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(['slug' => $pageData['slug']], $pageData);
        }
    }
}