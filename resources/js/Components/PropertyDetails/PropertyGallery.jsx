import React from 'react';

export default function PropertyGallery({ listing }) {
    // Backend  getImageUrlAttribute main image
    const mainImage = listing.image_url || 'https://images.unsplash.com/photo-1544985335-937222379894?q=80&w=1200';
    
    // Backend gallery array (e.g., ['img1.jpg', 'img2.jpg'])
    const galleryImages = listing.gallery && listing.gallery.length > 0 
        ? listing.gallery.slice(0, 4).map(img => img.startsWith('http') ? img : `/images/${img}`)
        : [
            'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?q=80&w=600',
            'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=600',
            'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=600',
            'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=600'
          ];

    return (
        <div className="hidden md:grid grid-cols-4 grid-rows-2 gap-2 rounded-2xl overflow-hidden h-[400px] mb-8">
            <div className="col-span-2 row-span-2 relative group cursor-pointer">
                <img src={mainImage} className="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="Main" />
            </div>
            {galleryImages.map((img, index) => (
                <div key={index} className="relative group cursor-pointer">
                    <img src={img} className="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt={`Gallery ${index + 1}`} />
                    {index === 3 && (
                        <button className="absolute bottom-4 right-4 bg-white/90 backdrop-blur px-4 py-2 rounded-lg text-sm font-semibold text-dark shadow-sm flex items-center gap-2 hover:bg-white transition">
                            <i className="fa-solid fa-grid-2 text-xs"></i> Show all photos
                        </button>
                    )}
                </div>
            ))}
        </div>
    );
}