import React, { useState } from 'react';

export default function PropertyAmenities({ listing }) {
    const amenities = listing?.amenities || [];
    const [showAll, setShowAll] = useState(false);
    const displayedAmenities = showAll ? amenities : amenities.slice(0, 6);
    return (
        <section id="amenities" className="border-t border-slate-200 pt-4">
            <h2 className="text-2xl font-bold text-dark mb-6">
                What this place offers
            </h2>
            <div className="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-3">
                {displayedAmenities.map((amenity, index) => (
                    <div key={index} className="flex items-center gap-4 p-4 rounded-xl border border-slate-100 bg-white hover:bg-brand-lightest hover:border-brand/30 transition-all duration-300 group"
                    >
                        <i className={`fa-solid ${amenity.icon || 'fa-check'} text-xl text-slate-400 group-hover:text-brand transition-colors`}
                        ></i>
                            <span className="text-sm font-medium text-slate-700 group-hover:text-dark">{amenity.name}</span>
                        </div>
                    ))}
            </div>
            {amenities.length > 6 && (
                <button
                    onClick={() => setShowAll(!showAll)}
                    className="w-full sm:w-auto px-6 py-3 border border-slate-800 rounded-xl font-semibold text-dark hover:bg-slate-50 transition flex items-center justify-center gap-2"
                >
                    {showAll
                    ? 'Show Less'
                    : `Show all ${amenities.length} amenities`}
                    <i
                        className={`fa-solid ${
                            showAll ? 'fa-chevron-up' : 'fa-chevron-right'
                        } text-xs`}
                    ></i>
                    </button>
                    )}
        </section>
        );
}