import React from 'react';
import { Link } from '@inertiajs/react';

export default function Footer() {
    return (
        <footer class="bg-slate-50 border-t border-slate-200 pt-12 pb-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-[1536px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="md:col-span-2">
                <a href="#" class="flex items-center gap-3 group w-fit mb-4">
                    <div class="w-10 h-10 bg-brand rounded-xl flex items-center justify-center shadow-md shadow-brand/20">
                        <i class="fa-solid fa-house-chimney-window text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="text-xl font-extrabold text-dark tracking-tight">Ez<span class="text-brand">Property</span></span>
                        <span class="text-[9px] font-semibold text-slate-500 tracking-[0.2em] uppercase mt-1">Stay • Experience</span>
                    </div>
                </a>
                <p class="text-slate-600 text-sm leading-relaxed max-w-md mb-4">
                    Your gateway to authentic Nepali hospitality. Find your perfect mountain retreat, city apartment, or jungle lodge.
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-medium text-slate-600 shadow-sm">#Kathmandu</span>
                    <span class="px-3 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-medium text-slate-600 shadow-sm">#Pokhara</span>
                    <span class="px-3 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-medium text-slate-600 shadow-sm">#Chitwan</span>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-dark mb-4 text-sm uppercase tracking-wider">Support</h4>
                <ul class="space-y-3 text-sm text-slate-600">
                    <li><a href="#" class="hover:text-brand transition">Help Center</a></li>
                    <li><a href="#" class="hover:text-brand transition">Safety Information</a></li>
                    <li><a href="#" class="hover:text-brand transition">Cancellation Options</a></li>
                    <li><a href="#" class="hover:text-brand transition">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-dark mb-4 text-sm uppercase tracking-wider">Host</h4>
                <ul class="space-y-3 text-sm text-slate-600">
                    <li><a href="#" class="hover:text-brand transition">List Your Property</a></li>
                    <li><a href="#" class="hover:text-brand transition">Host Resources</a></li>
                    <li><a href="#" class="hover:text-brand transition">Responsible Hosting</a></li>
                    <li><a href="#" class="hover:text-brand transition">Community Forum</a></li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-8 border-t border-slate-200">
            <div class="text-sm text-slate-500 flex flex-col md:flex-row items-center gap-2 md:gap-4 text-center md:text-left">
                <span class="flex items-center gap-2"><i class="fa-regular fa-copyright text-xs"></i> 2026 BNB Nepali Pvt. Ltd.</span>
                <div class="flex gap-4 text-xs font-medium">
                    <a href="#" class="hover:text-dark transition">Privacy</a>
                    <a href="#" class="hover:text-dark transition">Terms</a>
                    <a href="#" class="hover:text-dark transition">Sitemap</a>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Secure:</span>
                <i class="fa-brands fa-cc-visa text-xl text-slate-600"></i>
                <i class="fa-brands fa-cc-mastercard text-xl text-slate-600"></i>
                <span class="text-[10px] font-bold text-green-600 border border-green-200 px-2 py-0.5 rounded bg-green-50">eSewa</span>
                <span class="text-[10px] font-bold text-purple-600 border border-purple-200 px-2 py-0.5 rounded bg-purple-50">Khalti</span>
            </div>
        </div>
    </div>
</footer>
    );
}