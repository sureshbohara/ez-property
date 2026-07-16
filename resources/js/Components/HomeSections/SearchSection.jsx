import React, { useState, useEffect } from 'react';
export default function SearchSection({ popularDestinations = [] }) {
    const [isMobileExpanded, setIsMobileExpanded] = useState(false);
    const [activeSection, setActiveSection] = useState(null);
    const [guests, setGuests] = useState({ adults: 0, children: 0 });
    const [whereValue, setWhereValue] = useState('');
    
    const [checkIn, setCheckIn] = useState(null);
    const [checkOut, setCheckOut] = useState(null);
    const [currentDate, setCurrentDate] = useState(new Date());

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (!event.target.closest('.search-container')) {
                setActiveSection(null);
            }
        };
        document.addEventListener('click', handleClickOutside);
        return () => document.removeEventListener('click', handleClickOutside);
    }, []);
    const toggleSection = (e, section) => {
        e.stopPropagation();
        setActiveSection(activeSection === section ? null : section);
    };

    const updateGuests = (type, change) => {
        const newValue = guests[type] + change;
        if (newValue >= 0 && newValue <= 10) {
            setGuests({ ...guests, [type]: newValue });
        }
    };

    const getGuestLabel = () => {
        if (guests.adults === 0 && guests.children === 0) return 'Add guests';
        const parts = [];
        if (guests.adults > 0) parts.push(`${guests.adults} Adult${guests.adults > 1 ? 's' : ''}`);
        if (guests.children > 0) parts.push(`${guests.children} Child${guests.children > 1 ? 'ren' : ''}`);
        return parts.join(', ');
    };

    const formatDate = (date) => {
        if (!date) return '';
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    };

    const handleDateClick = (date) => {
        if (!checkIn || (checkIn && checkOut)) {
            setCheckIn(date);
            setCheckOut(null);
        } else {
            if (date > checkIn) {
                setCheckOut(date);
                setActiveSection(null); 
            } else {
                setCheckIn(date);
                setCheckOut(null);
            }
        }
    };
    const changeMonth = (offset) => {
        setCurrentDate(new Date(currentDate.getFullYear(), currentDate.getMonth() + offset, 1));
    };
    const generateCalendar = (year, month) => {
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDay = new Date(year, month, 1).getDay();
        const days = [];

        for (let i = 0; i < firstDay; i++) {
            days.push(<div key={`empty-${i}`} className="aspect-square"></div>);
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const date = new Date(year, month, d);
            const dateStr = date.toISOString().split('T')[0];
            const isPast = date < new Date(new Date().setHours(0,0,0,0));
            
            let className = "aspect-square flex flex-col items-center justify-center rounded-full text-sm font-medium cursor-pointer transition-all duration-150 relative ";
            
            if (isPast) {
                className += "text-slate-300 cursor-not-allowed line-through decoration-slate-300";
            } else if (checkIn && dateStr === checkIn.toISOString().split('T')[0]) {
                className += "bg-brand text-white font-bold shadow-md shadow-brand/30 z-10";
            } else if (checkOut && dateStr === checkOut.toISOString().split('T')[0]) {
                className += "bg-brand text-white font-bold shadow-md shadow-brand/30 z-10";
            } else if (checkIn && checkOut && date > checkIn && date < checkOut) {
                className += "bg-brand-light text-brand rounded-none z-0";
            } else {
                className += "hover:bg-brand-light hover:text-brand font-semibold";
            }

            days.push(
                <div key={d} className={className} onClick={() => !isPast && handleDateClick(date)}>
                    <span>{d}</span>
                </div>
            );
        }
        return days;
    };
    const displayDateText = checkIn && checkOut 
        ? `${formatDate(checkIn)} - ${formatDate(checkOut)}` 
        : (checkIn ? `${formatDate(checkIn)} - Add dates` : 'Add dates');

    return (
        <section className="bg-slate-50 relative z-40 px-4 sm:px-6 lg:px-8 pt-4 pb-4 search-container">
            <div className="max-w-[1536px] mx-auto flex justify-center">
                
                {!isMobileExpanded && (
                    <button 
                        onClick={() => setIsMobileExpanded(true)}
                        className="md:hidden w-full flex items-center gap-3 bg-white border border-slate-200 rounded-2xl p-3 shadow-sm active:scale-[0.98] transition text-left"
                    >
                        <div className="w-10 h-10 rounded-full bg-brand-light flex items-center justify-center">
                            <i className="fa-solid fa-magnifying-glass text-brand"></i>
                        </div>
                        <div className="flex-1">
                            <div className="text-sm font-bold text-dark">Where to?</div>
                            <div className="text-xs text-slate-500">Anywhere · Any week · Add guests</div>
                        </div>
                        <div className="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center">
                            <i className="fa-solid fa-sliders text-slate-700 text-sm"></i>
                        </div>
                    </button>
                )}

                <div className={`
                    bg-white border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300
                    ${isMobileExpanded ? 'block md:hidden w-full rounded-2xl p-4' : 'hidden'}
                    md:flex md:w-full md:max-w-[840px] md:items-center md:rounded-full
                `}>
                    
                    {isMobileExpanded && (
                        <div className="md:hidden flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                            <h3 className="font-bold text-lg text-dark">Search Stays</h3>
                            <button onClick={() => { setIsMobileExpanded(false); setActiveSection(null); }} className="p-2 rounded-full hover:bg-slate-100 transition">
                                <i className="fa-solid fa-xmark text-slate-600 text-lg"></i>
                            </button>
                        </div>
                    )}
                    <div className="relative flex-1 px-4 md:px-6 py-3 md:py-3 text-left border-b md:border-b-0 md:border-r border-slate-200" onClick={(e) => toggleSection(e, 'where')}>
                        <label className="block text-xs font-bold text-dark mb-1">Where</label>
                        <input type="text" placeholder="Search destinations" value={whereValue} onChange={(e) => setWhereValue(e.target.value)} className="w-full text-sm text-slate-600 outline-none bg-transparent truncate placeholder-slate-400" />
                        
                        <div className={`dropdown-menu absolute top-full left-0 right-0 md:right-auto mt-2 w-full md:w-[680px] max-w-[90vw] bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50 ${activeSection === 'where' ? 'active' : ''}`}>
                            <div className="p-4 md:p-5">
                                <h3 className="text-sm font-bold text-dark mb-3 md:mb-4">Popular destinations in Nepal</h3>
                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    

                                    {popularDestinations.map(({ city, desc, icon, color }) => (
                                        <button
                                            key={city}
                                            onClick={(e) => {
                                                e.stopPropagation();
                                                setWhereValue(city);
                                                setActiveSection(null);
                                            }}
                                            className="flex items-center gap-3 md:gap-4 p-3 rounded-xl hover:bg-slate-50 transition text-left border border-transparent hover:border-slate-100 w-full"
                                        >
                                            <div className={`w-10 h-10 md:w-12 md:h-12 rounded-xl bg-${color}-50 flex items-center justify-center shrink-0`}>
                                                <i className={`fa-solid ${icon} text-${color}-500 text-lg`}></i>
                                            </div>
                                            <div className="text-left">
                                                <div className="text-sm font-semibold text-dark">{city}</div>
                                                <div className="text-xs text-slate-500">{desc}</div>
                                            </div>
                                        </button>
                                    ))}

                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="relative flex-1 px-4 md:px-6 py-3 md:py-3 text-left border-b md:border-b-0 md:border-r border-slate-200" onClick={(e) => toggleSection(e, 'when')}>
                        <label className="block text-xs font-bold text-dark mb-1">When</label>
                        <input type="text" value={displayDateText} className="w-full text-sm text-slate-600 outline-none bg-transparent truncate placeholder-slate-400" readOnly />
                        
                        <div className={`dropdown-menu absolute top-full left-0 right-0 mt-2 w-full md:w-[680px] max-w-[90vw] bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50 p-4 md:p-6 ${activeSection === 'when' ? 'active' : ''}`} onClick={(e) => e.stopPropagation()}>
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

                            {(checkIn || checkOut) && (
                                <div className="mt-4 pt-4 border-t border-slate-100 text-center">
                                    <button onClick={() => { setCheckIn(null); setCheckOut(null); }} className="text-sm font-bold underline text-slate-500 hover:text-dark transition">
                                        Clear dates
                                    </button>
                                </div>
                            )}
                        </div>
                    </div>
              
                    <div className="relative flex-1 px-4 md:px-6 py-3 md:py-3 text-left flex items-center justify-between gap-4" onClick={(e) => toggleSection(e, 'guests')}>
                        <div className="flex-1">
                            <label className="block text-xs font-bold text-dark mb-1">Who</label>
                            <input type="text" value={getGuestLabel()} className="w-full text-sm text-slate-600 outline-none bg-transparent truncate placeholder-slate-400" readOnly />
                        </div>
                        
                        <div className={`dropdown-menu absolute top-full right-0 mt-2 w-full md:w-[380px] max-w-full bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50 p-4 md:p-5 ${activeSection === 'guests' ? 'active' : ''}`} onClick={(e) => e.stopPropagation()}>
                            <div className="space-y-4">
                                <div className="flex items-center justify-between py-2 border-b border-slate-100">
                                    <div>
                                        <div className="text-sm font-medium text-dark">Adults</div>
                                        <div className="text-xs text-slate-500">Ages 13 or above</div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        <button className="counter-btn" onClick={(e) => { e.stopPropagation(); updateGuests('adults', -1); }}><i className="fa-solid fa-minus text-xs"></i></button>
                                        <span className="w-6 text-center font-medium text-dark">{guests.adults}</span>
                                        <button className="counter-btn" onClick={(e) => { e.stopPropagation(); updateGuests('adults', 1); }}><i className="fa-solid fa-plus text-xs"></i></button>
                                    </div>
                                </div>
                                <div className="flex items-center justify-between py-2">
                                    <div>
                                        <div className="text-sm font-medium text-dark">Children</div>
                                        <div className="text-xs text-slate-500">Ages 2-12</div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        <button className="counter-btn" onClick={(e) => { e.stopPropagation(); updateGuests('children', -1); }}><i className="fa-solid fa-minus text-xs"></i></button>
                                        <span className="w-6 text-center font-medium text-dark">{guests.children}</span>
                                        <button className="counter-btn" onClick={(e) => { e.stopPropagation(); updateGuests('children', 1); }}><i className="fa-solid fa-plus text-xs"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button className="bg-brand hover:bg-brand-hover text-white rounded-full p-3 transition-all active:scale-95 flex items-center justify-center shrink-0">
                            <i className="fa-solid fa-magnifying-glass text-base"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    );
}