import React, { useState, useEffect } from 'react';
import { Head, usePage } from '@inertiajs/react';
import FrontLayout from '@/Layouts/FrontLayout';
import toast from 'react-hot-toast';
import { FiHome, FiCalendar, FiMessageSquare, FiStar, FiSettings, FiHeart } from 'react-icons/fi';

import Overview from '@/Components/Account/Overview';
import Reservations from '@/Components/Account/Reservations';
import Reviews from '@/Components/Account/Reviews';
import Messages from '@/Components/Account/Messages';
import Settings from '@/Components/Account/Settings';
import SavedTab from '@/Components/Account/SavedTab';


export default function Dashboard({ role, stats, listings, bookings, reviews, earningsData, messages, savedListings, myListingsSavedByOthers, savedCount, conversations, totalUnreadCount }) {
    const { props } = usePage();
    const user = props.auth?.user; 
    const [activeTab, setActiveTab] = useState('overview');
    const { flash } = props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash]);

 
    const tabs = [
        { id: 'overview', label: 'Overview', icon: FiHome },
        { id: 'bookings', label: role === 'host' ? 'Reservations' : 'My Trips', icon: FiCalendar },
        { id: 'reviews', label: 'Reviews', icon: FiStar },
        { id: 'messages', label: 'Messages', icon: FiMessageSquare, count: totalUnreadCount }, 
        { id: 'saved', label: 'Saved Properties', icon: FiHeart }, 
        { id: 'settings', label: 'Settings', icon: FiSettings },
    ];

    if (!user) return null; 

    return (
        <FrontLayout>
            <Head title="Dashboard - EzProperty" />
            <div className="bg-white min-h-[calc(100vh-80px)] py-8">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">
                    <aside className="md:w-64 flex-shrink-0">
                        <div className="bg-slate-50 rounded-xl border border-slate-200 p-6 sticky top-24">
                            <div className="flex flex-col items-center text-center mb-6">
                                <img src={user.image_url || `https://ui-avatars.com/api/?name=${user.name}&background=0d9488&color=fff`} alt={user.name} className="w-20 h-20 rounded-full object-cover mb-3 border-2 border-brand" />
                                <h3 className="text-lg font-bold text-slate-800">{user.name}</h3>
                                <span className={`mt-2 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide ${role === 'host' ? 'bg-brand/10 text-brand' : 'bg-slate-100 text-slate-600'}`}>
                                    {role === 'host' ? 'Host' : 'Guest'}
                                </span>
                            </div>
                            
                            <nav className="space-y-1">
                                {tabs.map((tab) => (
                                    <button 
                                        key={tab.id} 
                                        onClick={() => setActiveTab(tab.id)} 
                                        className={`w-full flex items-center justify-between px-4 py-3 rounded-lg font-medium text-sm transition-colors ${activeTab === tab.id ? 'bg-brand/10 text-brand font-semibold' : 'text-slate-600 hover:bg-slate-50'}`}
                                    >
                                        <div className="flex items-center gap-3">
                                            <tab.icon className="h-5 w-5" /> 
                                            {tab.label}
                                        </div>
                                        
                                        {tab.count > 0 && (
                                            <span className="bg-red-500 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full animate-pulse">
                                                {tab.count > 9 ? '9+' : tab.count}
                                            </span>
                                        )}
                                    </button>
                                ))}
                            </nav>
                        </div>
                    </aside>

                    <main className="flex-1 min-w-0">
                        {activeTab === 'overview' && <Overview role={role} stats={stats} bookings={bookings} earningsData={earningsData} reviews={reviews} savedCount={savedCount} />}
                        {activeTab === 'bookings' && <Reservations role={role} bookings={bookings} />}
                        {activeTab === 'reviews' && <Reviews role={role} reviews={reviews} />}
                        
                        {activeTab === 'messages' && <Messages conversations={conversations} currentUser={user} />}
                        
                        {activeTab === 'saved' && <SavedTab role={role} savedListings={savedListings} myListingsSavedByOthers={myListingsSavedByOthers || []} />}
                        {activeTab === 'settings' && <Settings user={user} />}
                    </main>
                </div>
            </div>
        </FrontLayout>
    );
}