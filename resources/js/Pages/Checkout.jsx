import React, { useState, useEffect } from 'react';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import Breadcrumb from '../Components/Shared/Breadcrumb';
import { FiCalendar, FiUsers, FiHome, FiCheckCircle, FiUser, FiMail, FiPhone } from 'react-icons/fi';
import { formatPrice } from '../Utils/helpers';
import toast from 'react-hot-toast';

export default function Checkout({ listing, checkIn, checkOut, guests, pricing }) {
    const { auth: { user } } = usePage().props;
    const [currency, setCurrency] = useState(() => {
        if (typeof window !== 'undefined') {
            return localStorage.getItem('selectedCurrency') || 'NPR';
        }
        return 'NPR';
    });

    useEffect(() => {
        const handleCurrencyChange = () => {
            setCurrency(localStorage.getItem('selectedCurrency') || 'NPR');
        };
        window.addEventListener('currencyChanged', handleCurrencyChange);
        return () => window.removeEventListener('currencyChanged', handleCurrencyChange);
    }, []);


    const formatCurrency = (amount) => {
        const val = parseFloat(amount) || 0;
        if (currency === 'USD') return `$${(val * 0.0075).toFixed(2)}`;
        if (currency === 'INR') return `₹${Math.round(val * 0.625)}`;
        return formatPrice(val); 
    };

    const { post, processing } = useForm({
        listing_id: listing.id,
        check_in: checkIn,
        check_out: checkOut,
        guests: guests,
        total_price: pricing.grandTotal,
    });

    const submit = (e) => {
        e.preventDefault();
        post('/checkout', {
            onSuccess: (page) => {
                if (page.props.flash.success) {
                    toast.success(page.props.flash.success);
                }
            }
        });
    };

    const formatDate = (dateStr) => {
        return new Date(dateStr).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
    };

    return (
        <>
            <Head title="Checkout - EzProperty" />
            <FrontLayout>
                <Breadcrumb items={[{ title: 'Home', url: '/' }, { title: listing.title, url: `/property/${listing.slug}` }, { title: 'Checkout', url: '' }]} />
                
                <div className="bg-white min-h-screen py-8">
                    <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h1 className="text-3xl font-extrabold text-slate-900 mb-8">Confirm and Pay</h1>
                        
                        <form onSubmit={submit} className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            
                            <div className="lg:col-span-2 space-y-6">
                                
                                <div className="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                                    <h2 className="text-xl font-bold text-slate-900 mb-1">Booking Details</h2>
                                    <p className="text-sm text-slate-500 mb-4">You are booking as:</p>
                                    <div className="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                                        <div className="w-12 h-12 bg-brand/10 rounded-full flex items-center justify-center text-brand font-bold text-lg">
                                            {user?.name?.charAt(0).toUpperCase()}
                                        </div>
                                        <div className="space-y-1">
                                            <h3 className="font-bold text-slate-900 flex items-center gap-2">
                                                <FiUser className="w-4 h-4 text-slate-500" /> {user?.name}
                                            </h3>
                                            <p className="text-sm text-slate-600 flex items-center gap-2">
                                                <FiMail className="w-4 h-4 text-slate-500" /> {user?.email}
                                            </p>
                                            {user?.phone && (
                                                <p className="text-sm text-slate-600 flex items-center gap-2">
                                                    <FiPhone className="w-4 h-4 text-slate-500" /> {user?.phone}
                                                </p>
                                            )}
                                        </div>
                                    </div>
                                </div>

                                {/* Trip Details */}
                                <div className="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                                    <h2 className="text-xl font-bold text-slate-900 mb-4">Your Trip</h2>
                                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div className="flex items-start gap-3">
                                            <FiCalendar className="w-5 h-5 text-brand mt-1" />
                                            <div>
                                                <h4 className="text-sm font-bold text-slate-800">Check-in</h4>
                                                <p className="text-sm text-slate-600">{formatDate(checkIn)}</p>
                                            </div>
                                        </div>
                                        <div className="flex items-start gap-3">
                                            <FiCalendar className="w-5 h-5 text-brand mt-1" />
                                            <div>
                                                <h4 className="text-sm font-bold text-slate-800">Checkout</h4>
                                                <p className="text-sm text-slate-600">{formatDate(checkOut)}</p>
                                            </div>
                                        </div>
                                        <div className="flex items-start gap-3">
                                            <FiUsers className="w-5 h-5 text-brand mt-1" />
                                            <div>
                                                <h4 className="text-sm font-bold text-slate-800">Guests</h4>
                                                <p className="text-sm text-slate-600">{guests} Guest{guests > 1 ? 's' : ''}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {/* Payment Method */}
                                <div className="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                                    <h2 className="text-xl font-bold text-slate-900 mb-4">Payment Method</h2>
                                    <div className="border-2 border-brand bg-brand/5 p-4 rounded-xl flex items-center gap-4">
                                        <div className="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-brand">
                                            <FiHome className="w-5 h-5" />
                                        </div>
                                        <div>
                                            <h3 className="font-bold text-slate-900">Pay at Property (Cash)</h3>
                                            <p className="text-sm text-slate-500">You can pay with cash or card directly to the host when you arrive.</p>
                                        </div>
                                        <FiCheckCircle className="w-6 h-6 text-brand ml-auto" />
                                    </div>
                                </div>

                                {/* Cancellation Policy */}
                                <div className="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                                    <h2 className="text-xl font-bold text-slate-900 mb-2">Cancellation Policy</h2>
                                    <p className="text-sm text-slate-600">Free cancellation for 48 hours. Review the full cancellation policy for more details.</p>
                                </div>
                            </div>

      
                            <div className="lg:col-span-1">
                                <div className="bg-white p-6 rounded-2xl shadow-xl border border-slate-100 sticky top-24">
                                    <div className="flex gap-4 mb-6 pb-6 border-b border-slate-100">
                                        <img 
                                            src={listing.image_url} 
                                            alt={listing.title} 
                                            className="w-24 h-24 rounded-xl object-cover"
                                        />
                                        <div>
                                            <h3 className="font-bold text-slate-900 leading-tight mb-1">{listing.title}</h3>
                                            <p className="text-sm text-slate-500 flex items-center gap-1">
                                                <FiUsers className="w-3 h-3" /> {listing.minimum_nights} night min stay
                                            </p>
                                        </div>
                                    </div>

                                    <h3 className="text-lg font-bold text-slate-900 mb-4">Price Details</h3>
                                    
                                    <div className="space-y-3 text-sm text-slate-600">
                                        <div className="flex justify-between">
                                            <span>
                                                {formatCurrency(pricing.basePrice)} x {pricing.nights} night{pricing.nights > 1 ? 's' : ''}
                                            </span>
                                            <span className="font-medium text-slate-800">{formatCurrency(pricing.totalNightsPrice)}</span>
                                        </div>
                                        <div className="flex justify-between">
                                            <span>Cleaning fee</span>
                                            <span className="font-medium text-slate-800">{formatCurrency(pricing.cleaningFee)}</span>
                                        </div>
                                        <div className="flex justify-between">
                                            <span>Service fee</span>
                                            <span className="font-medium text-slate-800">{formatCurrency(pricing.serviceFee)}</span>
                                        </div>
                                    </div>

                                    <div className="flex justify-between font-bold text-slate-900 text-lg mt-6 pt-4 border-t border-slate-200">
                                        <span>Total ({currency})</span>
                                        <span>{formatCurrency(pricing.grandTotal)}</span>
                                    </div>

                                    <button 
                                        type="submit" 
                                        disabled={processing}
                                        className="w-full mt-6 bg-gradient-to-r from-brand to-brand-hover text-white font-bold py-3.5 rounded-xl transition-all active:scale-[0.98] disabled:opacity-50 flex items-center justify-center gap-2 shadow-lg shadow-brand/20"
                                    >
                                        {processing ? 'Confirming...' : 'Confirm Booking'}
                                    </button>
                                    <p className="text-center text-xs text-slate-500 mt-3">You won't be charged yet</p>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </FrontLayout>
        </>
    );
}