import React from 'react';
import SwiperCarousel from '../SwiperCarousel';

export default function FeaturedSection({ listing }) {
    if (!listing || listing.length === 0) return null;
    return (
        <section className="bg-white px-4 lg:px-8 mt-6 mb-4">
            <div className="max-w-[1536px] mx-auto">
                <div className="flex items-end justify-between mb-6 px-2">
                    <div>
                        <h2 className="section-title">Featured Properties</h2>
                        <p className="section-subtitle">Top rated stays loved by travelers</p>
                    </div>
                </div>
                <SwiperCarousel listing={listing} variant="square" />
            </div>
        </section>
    );
}