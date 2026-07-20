import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import toast from 'react-hot-toast';
import FrontLayout from '@/Layouts/FrontLayout';

export default function BecomeHost() {
    const { data, setData, post, processing } = useForm({
        agreeTerms: false,
    });

    const submit = (e) => {
        e.preventDefault();
        
        if (!data.agreeTerms) {
            toast.error('Please accept the Terms and Conditions to continue.');
            return;
        }


        post('/become-host', {
            onSuccess: (page) => {
                if (page.props.flash.success) {
                    toast.success(page.props.flash.success);
                }
            }
        });
    };

    const hostSteps = [
        { title: 'Upgrade Your Account', desc: 'Click the button below to unlock host features and dashboard access.' },
        { title: 'List Your Property', desc: 'Add your property details, location, amenities, and high-quality photos.' },
        { title: 'Set Your Rules & Price', desc: 'Define your house rules, check-in/out times, and set competitive nightly rates.' },
        { title: 'Welcome Your Guests', desc: 'Once approved, your listing goes live. Start receiving bookings and earning income!' }
    ];

    return (
        <FrontLayout>
            <Head title="Become a Host - EzProperty" />
            
            <div className="min-h-[calc(100vh-80px)] grid md:grid-cols-2 bg-slate-50">

            
                <div className="relative hidden md:block">
                    <img 
                        src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&q=80" 
                        alt="Host Home" 
                        className="absolute inset-0 w-full h-full object-cover"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-slate-900/20"></div>

                    <div className="relative h-full flex flex-col justify-end p-10 lg:p-14 z-10">
                        <div className="text-white max-w-lg">
                            <h2 className="text-3xl lg:text-4xl font-extrabold mb-3 leading-tight tracking-tight">
                                Your space, your rules, your income.
                            </h2>
                            <p className="text-slate-200 text-base lg:text-lg">
                                Join hundreds of hosts in Nepal sharing their beautiful spaces with travelers worldwide.
                            </p>
                        </div>
                    </div>
                </div>

             
                <div className="flex flex-col justify-center items-center w-full p-6 sm:p-10 lg:p-12 relative overflow-y-auto">

              
                    <Link 
                        href="/" 
                        className="md:hidden absolute top-4 left-6 inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-brand transition group"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Home
                    </Link>

                    <div className="w-full max-w-xl">
                        <h1 className="text-2xl sm:text-3xl font-bold text-slate-900 mb-2 tracking-tight">
                            Become a Host
                        </h1>
                        <p className="text-slate-500 mb-6 leading-relaxed text-sm sm:text-base">
                            Ready to earn from your property? Upgrade your account now to access the host dashboard and create your first listing in minutes.
                        </p>

                      
                        <div className="mb-6 bg-white border border-slate-200 rounded-xl p-5 sm:p-6 shadow-sm">
                            <h3 className="text-base font-semibold text-slate-800 mb-4">How it works:</h3>

                            <ul className="space-y-4">
                                {hostSteps.map((step, index) => (
                                    <li key={index} className="flex items-start gap-3">
                                        <span className="flex-shrink-0 w-8 h-8 bg-brand text-white rounded-full flex items-center justify-center font-bold text-sm">
                                            {index + 1}
                                        </span>
                                        <div>
                                            <h4 className="font-semibold text-slate-800 text-sm sm:text-base">{step.title}</h4>
                                            <p className="text-slate-500 text-xs sm:text-sm mt-0.5 leading-snug">{step.desc}</p>
                                        </div>
                                    </li>
                                ))}
                            </ul>
                        </div>

                        <form onSubmit={submit}>
                            {/* Terms and Conditions Checkbox */}
                            <div className="flex items-start mb-5">
                                <input
                                    id="agreeTerms"
                                    type="checkbox"
                                    checked={data.agreeTerms}
                                    onChange={(e) => setData('agreeTerms', e.target.checked)}
                                    className="mt-1 h-4 w-4 rounded border-slate-300 text-brand focus:ring-brand cursor-pointer"
                                    required
                                />

                                <label htmlFor="agreeTerms" className="ml-2 block text-sm text-slate-600 cursor-pointer leading-relaxed">
                                    I have read and agree to the EzProperty{' '}
                                    
                  
                                    <Link 
                                        href="/pages/terms-conditions" 
                                        className="font-semibold text-brand hover:underline"
                                    > 
                                        Host Terms & Conditions 
                                    </Link> {' '} 

                                    and {' '}

                                    <Link 
                                        href="/pages/privacy-policy" 
                                        className="font-semibold text-brand hover:underline"
                                    > 
                                        Privacy Policy 
                                    </Link>.
                                </label>
                            </div>

                        
                            <button
                                type="submit"
                                disabled={processing || !data.agreeTerms}
                                className="w-full bg-brand hover:bg-brand-hover text-white font-bold py-3.5 rounded-xl transition-all active:scale-[0.98] disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2 shadow-md hover:shadow-lg text-sm sm:text-base"
                            >
                                {processing ? (
                                    <>
                                        <svg className="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Upgrading...
                                    </>
                                ) : 'Agree & Become a Host'}
                            </button>
                        </form>

                        <Link href="/" className="hidden md:block mt-5 text-sm text-slate-400 hover:text-slate-700 transition font-medium text-center w-full">
                            Maybe later
                        </Link>
                    </div>
                </div>
            </div>
        </FrontLayout>
    );
}