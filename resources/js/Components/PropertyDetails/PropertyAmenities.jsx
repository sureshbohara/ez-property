import React from 'react';

export default function PropertyAmenities({ listing }) {
    const amenities = listing.amenities && listing.amenities.length > 0 
        ? listing.amenities 
        : [{ name: 'Fast Wi-Fi', icon: 'fa-wifi' }, { name: 'Air conditioning', icon: 'fa-snowflake' }];
    return (
        <section id="amenities" className="border-t border-slate-200 pt-10 scroll-mt-36">
            <h2 className="text-2xl font-bold text-dark mb-6">What this place offers</h2>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                {amenities.slice(0, 6).map((amenity, index) => (
                    <div key={index} className="flex items-center gap-4 p-4 rounded-xl border border-slate-100 bg-white hover:bg-brand-lightest hover:border-brand/30 transition-all duration-300 group cursor-default">
                        <i className={`fa-solid ${amenity.icon || 'fa-check'} text-xl text-slate-400 group-hover:text-brand transition-colors`}></i>
                        <span className="text-sm font-medium text-slate-700 group-hover:text-dark">{amenity.name}</span>
                    </div>
                ))}
            </div>
            <button className="w-full sm:w-auto px-6 py-3 border border-slate-800 rounded-xl font-semibold text-dark hover:bg-slate-50 transition flex items-center justify-center gap-2">
                Show all {amenities.length} amenities <i className="fa-solid fa-chevron-right text-xs"></i>
            </button>
        </section>
    );
}