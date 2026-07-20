import React, { useState, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Header() {
    const [activeDropdown, setActiveDropdown] = useState(null);
    const { url, props } = usePage(); 
    
    const user = props.auth?.user || null;

    const [currency, setCurrency] = useState(() => {
        if (typeof window !== 'undefined') {
            return localStorage.getItem('selectedCurrency') || 'NPR';
        }
        return 'NPR';
    });

    const handleCurrencyChange = (newCurrency) => {
        setCurrency(newCurrency);
        localStorage.setItem('selectedCurrency', newCurrency);
        setActiveDropdown(null);
        window.dispatchEvent(new Event('currencyChanged'));
    };

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (!event.target.closest('.dropdown-menu') && !event.target.closest('[data-dropdown-toggle]')) {
                setActiveDropdown(null);
            }
        };
        document.addEventListener('click', handleClickOutside);
        return () => document.removeEventListener('click', handleClickOutside);
    }, []);

    const toggleDropdown = (e, dropdownId) => {
        e.stopPropagation();
        setActiveDropdown(activeDropdown === dropdownId ? null : dropdownId);
    };
    
    const isActive = (path) => {
        if (path === '/') return url === '/';
        return url.startsWith(path);
    };
    
    const activeClass = 'bg-white shadow-sm text-brand font-semibold';
    const inactiveClass = 'text-slate-600 hover:text-dark hover:bg-white hover:shadow-sm font-medium';

    return (
        <nav className="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 px-4 sm:px-6 lg:px-8 py-3">
            <div className="max-w-[1536px] mx-auto flex items-center justify-between gap-4">
                <div className="flex items-center gap-4 md:gap-8">
                    <Link href="/" className="flex items-center gap-2.5 group select-none">
                        <div className="w-10 h-10 bg-brand rounded-xl flex items-center justify-center shadow-md shadow-brand/20 group-hover:shadow-brand/30 transition-all">
                            <i className="fa-solid fa-house-chimney-window text-white text-lg"></i>
                        </div>
                        <div className="flex flex-col leading-none hidden md:block">
                            <span className="text-[1.25rem] font-extrabold tracking-tight text-dark">Ez<span className="text-brand">Property</span></span>
                        </div>
                    </Link>

                    <div className="relative hidden md:block" data-dropdown-toggle>
                        <button 
                            onClick={(e) => toggleDropdown(e, 'currency')}
                            className="flex items-center gap-2 px-3 py-1.5 rounded-full hover:bg-slate-50 transition text-sm font-medium border border-transparent hover:border-slate-200"
                        >
                            {currency} <i className="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                        </button>
                        <div className={`dropdown-menu absolute top-full left-0 mt-2 w-40 bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden z-50 ${activeDropdown === 'currency' ? 'active' : ''}`}>
                            <div className="py-1">
                                <a onClick={() => handleCurrencyChange('NPR')} className={`block px-4 py-2 text-sm flex justify-between items-center cursor-pointer ${currency === 'NPR' ? 'bg-brand-light/50 text-brand' : 'text-slate-700 hover:bg-slate-50'}`}>
                                    <span>NPR (Rs)</span> {currency === 'NPR' && <i className="fa-solid fa-check text-brand text-xs"></i>}
                                </a>
                                <a onClick={() => handleCurrencyChange('INR')} className={`block px-4 py-2 text-sm flex justify-between items-center cursor-pointer ${currency === 'INR' ? 'bg-brand-light/50 text-brand' : 'text-slate-700 hover:bg-slate-50'}`}>
                                    <span>INR (₹)</span> {currency === 'INR' && <i className="fa-solid fa-check text-brand text-xs"></i>}
                                </a>
                                <a onClick={() => handleCurrencyChange('USD')} className={`block px-4 py-2 text-sm flex justify-between items-center cursor-pointer ${currency === 'USD' ? 'bg-brand-light/50 text-brand' : 'text-slate-700 hover:bg-slate-50'}`}>
                                    <span>USD ($)</span> {currency === 'USD' && <i className="fa-solid fa-check text-brand text-xs"></i>}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="hidden lg:flex items-center gap-1 bg-slate-50 p-1 rounded-full border border-slate-100">
                    <Link href="/" className={`flex items-center gap-2 px-5 py-2 rounded-full transition text-sm ${isActive('/') ? activeClass : inactiveClass}`}>
                        <i className="fa-solid fa-bed"></i> Homes
                    </Link>
                    <Link href="/experience" className={`flex items-center gap-2 px-5 py-2 rounded-full transition text-sm ${isActive('/experience') ? activeClass : inactiveClass}`}>
                        <i className="fa-regular fa-face-smile"></i> Experience
                    </Link>
                    <Link href="/services" className={`flex items-center gap-2 px-5 py-2 rounded-full transition text-sm ${isActive('/services') ? activeClass : inactiveClass}`}>
                        <i className="fa-solid fa-map"></i> Services
                    </Link>
                </div>

                <div className="flex items-center gap-2 md:gap-3">
                    <Link 
                        href={user ? "/properties/create" : "/login"} 
                        className="hidden md:flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-full text-sm font-semibold hover:shadow-md transition"
                    >
                        <i className="fa-solid fa-plus text-brand"></i> <span>List property</span>
                    </Link>

             
                    <div className="relative" data-dropdown-toggle>
                        <button 
                            onClick={() => setActiveDropdown(activeDropdown === 'profile' ? null : 'profile')} 
                            className="p-1 pl-3 pr-2 rounded-full hover:bg-slate-100 transition border border-slate-200 flex items-center gap-2 shadow-sm hover:shadow-md"
                        >
                            <i className="fa-solid fa-bars text-slate-600 text-sm"></i>
                            
                
                            {user ? (
                                <img 
                                    src={user.image_url || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&q=80'} 
                                    alt={user.name} 
                                    className="w-8 h-8 rounded-full object-cover border border-slate-200"
                                />
                            ) : (
                                <div className="bg-slate-200 rounded-full p-1.5 text-slate-500 w-8 h-8 flex items-center justify-center">
                                    <i className="fa-solid fa-user text-xs"></i>
                                </div>
                            )}
                        </button>

                        <div className={`dropdown-menu absolute top-full right-0 mt-3 w-64 bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden z-50 py-2 ${activeDropdown === 'profile' ? 'active' : ''}`}>
                            
                            {user ? (
                                <>
                                    <div className="px-4 py-3 border-b border-slate-100 mb-1">
                                        <p className="text-sm font-bold text-dark truncate">{user.name}</p>
                                        <p className="text-xs text-slate-500 truncate">{user.email}</p>
                                    </div>
                                    
                                    <Link href="/dashboard" className="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-medium flex items-center gap-2">
                                        <i className="fa-solid fa-gauge-high text-slate-400 w-4"></i> Dashboard
                                    </Link>

                                    <Link href="/my-listings" className="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-medium flex items-center gap-2">
                                        <i className="fa-solid fa-house-chimney text-slate-400 w-4"></i> My Listings
                                    </Link>
                                    
                                    <hr className="my-2 border-slate-100" />
                                    

                                    <Link 
                                        method="post" 
                                        href="/logout" 
                                        as="button"
                                        className="block w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 font-medium flex items-center gap-2"
                                    >
                                        <i className="fa-solid fa-arrow-right-from-bracket w-4"></i> Log out
                                    </Link>
                                </>
                            ) : (

                                <>
                                    <Link href="/login" className="block px-4 py-2.5 text-sm font-bold text-dark hover:bg-slate-50 flex items-center gap-2">
                                        <i className="fa-solid fa-right-to-bracket text-slate-400 w-4"></i> Log in
                                    </Link>
                                    <Link href="/register" className="block px-4 py-2.5 text-sm font-bold text-dark hover:bg-slate-50 flex items-center gap-2">
                                        <i className="fa-solid fa-user-plus text-slate-400 w-4"></i> Sign up
                                    </Link>
                                    <hr className="my-2 border-slate-100" />
                                    <Link href="/register" className="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-medium flex items-center gap-2">
                                        <i className="fa-solid fa-plus-circle text-slate-400 w-4"></i> Become a host
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    );
}