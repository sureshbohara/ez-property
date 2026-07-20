import React, { useState, useEffect } from 'react';
import { formatPrice } from '../../Utils/helpers';

export default function PropertyCalendar({ 
    listing, 
    calendarData, 
    checkIn,
    setCheckIn,
    checkOut,
    setCheckOut
}) {
    const [currentDate, setCurrentDate] = useState(new Date());


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

    const getPriceForDate = (dateStr) => {
        const dayData = calendarData?.[dateStr];
        if (dayData && dayData.price) {
            return dayData.price;
        }
        return listing.base_price;
    };

    const isAvailable = (dateStr) => {
        const dayData = calendarData?.[dateStr];
        if (dayData && (dayData.status === 'blocked' || dayData.status === 'booked')) {
            return false;
        }
        return true;
    };

    const handleDateClick = (dateStr) => {
        if (!checkIn || (checkIn && checkOut)) {
            setCheckIn(dateStr);
            setCheckOut(null);
        } else {
            if (new Date(dateStr) > new Date(checkIn)) {
                setCheckOut(dateStr);
            } else {
                setCheckIn(dateStr);
                setCheckOut(null);
            }
        }
    };

    const generateCalendar = (year, month) => {
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDay = new Date(year, month, 1).getDay();
        const days = [];

        for (let i = 0; i < firstDay; i++) {
            days.push(<div key={`empty-${i}`} className="aspect-square"></div>);
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const dateObj = new Date(year, month, d);
            const dateStr = dateObj.toISOString().split('T')[0];
            const isPast = dateObj < new Date(new Date().setHours(0,0,0,0));
            const available = isAvailable(dateStr);
            const price = getPriceForDate(dateStr);
            
            let classes = "aspect-square flex flex-col items-center justify-center rounded-full text-sm font-medium cursor-pointer transition-all duration-200 relative ";
            
            if (isPast || !available) {
                classes += "text-slate-300 cursor-not-allowed line-through decoration-slate-300";
            } else if (checkIn === dateStr || checkOut === dateStr) {
                classes += "bg-brand text-white font-bold shadow-md shadow-brand/30 z-10";
            } else if (checkIn && checkOut && dateObj > new Date(checkIn) && dateObj < new Date(checkOut)) {
                classes += "bg-brand-light text-brand rounded-none z-0";
            } else {
                classes += "hover:bg-brand-light hover:text-brand font-semibold";
            }

            days.push(
                <div key={d} className={classes} onClick={() => (!isPast && available) && handleDateClick(dateStr)}>
                    <span>{d}</span>
                    {/* 🔑 3. Formatted Daily Price Display */}
                    {(!isPast && available) && <span className="text-[9px] font-semibold text-brand mt-0.5">{formatCurrency(price)}</span>}
                </div>
            );
        }
        return days;
    };

    return (
        <section id="availability" className="border-t border-slate-200 pt-10 scroll-mt-36">
            <h2 className="text-2xl font-bold text-dark mb-6">Availability</h2>
            <div className="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                <div className="flex items-center justify-between mb-6">
                    <h3 className="font-bold text-lg text-dark">Select your dates</h3>
                    <button onClick={() => { setCheckIn(null); setCheckOut(null); }} className="text-sm font-semibold text-brand hover:text-brand-hover underline underline-offset-4">Clear dates</button>
                </div>
                
                <div className="mb-6">
                    <div className="flex items-center justify-between mb-4">
                        <button onClick={() => changeMonth(-1)} className="p-2 hover:bg-slate-100 rounded-full transition"><i className="fa-solid fa-chevron-left text-slate-600"></i></button>
                        <h3 className="font-semibold text-dark text-center flex-1">
                            {currentDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}
                        </h3>
                        <button onClick={() => changeMonth(1)} className="p-2 hover:bg-slate-100 rounded-full transition"><i className="fa-solid fa-chevron-right text-slate-600"></i></button>
                    </div>
                    <div className="grid grid-cols-7 gap-1 text-center mb-2">
                        {['Su','Mo','Tu','We','Th','Fr','Sa'].map(d => (
                            <div key={d} className="text-xs font-semibold text-slate-400 uppercase tracking-wider py-2">{d}</div>
                        ))}
                    </div>
                    <div className="grid grid-cols-7 gap-1">
                        {generateCalendar(currentDate.getFullYear(), currentDate.getMonth())}
                    </div>
                </div>

                <div className="flex flex-wrap gap-6 pt-6 border-t border-slate-100 text-xs font-medium text-slate-600">
                    <div className="flex items-center gap-2"><div className="w-4 h-4 rounded-full bg-brand shadow-sm shadow-brand/30"></div> Selected</div>
                    <div className="flex items-center gap-2"><div className="w-4 h-4 rounded-full bg-slate-100 border border-slate-200"></div> Available</div>
                    <div className="flex items-center gap-2"><div className="w-4 h-4 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center text-[10px] line-through decoration-slate-300">9</div> Unavailable</div>
                </div>
            </div>
        </section>
    );
}