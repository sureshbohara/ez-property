import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import FrontLayout from '@/Layouts/FrontLayout';
import Breadcrumb from '../Components/Shared/Breadcrumb';
import { FiChevronDown } from 'react-icons/fi';

export default function Faqs({ faqs }) {
    const [openIndex, setOpenIndex] = useState(null);

    const toggleFaq = (index) => {
        setOpenIndex(openIndex === index ? null : index);
    };

    return (
        <>
        <Head title="Frequently Asked Questions - EzProperty" />
        <FrontLayout>
            <Breadcrumb items={[{ title: 'Home', url: '/' }, { title: 'FAQs', url: '' }]} />

            <div className="bg-white min-h-screen">
                <div className="max-w-7xl mx-auto px-4 sm:px-3 lg:px-8 py-5">


                    <div className="text-center mb-12">
                        <h1 className="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight mb-4">
                            Frequently Asked Questions
                        </h1>
                        <p className="text-lg text-slate-500 leading-relaxed font-light">
                            Got questions? We've got answers. If you can't find what you're looking for, feel free to contact us!
                        </p>
                    </div>

                    
                    <div className="space-y-1">
                        {faqs && faqs.length > 0 ? (
                            faqs.map((faq, index) => {
                                const isOpen = openIndex === index;

                                return (
                                    <div 
                                        key={faq.id} 
                                        className={`bg-white border rounded-2xl overflow-hidden transition-all duration-300 shadow-sm ${isOpen ? 'border-brand ring-1 ring-brand/20' : 'border-slate-200 hover:border-slate-300'}`}
                                    >
                                        <button
                                            onClick={() => toggleFaq(index)}
                                            className="w-full flex items-center justify-between p-5 sm:p-6 text-left focus:outline-none group"
                                        >
                                            <span className={`font-semibold text-base sm:text-lg pr-4 transition-colors ${isOpen ? 'text-brand' : 'text-slate-800 group-hover:text-slate-900'}`}>
                                                {faq.question}
                                            </span>

                                                {/* Icon Container */}
                                            <div className={`flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300 ${isOpen ? 'bg-brand text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200'}`}>
                                                <FiChevronDown 
                                                    className={`w-5 h-5 transition-transform duration-300 ${isOpen ? 'rotate-180' : ''}`} 
                                                />
                                            </div>
                                        </button>

                                        <div 
                                            className={`grid transition-all duration-300 ease-in-out ${isOpen ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'}`}
                                        >
                                            <div className="overflow-hidden">
                                                    {/* Left border for visual hierarchy in answers */}
                                                <p className="mx-5 sm:mx-6 mb-5 sm:mb-6 pl-4 border-l-2 border-brand/30 text-slate-600 leading-relaxed text-sm sm:text-base">
                                                    {faq.answer}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    );
                            })
                            ) : (
                            <div className="text-center py-16 bg-white rounded-2xl border border-slate-100 shadow-sm">
                                <p className="text-slate-400 text-lg">No FAQs available right now. Please check back later.</p>
                            </div>
                            )}
                        </div>

                    </div>
                </div>
            </FrontLayout>
            </>
            );
}