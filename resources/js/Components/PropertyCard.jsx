import React, { useState, useEffect } from 'react';
import { Link, router, usePage } from '@inertiajs/react';
import { formatPrice } from '../Utils/helpers';
import toast from 'react-hot-toast';

export default function PropertyCard({ listing, variant = 'default' }) {
    const { props } = usePage();
    const user = props.auth?.user;

    const initialSavedState = listing.is_saved || (listing.saved_by_users && listing.saved_by_users.length > 0) || false;
    
    const [isFavorite, setIsFavorite] = useState(initialSavedState);
    const [isProcessing, setIsProcessing] = useState(false);

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

    const handleToggleFavorite = (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (!user) {
            toast.error('Please log in to save properties');
            router.visit('/login');
            return;
        }

        setIsProcessing(true);
        const newFavoriteState = !isFavorite;
        setIsFavorite(newFavoriteState);
        router.post(`/properties/${listing.id}/save`, {}, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success(newFavoriteState ? 'Added to saved properties!' : 'Removed from saved properties.');
                setIsProcessing(false);
            },
            onError: () => {
                setIsFavorite(!newFavoriteState);
                setIsProcessing(false);
                toast.error('Failed to update saved properties.');
            }
        });
    };

    const aspectClass = variant === 'square' ? 'aspect-square' : 'aspect-[4/3]';
    const displayImage = listing.image_url || 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80';

    const rating = listing.reviews?.length > 0 
        ? (listing.reviews.reduce((sum, r) => sum + r.overall_rating, 0) / listing.reviews.length).toFixed(2)
        : '4.95';
     
    const formattedType = listing.listing_type 
        ? listing.listing_type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) 
        : 'Property';

    const getDisplayPrice = () => {
        const basePrice = parseFloat(listing.base_price) || 0;
        if (currency === 'USD') {
            return `$${(basePrice * 0.0075).toFixed(2)}`;
        } else if (currency === 'INR') {
            return `₹${Math.round(basePrice * 0.625)}`;
        }
        return formatPrice(listing.base_price);
    };

    return (
        <Link href={`/property/${listing.slug}`} className="group cursor-pointer bg-white rounded-2xl overflow-hidden h-full block border border-slate-100">
            <div className={`relative ${aspectClass} bg-slate-100 img-zoom-container`}>
                <img 
                    src={displayImage} 
                    alt={listing.title} 
                    className="object-cover w-full h-full" 
                    loading="lazy"
                />
            
                <div className="absolute top-3 left-3 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-full text-[10px] font-bold shadow-sm text-dark">
                   {formattedType}
                </div>
            
                <button 
                    onClick={handleToggleFavorite}
                    disabled={isProcessing}
                    className="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center hover:bg-white/30 transition-all group/heart disabled:opacity-50"
                >
                    <i className={`fa-${isFavorite ? 'solid' : 'regular'} fa-heart ${isFavorite ? 'text-red-500' : 'text-white'} drop-shadow-md text-sm ${isProcessing ? 'animate-pulse' : ''}`}></i>
                </button>

                {listing.instant_bookable && (
                    <div className="absolute bottom-3 left-3 bg-brand text-white px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider">
                        <i className="fa-solid fa-bolt text-[8px] mr-1"></i> Instant
                    </div>
                )}
            </div>

            <div className="p-3">
                <div className="mb-2">
                    <h3 className="font-semibold text-dark truncate text-sm leading-tight">{listing.title}</h3>
                </div>
                <div className="flex items-center justify-between text-xs mb-3">
                    <span className="bg-slate-100 text-slate-700 px-2 py-0.5 rounded-full text-[10px] font-medium">
                        {listing.city}, {listing.province}
                    </span>
                    <span className="flex items-center gap-1 font-medium text-slate-700">
                        <i className="fa-solid fa-star text-accent text-[10px]"></i> 
                        {rating}
                    </span>
                </div>

                <div className="flex items-baseline justify-between pt-2 border-t border-slate-100">
                    <div className="flex items-baseline gap-1">
                        <span className="font-bold text-dark text-[11px]">{getDisplayPrice()}</span>
                        <span className="text-[11px] text-slate-500">/ night</span>
                    </div>
                    {listing.minimum_nights > 1 && (
                        <span className="text-[10px] text-slate-400">
                            Min {listing.minimum_nights} night{listing.minimum_nights > 1 ? 's' : ''}
                        </span>
                    )}
                </div>
            </div>
        </Link>
    );
}