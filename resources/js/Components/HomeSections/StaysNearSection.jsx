import React from 'react';
import SwiperCarousel from '../SwiperCarousel';

export default function StaysNearSection({ listing }) {
    if (!listing || listing.length === 0) return null;
    return (
        <section className="bg-white px-4 lg:px-8 sm:px-6 mt-8 mb-8">
            <div className="max-w-[1536px] mx-auto">
                <div className="flex items-end justify-between mb-6 px-2">
                    <div>
                        <h2 className="section-title">Stays Near You</h2>
                        <p className="section-subtitle">Professional hospitality with local charm</p>
                    </div>
                </div>
                
                <SwiperCarousel listing={listing} variant="square" />
            </div>
        </section>
    );
}