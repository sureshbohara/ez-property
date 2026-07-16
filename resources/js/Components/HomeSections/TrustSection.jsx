import React from 'react';

export default function TrustSection() {
    const features = [
        {
            icon: 'fa-shield-halved',
            title: 'Secure Booking',
            desc: 'Your payments are 100% protected with top-tier encryption and trusted local gateways like eSewa and Khalti.'
        },
        {
            icon: 'fa-headset',
            title: '24/7 Local Support',
            desc: 'Our dedicated Nepali support team is always ready to assist you before, during, and after your stay.'
        },
        {
            icon: 'fa-medal',
            title: 'Verified Hosts',
            desc: 'We carefully vet all our hosts and properties to ensure you get an authentic, high-quality experience.'
        }
    ];

    return (
        <section className="bg-slate-50 px-4 sm:px-6 lg:px-8 py-8 md:py-10">
            <div className="max-w-[1200px] mx-auto">
                
                <div className="text-center mb-10 md:mb-14">
                    <span className="text-brand font-semibold text-xs uppercase tracking-widest mb-2 block">
                        Trust & Safety
                    </span>
                    <h2 className="text-2xl md:text-3xl font-bold text-slate-900">
                        Why choose EzProperty?
                    </h2>
                    <p className="text-slate-500 mt-3 max-w-2xl mx-auto text-sm md:text-base leading-relaxed">
                        We are committed to providing a seamless, secure, and authentic travel experience across Nepal.
                    </p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                    {features.map((feature, index) => (
                        <div 
                            key={index} 
                            className="group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100/60"
                        >
                            <div className="w-14 h-14 bg-gradient-to-br from-brand to-brand-hover rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-brand/20 group-hover:scale-110 transition-transform duration-300">
                                <i className={`fa-solid ${feature.icon} text-white text-xl`}></i>
                            </div>
                            
                            <h3 className="text-lg font-bold text-slate-900 mb-3">
                                {feature.title}
                            </h3>
                            
                            <p className="text-slate-600 text-sm leading-relaxed">
                                {feature.desc}
                            </p>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}