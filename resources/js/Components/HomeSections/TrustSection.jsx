import React from 'react';
import { usePage } from '@inertiajs/react';

export default function TrustSection() {
    const { setting } = usePage().props;
    
    const title = setting?.process_title || "Why choose EzProperty?";
    const subtitle = setting?.process_sub_title || "We are committed to providing a seamless, secure, and authentic travel experience across Nepal.";
    
    const defaultFeatures = [
        { icon: 'fa-shield-halved', title: 'Secure Booking', content: 'Your payments are 100% protected with top-tier encryption and trusted local gateways like eSewa and Khalti.' },
        { icon: 'fa-headset', title: '24/7 Local Support', content: 'Our dedicated Nepali support team is always ready to assist you before, during, and after your stay.' },
        { icon: 'fa-medal', title: 'Verified Hosts', content: 'We carefully vet all our hosts and properties to ensure you get an authentic, high-quality experience.' }
    ];

    const processItems = setting?.process_item;
    const features = Array.isArray(processItems) && processItems.length > 0 ? processItems : defaultFeatures;

    return (
        <section className="bg-slate-50 px-4 sm:px-3 lg:px-4 py-4 md:py-8">
            <div className="max-w-[1200px] mx-auto">
                
                <div className="text-center mb-5 md:mb-7">
                    <h2 className="text-2xl md:text-3xl font-bold text-slate-900">{title}</h2>
                    {subtitle && <p className="text-slate-500 mt-3 max-w-2xl mx-auto text-sm md:text-base leading-relaxed">{subtitle}</p>}
                </div>

                <div className="grid grid-cols-1 md:grid-cols-4 gap-3 lg:gap-4">
                    {features.map((feature, index) => (
                        <div key={index} className="group bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100/60">
                            <div className="w-14 h-14 bg-gradient-to-br from-brand to-brand-hover rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-brand/20 group-hover:scale-110 transition-transform duration-300">
                                <i className={`fa-solid ${feature.icon} text-white text-xl`}></i>
                            </div>
                            <h3 className="text-lg font-bold text-slate-900 mb-3">{feature.title}</h3>
                            <p className="text-slate-600 text-sm leading-relaxed">{feature.content}</p>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}