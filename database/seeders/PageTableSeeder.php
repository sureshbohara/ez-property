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
            [
                'title'            => 'Cancellation Policy',
                'slug'             => 'cancellation-policy',
                'icon'             => 'bi-calendar-x',
                'short_content'    => 'Understand how cancellations and refunds work for guests and hosts at ghumNepal.',
                'content'          => '
                <h2>Guest-Facing Cancellation Policy</h2>
                <p>We understand that plans can change! Here is how cancellations and refunds work on ghumNepal.</p>
                
                <div class="alert alert-info" style="background-color: #e7f5ff; border: 1px solid #bde0fe; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <strong>💡 Please Note:</strong> For any cancellation that qualifies for a full or partial refund, ghumNepal retains a 5% platform fee. This fee is non-refundable as it directly covers administrative costs and bank processing charges.
                </div>

                <h3>1. If You Paid in Full (100% Upfront)</h3>
                <ul>
                <li><strong>Standard Cancellation (6+ days before check-in):</strong> You will receive a 100% refund of your booking amount (minus the 5% platform fee).</li>
                <li><strong>Short Notice Cancellation (Within 5 days of check-in):</strong> You will receive an 80% refund (minus the 5% platform fee).</li>
                <li><strong>No-Show or Post-Check-in Cancellation:</strong> No refund will be issued (0% refund).</li>
                <li><strong>Non-Refundable Bookings:</strong> No refunds are available for these specific promotional rates, regardless of when you cancel.</li>
                </ul>

                <h3>2. If You Paid a Partial Deposit (20% Upfront)</h3>
                <ul>
                <li><strong>Standard Cancellation (6+ days before check-in):</strong> Your entire 20% deposit is refunded (minus the 5% platform fee).</li>
                <li><strong>Short Notice or No-Show (Within 5 days of check-in):</strong> The deposit is entirely forfeited (0% refund).</li>
                </ul>

                <h3>3. If Your Host Cancels</h3>
                <p>No matter when a host cancels, you are fully protected. You will receive a 100% full refund of whatever amount you paid, with no fees deducted.</p>

                <hr style="margin: 30px 0;">

                <h2>Host-Facing Cancellation & Payout Policy</h2>
                <p>To ensure fairness and security for our hosting community, payouts for cancellations are structured as follows:</p>
                
                <div class="alert alert-info" style="background-color: #e7f5ff; border: 1px solid #bde0fe; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <strong>💡 Please Note:</strong> Payouts for guest cancellations are calculated after deducting a 5% platform fee to cover transaction and administrative processing.
                </div>

                <h3>1. When a Guest Cancels (Full Payment Bookings)</h3>
                <ul>
                <li><strong>6+ days before check-in:</strong> You will receive Rs. 0 (the guest receives their refund).</li>
                <li><strong>Within 5 days of check-in:</strong> You will receive a payout equivalent to 15% of the total base amount.</li>
                <li><strong>No-Show or Non-Refundable Bookings:</strong> You will receive a payout equivalent to 100% of the base amount.</li>
                </ul>

                <h3>2. When a Guest Cancels (20% Deposit Bookings)</h3>
                <ul>
                <li><strong>6+ days before check-in:</strong> You will receive Rs. 0 (the deposit is returned to the guest).</li>
                <li><strong>Within 5 days or No-Show:</strong> You will receive a payout equivalent to 15% of the total booking amount (which represents the remaining portion of the guest\'s forfeited deposit).</li>
                </ul>

                <h3>3. When You (the Host) Cancel</h3>
                <p>If you cancel a booking at any time, the guest is fully refunded. To cover the resulting administrative overhead and non-refundable bank charges, a 5% platform fee will be billed to your account.</p>
                
                <p>You can cancel or modify your reservation online through our website or by contacting our reservations team. Please see the <a href="https://booking.ghumnepal.com/contact-us">contact us page</a> and have your booking confirmation number ready for a quicker process.</p>

                <hr style="margin: 30px 0;">

                <h2>Force Majeure</h2>
                <p>In the event of unforeseen circumstances such as natural disasters, pandemics, or other force majeure events, we will work with you to reschedule your stay or provide a refund as per our policy.</p>
                ',
                'meta_title'       => 'Cancellation & Refund Policy - ghumNepal',
                'meta_description' => 'Read the detailed cancellation and refund policy for guests and hosts on ghumNepal.',
                'meta_keywords'    => 'cancellation policy, refund policy, booking cancellation, host payout, ghumnepal',
                'show_in_menu'     => false,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 5,
                'status'           => true,
            ],
            [
                'title'            => 'Host Resources',
                'slug'             => 'host-resources',
                'icon'             => 'bi-journal-text',
                'short_content'    => 'Tools, guides, and tips to help you become a successful host on EzProperty.',
                'content'          => '
                <h2>Welcome to Host Resources</h2>
                <p>Whether you are a new host or looking to scale your rental business, our Host Resources center provides you with the tools and knowledge you need to succeed.</p>
                
                <h3>1. Getting Started Guide</h3>
                <p>Learn how to create an irresistible listing. From taking professional photos to writing compelling descriptions, we guide you through the setup process.</p>
                
                <h3>2. Pricing Strategies</h3>
                <p>Maximize your earnings with dynamic pricing. Understand seasonal demand, local events, and how to set competitive base prices.</p>
                
                <h3>3. Guest Communication</h3>
                <p>Master the art of hospitality. Tips on responding to inquiries quickly, setting clear expectations, and handling reviews gracefully.</p>
                
                <h3>4. Property Maintenance</h3>
                <p>Best practices for cleaning schedules, restocking essentials, and ensuring your property remains in top condition for every guest.</p>
                ',
                'meta_title'       => 'Host Resources - EzProperty',
                'meta_description' => 'Guides and tools for EzProperty hosts to manage and grow their rentals.',
                'meta_keywords'    => 'host resources, hosting tips, property management, ezproperty',
                'show_in_menu'     => false,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 6,
                'status'           => true,
            ],
            [
                'title'            => 'Responsible Hosting',
                'slug'             => 'responsible-hosting',
                'icon'             => 'bi-shield-check',
                'short_content'    => 'Understand your responsibilities regarding safety, regulations, and community relations.',
                'content'          => '
                <h2>Responsible Hosting</h2>
                <p>Being a great host means providing a safe, welcoming environment while respecting your community and local laws.</p>
                
                <h3>1. Safety Guidelines</h3>
                <ul>
                <li>Ensure your property meets all local building codes and safety standards.</li>
                <li>Install working smoke detectors, carbon monoxide detectors, and fire extinguishers.</li>
                <li>Provide clear emergency exit routes and contact numbers.</li>
                </ul>

                <h3>2. Local Laws and Taxes</h3>
                <p>Hosts are responsible for understanding and complying with local regulations regarding short-term rentals. This includes registering your property, paying occupancy taxes, and adhering to zoning laws in cities like Kathmandu, Pokhara, and Bhaktapur.</p>
                
                <h3>3. Being a Good Neighbor</h3>
                <p>Communicate with your neighbors about your hosting activity. Enforce quiet hours and ensure your guests respect the local community and culture.</p>
                
                <h3>4. Non-Discrimination Policy</h3>
                <p>EzProperty requires all hosts to treat every guest with respect. Discrimination based on race, religion, national origin, or gender is strictly prohibited.</p>
                ',
                'meta_title'       => 'Responsible Hosting - EzProperty',
                'meta_description' => 'Learn about safety, legal compliance, and community guidelines for hosts.',
                'meta_keywords'    => 'responsible hosting, safety, local laws, ezproperty',
                'show_in_menu'     => false,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 7,
                'status'           => true,
            ],
            [
                'title'            => 'Community Forum',
                'slug'             => 'community-forum',
                'icon'             => 'bi-people',
                'short_content'    => 'Connect with other hosts, share experiences, and get answers to your questions.',
                'content'          => '
                <h2>Join the EzProperty Community</h2>
                <p>Our Community Forum is a space for hosts and travelers to connect, share stories, and help each other out. (Note: This is a placeholder page. A full interactive forum is coming soon!)</p>
                
                <h3>What You Can Do Here:</h3>
                <ul>
                <li><strong>Ask Questions:</strong> Get advice from experienced hosts on anything from plumbing issues to guest disputes.</li>
                <li><strong>Share Local Insights:</strong> Recommend local guides, restaurants, and hidden gems to help guests enjoy their stay.</li>
                <li><strong>Stay Updated:</strong> Find out about new platform features, policy updates, and local tourism events.</li>
                </ul>
                
                <p>Want to contribute? Email us at <a href="mailto:community@ezproperty.com">community@ezproperty.com</a> to become a community moderator.</p>
                ',
                'meta_title'       => 'Community Forum - EzProperty',
                'meta_description' => 'Connect with the EzProperty community of hosts and travelers.',
                'meta_keywords'    => 'community, forum, host network, ezproperty',
                'show_in_menu'     => false,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 8,
                'status'           => true,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(['slug' => $pageData['slug']], $pageData);
        }
    }
}