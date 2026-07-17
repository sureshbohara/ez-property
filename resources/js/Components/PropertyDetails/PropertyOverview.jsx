import React, { useState } from 'react';

export default function PropertyOverview({ listing }) {
    const [showMore, setShowMore] = useState(false);

    return (
        <section id="overview" className="scroll-mt-36">
            <div className="flex flex-col sm:flex-row justify-between items-start gap-4 mb-6">
                <div>
                    <h2 className="text-xl font-bold text-dark">
                        {listing.listing_type ? listing.listing_type.replace('_', ' ') : 'Entire place'} hosted by {listing.user?.name || 'Host'}
                    </h2>
                    <div className="flex flex-wrap gap-3 mt-4">
                        <div className="flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-lg border border-slate-100">
                            <i className="fa-solid fa-user-group text-brand"></i> <span className="text-sm font-medium text-dark">{listing.guests} guests</span>
                        </div>
                        <div className="flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-lg border border-slate-100">
                            <i className="fa-solid fa-bed text-brand"></i> <span className="text-sm font-medium text-dark">{listing.bedrooms} bedroom{listing.bedrooms > 1 ? 's' : ''}</span>
                        </div>
                        <div className="flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-lg border border-slate-100">
                            <i className="fa-solid fa-bed text-brand"></i> <span className="text-sm font-medium text-dark">{listing.beds} bed{listing.beds > 1 ? 's' : ''}</span>
                        </div>
                        <div className="flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-lg border border-slate-100">
                            <i className="fa-solid fa-bath text-brand"></i> <span className="text-sm font-medium text-dark">{listing.bathrooms} bath{listing.bathrooms > 1 ? 's' : ''}</span>
                        </div>
                    </div>
                </div>
                <img src={listing.user?.image_url || "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100"} className="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md" alt="Host" />
            </div>

            <div className="space-y-5 mb-8">
                {listing.instant_bookable && (
                    <div className="flex gap-4 items-start">
                        <div className="w-10 h-10 flex items-center justify-center shrink-0 bg-brand-lightest rounded-full"><i className="fa-solid fa-key text-brand text-lg"></i></div>
                        <div><h3 className="font-semibold text-dark">Self check-in</h3><p className="text-sm text-slate-600 mt-0.5">Check yourself in with the keypad lockbox.</p></div>
                    </div>
                )}
                <div className="flex gap-4 items-start">
                    <div className="w-10 h-10 flex items-center justify-center shrink-0 bg-brand-lightest rounded-full"><i className="fa-solid fa-location-dot text-brand text-lg"></i></div>
                    <div><h3 className="font-semibold text-dark">Great location</h3><p className="text-sm text-slate-600 mt-0.5">95% of recent guests gave the location a 5-star rating.</p></div>
                </div>
            </div>

            <div className="border-t border-slate-200 pt-6">
                <p className="text-slate-700 leading-relaxed mb-4 whitespace-pre-line">{listing.description}</p>
    
                {listing.description && listing.description.length > 300 && (
                    <button onClick={() => setShowMore(!showMore)} className="flex items-center gap-2 font-semibold text-dark underline hover:text-brand transition mt-2">
                        <span>{showMore ? 'Show less' : 'Show more'}</span> 
                        <i className={`fa-solid fa-chevron-down text-xs transition-transform ${showMore ? 'rotate-180' : ''}`}></i>
                    </button>
                )}
                
            </div>
        </section>
    );
}