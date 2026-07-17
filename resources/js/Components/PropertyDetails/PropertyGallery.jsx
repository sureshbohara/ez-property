import React from 'react';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/pagination';
export default function PropertyGallery({ listing }) {
    const mainImage = listing.image_url || 'https://images.unsplash.com/photo-1544985335-937222379894?q=80&w=1200';
    
    const galleryImages = listing.gallery && listing.gallery.length > 0 
        ? listing.gallery.map(img => img.startsWith('http') ? img : `/images/${img}`)
        : [
            'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?q=80&w=600',
            'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=600',
            'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=600',
            'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=600'
          ];
    const allImages = [mainImage, ...galleryImages];

    return (
        <>
            <div className="md:hidden mb-4 relative">
                <Swiper
                    modules={[Pagination]}
                    pagination={{ 
                        clickable: true,
                        dynamicBullets: true
                    }}
                    className="mobile-gallery rounded-xl overflow-hidden h-[300px]"
                >
                    {allImages.map((img, index) => (
                        <SwiperSlide key={index}>
                            <div className="relative w-full h-full">
                                <img src={img} className="w-full h-full object-cover" alt={`Gallery ${index + 1}`} />
                                {index === 0 && (
                                    <button className="absolute bottom-4 right-4 bg-white/90 backdrop-blur px-3 py-1.5 rounded-lg text-xs font-semibold text-dark shadow-sm flex items-center gap-1.5 hover:bg-white transition">
                                        <i className="fa-solid fa-grid-2"></i> See all photos
                                    </button>
                                )}
                            </div>
                        </SwiperSlide>
                    ))}
                </Swiper>
            </div>
            <div className="hidden md:grid grid-cols-4 grid-rows-2 gap-1 rounded-2xl overflow-hidden h-[400px] mb-4">
                <div className="col-span-2 row-span-2 relative group cursor-pointer">
                    <img src={mainImage} className="w-full h-full object-cover" alt="Main" />
                </div>
                {galleryImages.slice(0, 4).map((img, index) => (
                    <div key={index} className="relative group cursor-pointer">
                        <img src={img} className="w-full h-full object-cover" alt={`Gallery ${index + 1}`} />
                        {index === 3 && (
                            <button className="absolute bottom-4 right-4 bg-white/90 backdrop-blur px-4 py-2 rounded-lg text-sm font-semibold text-dark shadow-sm flex items-center gap-2 hover:bg-white transition">
                                <i className="fa-solid fa-grid-2 text-xs"></i> Show all photos
                            </button>
                        )}
                    </div>
                ))}
            </div>
        </>
    );
}