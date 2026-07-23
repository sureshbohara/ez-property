import React, { useState, useEffect, useMemo } from 'react';
import { formatPrice } from '../../Utils/helpers';
import { router } from '@inertiajs/react';
export default function BookingCard({ 
    listing, 
    calendarData, 
    checkIn, 
    checkOut, 
    onDateFieldClick,
    guests,
    setGuests,
    showGuestDropdown,
    setShowGuestDropdown
}) {

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

    const totalGuests = guests.adults + guests.children;
    const basePrice = parseFloat(listing.base_price) || 0;
    const cleaningFee = parseFloat(listing.cleaning_fee) || 0;
    const serviceFee = parseFloat(listing.service_fee) || 0;

    const pricingDetails = useMemo(() => {
        if (!checkIn || !checkOut) {
            return { 
                nights: 0,
                totalNightsPrice: 0,
                grandTotal: 0,
                hasBlockedDates: false,
                avgPricePerNight: basePrice,
                hasSpecialPricing: false
            };
        }

        const start = new Date(checkIn);
        const end = new Date(checkOut);
        let totalNightsPrice = 0;
        let nights = 0;
        let hasBlockedDates = false;
        let hasSpecialPricing = false;

        let currentDate = new Date(start);

        while (currentDate < end) {
            const dateStr = currentDate.toISOString().split('T')[0];
            const dayData = calendarData?.[dateStr];
            
            if (dayData && (dayData.status === 'blocked' || dayData.status === 'booked')) {
                hasBlockedDates = true;
            }

            let dailyPrice = basePrice;
            if (dayData && dayData.price) {
                dailyPrice = parseFloat(dayData.price);
                hasSpecialPricing = true;
            }

            totalNightsPrice += dailyPrice;
            nights++;
            currentDate.setDate(currentDate.getDate() + 1);
        }

        const avgPricePerNight = nights > 0 ? totalNightsPrice / nights : basePrice;

        return {
            nights,
            totalNightsPrice,
            grandTotal: totalNightsPrice + cleaningFee + serviceFee,
            hasBlockedDates,
            avgPricePerNight,
            hasSpecialPricing
        };
    }, [checkIn, checkOut, listing, calendarData, basePrice, cleaningFee, serviceFee]);

    const updateGuests = (type, change) => {
        const newValue = guests[type] + change;
        if (type === 'adults' && newValue >= 1 && newValue <= 10) setGuests({...guests, adults: newValue});
        else if (type === 'children' && newValue >= 0 && newValue <= 10) setGuests({...guests, children: newValue});
    };


    const handleReserve = () => {
        if (pricingDetails.hasBlockedDates || !checkIn || !checkOut) return;
        router.get('/checkout', {
            listing_id: listing.id,
            check_in: checkIn,
            check_out: checkOut,
            guests: totalGuests
        });
    };

    const formatDate = (dateStr) => {
        if (!dateStr) return "Add dates";
        const d = new Date(dateStr);
        return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    };

    const displayPrice = checkIn && checkOut && pricingDetails.nights > 0
    ? pricingDetails.avgPricePerNight 
    : basePrice;

    return (
        <div className="sticky top-24 z-30 border border-slate-200 rounded-2xl shadow-xl p-6 bg-white">
            <div className="flex items-baseline justify-between mb-6">
                <div>
                 
                    <span className="text-2xl font-bold text-dark">{formatCurrency(displayPrice)}</span>
                    <span className="text-slate-600"> / night</span>
                    
                    {pricingDetails.hasSpecialPricing && checkIn && checkOut && (
                        <div className="mt-1 text-xs text-brand font-medium flex items-center gap-1">
                            <i className="fa-solid fa-tag"></i> Special rate applied
                        </div>
                        )}
                </div>
            </div>

            {pricingDetails.hasBlockedDates && (
                <div className="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-start gap-2">
                    <i className="fa-solid fa-triangle-exclamation mt-0.5"></i>
                    <span>Some selected dates are unavailable. Please choose different dates.</span>
                </div>
                )}

            <div className="relative mb-4">
                <div className="border border-slate-300 rounded-xl">
                    <div className="grid grid-cols-2 border-b border-slate-300">
                        <div className="p-3 border-r border-slate-300 cursor-pointer hover:bg-slate-50 transition" onClick={onDateFieldClick}>
                            <label className="block text-[10px] font-bold text-dark uppercase tracking-wide">Check-in</label>
                            <input type="text" value={formatDate(checkIn)} className="w-full text-sm text-slate-700 outline-none bg-transparent cursor-pointer font-medium mt-1" readOnly />
                        </div>
                        <div className="p-3 cursor-pointer hover:bg-slate-50 transition" onClick={onDateFieldClick}>
                            <label className="block text-[10px] font-bold text-dark uppercase tracking-wide">Checkout</label>
                            <input type="text" value={formatDate(checkOut)} className="w-full text-sm text-slate-700 outline-none bg-transparent cursor-pointer font-medium mt-1" readOnly />
                        </div>
                    </div>
                    <div className="p-3 cursor-pointer hover:bg-slate-50 transition border-t border-slate-300" onClick={() => setShowGuestDropdown(!showGuestDropdown)}>
                        <label className="block text-[10px] font-bold text-dark uppercase tracking-wide">Guests</label>
                        <div className="flex justify-between items-center mt-1">
                            <span className="text-sm text-slate-700 font-medium">{totalGuests} guest{totalGuests > 1 ? 's' : ''}</span>
                            <i className="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                        </div>
                    </div>
                </div>
                
                {showGuestDropdown && (
                    <div className="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-slate-100 z-50 p-4">
                        <div className="space-y-4">
                            <div className="flex items-center justify-between py-2 border-b border-slate-100">
                                <div>
                                    <div className="text-sm font-medium text-dark">Adults</div>
                                    <div className="text-xs text-slate-500">Ages 13 or above</div>
                                </div>
                                <div className="flex items-center gap-3">
                                    <button className="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-brand hover:text-brand transition" onClick={(e) => { e.stopPropagation(); updateGuests('adults', -1); }}><i className="fa-solid fa-minus text-xs"></i></button>
                                    <span className="w-6 text-center font-medium text-dark text-sm">{guests.adults}</span>
                                    <button className="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-brand hover:text-brand transition" onClick={(e) => { e.stopPropagation(); updateGuests('adults', 1); }}><i className="fa-solid fa-plus text-xs"></i></button>
                                </div>
                            </div>
                            <div className="flex items-center justify-between py-2">
                                <div>
                                    <div className="text-sm font-medium text-dark">Children</div>
                                    <div className="text-xs text-slate-500">Ages 2-12</div>
                                </div>
                                <div className="flex items-center gap-3">
                                    <button className="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-brand hover:text-brand transition" onClick={(e) => { e.stopPropagation(); updateGuests('children', -1); }}><i className="fa-solid fa-minus text-xs"></i></button>
                                    <span className="w-6 text-center font-medium text-dark text-sm">{guests.children}</span>
                                    <button className="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-brand hover:text-brand transition" onClick={(e) => { e.stopPropagation(); updateGuests('children', 1); }}><i className="fa-solid fa-plus text-xs"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    )}
            </div>
            
            <button 
                onClick={handleReserve}
                disabled={pricingDetails.hasBlockedDates || !checkIn || !checkOut}
                className={`w-full font-bold py-3.5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2 ${
                    pricingDetails.hasBlockedDates || !checkIn || !checkOut 
                    ? 'bg-slate-300 text-slate-500 cursor-not-allowed shadow-none' 
                    : 'bg-gradient-to-r from-brand to-brand-hover hover:from-brand-hover hover:to-brand text-white shadow-brand/20 active:scale-[0.98]'
                }`}
            >
                Reserve <i className="fa-solid fa-arrow-right text-xs"></i>
            </button>
            <p className="text-center text-xs text-slate-500 mt-3">You won't be charged yet</p>

            {checkIn && checkOut && pricingDetails.nights > 0 && (
                <div className="mt-6 space-y-3 text-sm text-slate-700">
                    <div className="flex justify-between underline decoration-slate-300 underline-offset-4">
                        <span>
                            {formatCurrency(displayPrice)} × {pricingDetails.nights} night{pricingDetails.nights > 1 ? 's' : ''}
                        </span>
                        <span className="font-medium">{formatCurrency(pricingDetails.totalNightsPrice)}</span>
                    </div>
                    <div className="flex justify-between underline decoration-slate-300 underline-offset-4">
                        <span>Cleaning fee</span>
                        <span className="font-medium">{formatCurrency(cleaningFee)}</span>
                    </div>
                    <div className="flex justify-between underline decoration-slate-300 underline-offset-4">
                        <span>Service fee</span>
                        <span className="font-medium">{formatCurrency(serviceFee)}</span>
                    </div>
                    <div className="border-t border-slate-200 pt-4 mt-4 flex justify-between font-bold text-dark text-lg">
                        <span>Total</span>
                        <span>{formatCurrency(pricingDetails.grandTotal)}</span>
                    </div>
                </div>
                )}
        </div>
        );
}