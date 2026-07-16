import React, { useRef, useState, useEffect } from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import PropertyCard from './PropertyCard';
export default function SwiperCarousel({ listing, variant = 'square', slidesPerView = 2 }) {
    const prevRef = useRef(null);
    const nextRef = useRef(null);
    const [swiperInstance, setSwiperInstance] = useState(null);

    useEffect(() => {
        if (swiperInstance && prevRef.current && nextRef.current) {
            swiperInstance.params.navigation.prevEl = prevRef.current;
            swiperInstance.params.navigation.nextEl = nextRef.current;
            swiperInstance.navigation.init();
            swiperInstance.navigation.update();
        }
    }, [swiperInstance]);

    if (!listing || listing.length === 0) return null;
    return (
        <div className="relative carousel-container px-2 group">
            <Swiper
                modules={[Navigation]}
                spaceBetween={16}
                slidesPerView={slidesPerView}
                loop={listing.length > 4}
                watchOverflow={true}
                breakpoints={{ 
                    640: { slidesPerView: 3 }, 
                    768: { slidesPerView: 4 }, 
                    1024: { slidesPerView: 5 }, 
                    1280: { slidesPerView: 5 } 
                }}
                onSwiper={setSwiperInstance}
                className="pb-8"
            >
                {listing.map((item) => (
                    <SwiperSlide key={item.id}>
                        <PropertyCard listing={item} variant={variant} />
                    </SwiperSlide>
                ))}
            </Swiper>

            <button 
                ref={prevRef} 
                className="absolute left-2 md:left-0 top-1/2 -translate-y-1/2 z-30 bg-white w-9 h-9 rounded-full shadow-md flex items-center justify-center text-slate-800 hover:bg-brand hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100 group-hover:-translate-x-1 hidden md:flex"
            >
                <i className="fa-solid fa-chevron-left text-sm"></i>
            </button>

            <button 
                ref={nextRef} 
                className="absolute right-2 md:right-0 top-1/2 -translate-y-1/2 z-30 bg-white w-9 h-9 rounded-full shadow-md flex items-center justify-center text-slate-800 hover:bg-brand hover:text-white transition-all duration-300 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 hidden md:flex"
            >
                <i className="fa-solid fa-chevron-right text-sm"></i>
            </button>
        </div>
    );
}