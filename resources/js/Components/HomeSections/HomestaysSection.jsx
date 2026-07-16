import React from 'react';
import SwiperCarousel from '../SwiperCarousel';

export default function HomestaysSection({ listing }) {
    if (!listing || listing.length === 0) return null;

    return (
        <section className="bg-slate-50 px-4 sm:px-6 lg:px-8 py-6 md:py-12 lg:py-16">
            <div className="max-w-[1536px] mx-auto">
                <div className="flex items-end justify-between mb-6 px-2">
                    <div>
                        <h2 className="section-title">Homestays - Feel like Home</h2>
                        <p className="section-subtitle">Authentic local experiences</p>
                    </div>
                </div>
                <SwiperCarousel listing={listing} variant="square" />
            </div>
        </section>
    );
}