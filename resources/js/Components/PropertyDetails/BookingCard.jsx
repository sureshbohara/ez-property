import React, { useState } from 'react';

export default function BookingCard({ listing }) {
    const [guests, setGuests] = useState({ adults: 1, children: 0 });
    const [showGuestDropdown, setShowGuestDropdown] = useState(false);

    const totalGuests = guests.adults + guests.children;
    const pricePerNight = parseFloat(listing.base_price) || 0;
    const cleaningFee = parseFloat(listing.cleaning_fee) || 0;
    const serviceFee = parseFloat(listing.service_fee) || 0;
    
    // Demo calculation (2 nights)
    const nights = 2; 
    const totalNightsPrice = pricePerNight * nights;
    const grandTotal = totalNightsPrice + cleaningFee + serviceFee;

    const updateGuests = (type, change) => {
        const newValue = guests[type] + change;
        if (type === 'adults' && newValue >= 1 && newValue <= 10) setGuests({...guests, adults: newValue});
        else if (type === 'children' && newValue >= 0 && newValue <= 10) setGuests({...guests, children: newValue});
    };

    return (
        <div className="sticky top-24 border border-slate-200 rounded-2xl shadow-xl p-6 bg-white">
            <div className="flex items-baseline justify-between mb-6">
                <div>
                    <span className="text-2xl font-bold text-dark">Rs. {pricePerNight.toLocaleString()}</span>
                    <span className="text-slate-600"> / night</span>
                </div>
            </div>

            <div className="relative mb-4">
                <div className="border border-slate-300 rounded-xl overflow-hidden">
                    <div className="grid grid-cols-2 border-b border-slate-300">
                        <div className="p-3 border-r border-slate-300 cursor-pointer hover:bg-slate-50 transition">
                            <label className="block text-[10px] font-bold text-dark uppercase tracking-wide">Check-in</label>
                            <input type="text" value="Add dates" className="w-full text-sm text-slate-700 outline-none bg-transparent cursor-pointer font-medium mt-1" readOnly />
                        </div>
                        <div className="p-3 cursor-pointer hover:bg-slate-50 transition">
                            <label className="block text-[10px] font-bold text-dark uppercase tracking-wide">Checkout</label>
                            <input type="text" value="Add dates" className="w-full text-sm text-slate-700 outline-none bg-transparent cursor-pointer font-medium mt-1" readOnly />
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
                                    <button className="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-brand hover:text-brand transition" onClick={() => updateGuests('adults', -1)}><i className="fa-solid fa-minus text-xs"></i></button>
                                    <span className="w-6 text-center font-medium text-dark text-sm">{guests.adults}</span>
                                    <button className="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-brand hover:text-brand transition" onClick={() => updateGuests('adults', 1)}><i className="fa-solid fa-plus text-xs"></i></button>
                                </div>
                            </div>
                            <div className="flex items-center justify-between py-2">
                                <div>
                                    <div className="text-sm font-medium text-dark">Children</div>
                                    <div className="text-xs text-slate-500">Ages 2-12</div>
                                </div>
                                <div className="flex items-center gap-3">
                                    <button className="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-brand hover:text-brand transition" onClick={() => updateGuests('children', -1)}><i className="fa-solid fa-minus text-xs"></i></button>
                                    <span className="w-6 text-center font-medium text-dark text-sm">{guests.children}</span>
                                    <button className="w-8 h-8 rounded-full border border-slate-300 flex items-center justify-center hover:border-brand hover:text-brand transition" onClick={() => updateGuests('children', 1)}><i className="fa-solid fa-plus text-xs"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                )}
            </div>
            
            <button className="w-full bg-gradient-to-r from-brand to-brand-hover hover:from-brand-hover hover:to-brand text-white font-bold py-3.5 rounded-xl transition-all shadow-md shadow-brand/20 active:scale-[0.98] flex items-center justify-center gap-2">
                Reserve <i className="fa-solid fa-arrow-right text-xs"></i>
            </button>
            <p className="text-center text-xs text-slate-500 mt-3">You won't be charged yet</p>

            <div className="mt-6 space-y-3 text-sm text-slate-700">
                <div className="flex justify-between underline decoration-slate-300 underline-offset-4">
                    <span>Rs. {pricePerNight} x {nights} nights</span>
                    <span className="font-medium">Rs. {totalNightsPrice.toLocaleString()}</span>
                </div>
                <div className="flex justify-between underline decoration-slate-300 underline-offset-4">
                    <span>Cleaning fee</span>
                    <span className="font-medium">Rs. {cleaningFee.toLocaleString()}</span>
                </div>
                <div className="flex justify-between underline decoration-slate-300 underline-offset-4">
                    <span>Service fee</span>
                    <span className="font-medium">Rs. {serviceFee.toLocaleString()}</span>
                </div>
                <div className="border-t border-slate-200 pt-4 mt-4 flex justify-between font-bold text-dark text-lg">
                    <span>Total</span>
                    <span>Rs. {grandTotal.toLocaleString()}</span>
                </div>
            </div>
        </div>
    );
}