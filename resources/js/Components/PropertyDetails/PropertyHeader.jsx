import React from 'react';

export default function PropertyHeader({ listing, totalReviews, avgOverall }) {
    return (
        <div className="mb-6">
            <h1 className="text-md md:text-xl font-bold text-dark mb-2">{listing.title}</h1>

            <div className="flex flex-wrap items-center gap-2 text-sm text-slate-700">
                
                <span className="flex items-center gap-1 font-semibold text-dark">
                    <i className="fa-solid fa-star text-accent text-xs"></i> {avgOverall || 'New'}
                </span>

                <span className="text-slate-300">·</span>

                <a href="#reviews" className="underline font-medium hover:text-brand transition">{totalReviews} reviews</a>
                <span className="text-slate-300">·</span>

                <span className="font-medium underline decoration-slate-300 underline-offset-4">{listing.city}, {listing.province}</span>

            </div>

        </div>
    );
}