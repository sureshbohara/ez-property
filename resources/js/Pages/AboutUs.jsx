import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import FrontLayout from '@/Layouts/FrontLayout';
import Breadcrumb from '../Components/Shared/Breadcrumb';
import { FiTarget, FiEye } from 'react-icons/fi';

export default function AboutUs({ page, metaTitle }) {
    const { setting } = usePage().props;


    const systemName = setting?.system_name || 'EzProperty';
    const heroImage = setting?.image1_url;
    
    const headerSubtitle = setting?.info1 || "Your gateway to authentic Nepali hospitality. We connect travelers with unique homes, breathtaking landscapes, and genuine local experiences.";
    const missionText = setting?.info2 || "To empower local communities by providing a platform that promotes sustainable tourism. We aim to make authentic Nepali homestays and properties accessible to the world while ensuring hosts earn a fair income.";
    const visionText = setting?.info3 || "To become Nepal’s most trusted and loved travel platform, transforming how guests experience the country by connecting them directly with local hosts and unique cultures.";
    

    const coreValuesTitle = setting?.process_title || "Our Core Values";
    const coreValuesSubtitle = setting?.process_sub_title || ""; 
    
    const defaultValues = [
        { icon: 'fa-solid fa-heart', title: 'Authentic Hospitality', content: 'Experience Nepal like a local with genuine warmth.' },
        { icon: 'fa-solid fa-shield-halved', title: 'Secure & Reliable', content: 'Verified properties and secure payments.' },
        { icon: 'fa-solid fa-users', title: 'Community First', content: 'Supporting local hosts and the economy.' }
    ];
    
    const processItems = setting?.process_item;
    const coreValues = Array.isArray(processItems) && processItems.length > 0 ? processItems : defaultValues;

    return (
        <>
        <Head title={metaTitle || `About Us - ${systemName}`} />
        <FrontLayout>
            <Breadcrumb items={[{ title: 'Home', url: '/' }, { title: 'About Us', url: '' }]} />

            <div className="bg-white min-h-screen">
                <div className="max-w-6xl mx-auto px-4 sm:px-3 lg:px-4 py-6">


                    <div className="text-center mb-6">
                        <h1 className="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                            About {systemName}
                        </h1>
                        <p className="text-lg text-slate-500 leading-relaxed font-light max-w-2xl mx-auto">
                            {headerSubtitle}
                        </p>
                    </div>


                    <div className="mb-6 rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                        <img src={heroImage} alt={`${systemName} Landscape`} className="w-full h-64 sm:h-96 object-cover" />
                    </div>


                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-12">

                        <div className="group relative bg-slate-50 p-8 rounded-2xl border border-slate-100">
                            <div className="flex items-start gap-5 mb-4">
                                <div className="flex-shrink-0 w-14 h-14 bg-white shadow-sm rounded-xl flex items-center justify-center text-brand">
                                    <FiTarget className="w-7 h-7" />
                                </div>
                                <div>
                                    <span className="text-xs font-semibold text-brand uppercase tracking-wider">What we do</span>
                                    <h2 className="text-2xl font-bold text-slate-900 mt-1">Our Mission</h2>
                                </div>
                            </div>
                            <p className="text-slate-600 leading-relaxed text-base pl-1">{missionText}</p>
                        </div>

                        <div className="group relative bg-slate-50 p-8 rounded-2xl border border-slate-100">
                            <div className="flex items-start gap-5 mb-4">
                                <div className="flex-shrink-0 w-14 h-14 bg-white shadow-sm rounded-xl flex items-center justify-center text-brand">
                                    <FiEye className="w-7 h-7" />
                                </div>
                                <div>
                                    <span className="text-xs font-semibold text-brand uppercase tracking-wider">Where we're going</span>
                                    <h2 className="text-2xl font-bold text-slate-900 mt-1">Our Vision</h2>
                                </div>
                            </div>
                            <p className="text-slate-600 leading-relaxed text-base pl-1">{visionText}</p>
                        </div>

                    </div>


                    <div className="mb-8">
                        <div className="text-center mb-6">
                            <h2 className="text-xl font-bold text-slate-900">{coreValuesTitle}</h2>
                            {coreValuesSubtitle && <p className="text-sm text-slate-500 mt-1">{coreValuesSubtitle}</p>}
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-4 gap-6">
                            {coreValues.map((value, index) => (
                                <div key={index} className="text-center p-4 border border-slate-100 rounded-xl bg-slate-50">
                                    <div className="w-10 h-10 bg-white rounded-lg flex items-center justify-center mx-auto mb-3 shadow-sm text-brand text-lg">
                                        <i className={value.icon || 'fa-solid fa-star'}></i>
                                    </div>
                                    <h3 className="font-bold text-slate-800 mb-1 text-sm">{value.title}</h3>
                                    <p className="text-slate-500 text-xs leading-relaxed">{value.content}</p>
                                </div>
                                ))}
                        </div>
                    </div>


                    <div className="text-center border-t border-slate-100 pt-12">
                        <h2 className="text-xl font-bold text-slate-900 mb-3">Ready to explore Nepal?</h2>
                        <p className="text-slate-500 mb-6 text-sm max-w-md mx-auto">Find your perfect mountain retreat or list your property with us.</p>
                        <div className="flex flex-col sm:flex-row justify-center gap-3">
                            <Link href="/search" className="px-6 py-3 bg-brand text-white rounded-lg font-semibold hover:bg-brand-hover transition-colors text-sm">Explore Properties</Link>
                            <Link href="/become-host" className="px-6 py-3 bg-white text-slate-900 border border-slate-200 rounded-lg font-semibold hover:bg-slate-50 transition-colors text-sm">Become a Host</Link>
                        </div>
                    </div>

                </div>
            </div>
        </FrontLayout>
        </>
        );
}