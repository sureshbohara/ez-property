import React from 'react';
import { usePage } from '@inertiajs/react';
import Header from '../Components/Shared/Header';
import Footer from '../Components/Shared/Footer';
export default function FrontLayout({ children }) {
    return (
        <div className="flex flex-col min-h-screen bg-white text-slate-800">
            <Header />
            <main className="flex-1 overflow-x-hidden">
                {children}
            </main>
            <Footer />
        </div>
    );
}