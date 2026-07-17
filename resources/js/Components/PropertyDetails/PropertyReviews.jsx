import React from 'react';

export default function PropertyReviews({ totalReviews, avgOverall, avgCleanliness, avgAccuracy, avgCheckIn, avgLocation, avgValue, reviews }) {
    const ratings = [
        { label: 'Cleanliness', value: avgCleanliness },
        { label: 'Accuracy', value: avgAccuracy },
        { label: 'Check-in', value: avgCheckIn },
        { label: 'Location', value: avgLocation },
        { label: 'Value', value: avgValue },
    ];

    const formatDate = (dateString) => {
        if (!dateString) return 'Recently';
        return new Date(dateString).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
    };

    return (
        <section id="reviews" className="border-t border-slate-200 pt-10 scroll-mt-36">
            <div className="flex items-center gap-3 mb-8">
                <i className="fa-solid fa-star text-accent text-2xl"></i>
                <h2 className="text-2xl font-bold text-dark">{avgOverall} · {totalReviews} reviews</h2>
            </div>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-5 mb-10">
                {ratings.map((rating, index) => (
                    <React.Fragment key={index}>
                        <div className="flex items-center justify-between text-sm"><span className="font-medium text-slate-700">{rating.label}</span><span className="font-bold text-dark">{rating.value || '5.0'}</span></div>
                        <div className="w-full bg-slate-100 rounded-full h-2"><div className="bg-dark h-2 rounded-full transition-all duration-1000" style={{ width: `${(rating.value || 5) * 20}%` }}></div></div>
                    </React.Fragment>
                ))}
            </div>

            {reviews && reviews.length > 0 ? (
                <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    {reviews.map((review) => (
                        <div key={review.id} className="space-y-4">
                            <div className="flex items-center gap-3">
                                <img src={review.user?.image_url || "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100"} className="w-12 h-12 rounded-full object-cover border border-slate-100" alt="Guest" />
                                <div>
                                    <div className="font-bold text-dark flex items-center gap-2">
                                        {review.guest_name || review.user?.name || 'Guest'}
                                        {review.user && <i className="fa-solid fa-circle-check text-brand text-xs" title="Verified Guest"></i>}
                                    </div>
                                    <div className="text-xs text-slate-500">Stayed in {formatDate(review.stay_date)}</div>
                                </div>
                            </div>
                            <div className="flex text-accent text-xs mb-2">
                                {[...Array(5)].map((_, i) => (
                                    <i key={i} className={`fa-${i < Math.round(review.overall_rating) ? 'solid' : 'regular'} fa-star`}></i>
                                ))}
                            </div>
                            <p className="text-sm text-slate-700 leading-relaxed">{review.comment}</p>
                        </div>
                    ))}
                </div>
            ) : (
                <div className="text-center py-10 bg-slate-50 rounded-2xl mb-8 border border-slate-100">
                    <p className="text-slate-500">No reviews yet. Be the first to review!</p>
                </div>
            )}

            {totalReviews > 6 && (
                <button className="w-full px-6 py-3.5 border border-slate-800 rounded-xl font-semibold text-dark hover:bg-slate-50 transition flex items-center justify-center gap-2 group">
                    Show all {totalReviews} reviews <i className="fa-solid fa-chevron-down text-xs group-hover:translate-y-0.5 transition-transform"></i>
                </button>
            )}
        </section>
    );
}