import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Footer() {
    const { setting } = usePage().props;
    const logoUrl = setting?.image2_url || setting?.logo_url;
    const systemName = setting?.system_name || "Ez Property";
    const footerDesc = setting?.info4 || "Your gateway to authentic Nepali hospitality. Find your perfect mountain retreat, city apartment, or jungle lodge.";

    return (
        <footer className="bg-slate-50 border-t border-slate-200 pt-12 pb-8 px-4 sm:px-6 lg:px-8">
            <div className="max-w-[1536px] mx-auto">
                <div className="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                    <div className="md:col-span-2">
                        
                        <Link href="/" className="flex items-center gap-3 group w-fit mb-4">
                            {logoUrl ? (
                                <img src={logoUrl} alt={systemName} className="h-10 w-auto object-contain" />
                            ) : (
            
                                <>
                                    <div className="w-10 h-10 bg-brand rounded-xl flex items-center justify-center shadow-md shadow-brand/20">
                                        <i className="fa-solid fa-house-chimney-window text-white text-lg"></i>
                                    </div>
                                    <div className="flex flex-col leading-none">
                                        <span className="text-xl font-extrabold text-dark tracking-tight">Ez<span className="text-brand">Property</span></span>
                                        <span className="text-[9px] font-semibold text-slate-500 tracking-[0.2em] uppercase mt-1">Stay • Experience</span>
                                    </div>
                                </>
                            )}
                        </Link>

            
                        <p className="text-slate-600 text-sm leading-relaxed max-w-md mb-4">
                            {footerDesc}
                        </p>
                        
                        <div className="flex flex-wrap gap-2">
                            <span className="px-3 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-medium text-slate-600 shadow-sm">#Kathmandu</span>
                            <span className="px-3 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-medium text-slate-600 shadow-sm">#Pokhara</span>
                            <span className="px-3 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-medium text-slate-600 shadow-sm">#Chitwan</span>
                        </div>
                    </div>
                    
                    <div>
                        <h4 className="font-bold text-dark mb-4 text-sm uppercase tracking-wider">Support</h4>
                        <ul className="space-y-3 text-sm text-slate-600">
                            <li><Link href="/" className="hover:text-brand transition">Help Center</Link></li>
                            <li><Link href="/pages/cancellation-policy" className="hover:text-brand transition">Cancellation Policy</Link></li>
                            <li><Link href="/pages/about-us" className="hover:text-brand transition">About Us</Link></li>
                            <li><Link href="/pages/contact-us" className="hover:text-brand transition">Contact Us</Link></li>
                            <li><Link href="/faqs" className="hover:text-brand transition">FAQs</Link></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 className="font-bold text-dark mb-4 text-sm uppercase tracking-wider">Host</h4>
                        <ul className="space-y-3 text-sm text-slate-600">
                            <li><Link href="/become-host" className="hover:text-brand transition">List Your Property</Link></li>
                            <li><Link href="/pages/host-resources" className="hover:text-brand transition">Host Resources</Link></li>
                            <li><Link href="/pages/responsible-hosting" className="hover:text-brand transition">Responsible Hosting</Link></li>
                            <li><Link href="/pages/community-forum" className="hover:text-brand transition">Community Forum</Link></li>
                        </ul>
                    </div>
                </div>
                
                <div className="flex flex-col md:flex-row items-center justify-between gap-4 pt-8 border-t border-slate-200">
                    <div className="text-sm text-slate-500 flex flex-col md:flex-row items-center gap-2 md:gap-4 text-center md:text-left">
                        <span className="flex items-center gap-2"><i className="fa-regular fa-copyright text-xs"></i> {new Date().getFullYear()} {systemName}. All Rights Reserved.</span>
                        <div className="flex gap-4 text-xs font-medium">
                            <Link href="/pages/privacy-policy" className="hover:text-dark transition">Privacy</Link>
                            <Link href="/pages/terms-conditions" className="hover:text-dark transition">Terms</Link>
                        </div>
                    </div>
                    <div className="flex items-center gap-3 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm">
                        <span className="text-[10px] font-bold uppercase tracking-widest text-slate-400">Secure:</span>
                        <i className="fa-brands fa-cc-visa text-xl text-slate-600"></i>
                        <i className="fa-brands fa-cc-mastercard text-xl text-slate-600"></i>
                        <span className="text-[10px] font-bold text-green-600 border border-green-200 px-2 py-0.5 rounded bg-green-50">eSewa</span>
                        <span className="text-[10px] font-bold text-purple-600 border border-purple-200 px-2 py-0.5 rounded bg-purple-50">Khalti</span>
                    </div>
                </div>
            </div>
        </footer>
    );
}