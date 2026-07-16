import React from 'react';
import PropertyCard from '../PropertyCard';

export default function RecommendedSection({ listing }) {
    if (!listing || listing.length === 0) return null;
    return (
        <section className="bg-white px-4 sm:px-6 lg:px-8 py-6 md:py-12 lg:py-16">
            <div className="max-w-[1536px] mx-auto">
                <div className="flex items-end justify-between mb-6">
                    <div>
                        <h2 className="section-title">Recommended for you</h2>
                        <p className="section-subtitle">Handpicked stays for your next adventure</p>
                    </div>
                </div>
                <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 gap-4">
                    {listing.map((item) => <PropertyCard key={item.id} listing={item} />)}
                </div>
            </div>
        </section>
    );
}