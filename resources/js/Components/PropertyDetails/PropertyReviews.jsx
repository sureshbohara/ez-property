import React, { useState } from 'react';
import { useForm, usePage } from '@inertiajs/react';
import { FiStar, FiCheckCircle, FiMessageSquare, FiX, FiLoader } from 'react-icons/fi';

const StarInput = ({ value, onChange }) => {
    const [hover, setHover] = useState(0);
    return (
        <div className="flex gap-1">
            {[1, 2, 3, 4, 5].map((star) => (
                <button
                    type="button"
                    key={star}
                    onClick={() => onChange(star)}
                    onMouseEnter={() => setHover(star)}
                    onMouseLeave={() => setHover(0)}
                    className="text-2xl transition-colors"
                >
                    <FiStar 
                        className={(hover || value) >= star ? 'text-amber-400 fill-amber-400' : 'text-slate-300'} 
                    />
                </button>
            ))}
        </div>
    );
};

const DisplayStars = ({ rating }) => (
    <div className="flex text-amber-400 text-sm gap-0.5">
        {[1, 2, 3, 4, 5].map((star) => (
            <FiStar key={star} className={Math.round(rating) >= star ? 'fill-amber-400 text-amber-400' : 'text-slate-300'} />
        ))}
    </div>
);

export default function PropertyReviews({ totalReviews, avgOverall, avgCleanliness, avgAccuracy, avgCheckIn, avgLocation, avgValue, reviews }) {
    // Get auth user AND listing directly from Inertia page props
    const { auth, listing } = usePage().props;
    const listingId = listing.id; // <--- THIS FIXES THE UNDEFINED ERROR
    
    const [showForm, setShowForm] = useState(false);
    const [expandedReviews, setExpandedReviews] = useState({});

    const { data, setData, post, processing, errors, reset } = useForm({
        overall_rating: 0,
        cleanliness: 0,
        accuracy: 0,
        check_in: 0,
        location: 0,
        value: 0,
        comment: '',
    });

    const ratings = [
        { key: 'cleanliness', label: 'Cleanliness', value: avgCleanliness },
        { key: 'accuracy', label: 'Accuracy', value: avgAccuracy },
        { key: 'check_in', label: 'Check-in', value: avgCheckIn },
        { key: 'location', label: 'Location', value: avgLocation },
        { key: 'value', label: 'Value', value: avgValue },
    ];

    const formatDate = (dateString) => {
        if (!dateString) return 'Recently';
        return new Date(dateString).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
    };

    const submitReview = (e) => {
        e.preventDefault();
        post(`/property/${listingId}/reviews`, {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                setShowForm(false);
            }
        });
    };

    const toggleExpand = (id) => {
        setExpandedReviews(prev => ({ ...prev, [id]: !prev[id] }));
    };

    return (
        <section id="reviews" className="border-t border-slate-200 pt-5 scroll-mt-36">
            <div className="flex items-center justify-between mb-8">
                <div className="flex items-center gap-3">
                    <FiStar className="text-amber-400 fill-amber-400 text-2xl" />
                    <h2 className="text-2xl font-bold text-slate-900">
                        {avgOverall || 'New'} · {totalReviews} {totalReviews === 1 ? 'review' : 'reviews'}
                    </h2>
                </div>
                
                {auth.user && !showForm && (
                    <button 
                        onClick={() => setShowForm(true)}
                        className="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold hover:bg-slate-800 transition-colors text-sm flex items-center gap-2"
                    >
                        <FiMessageSquare /> Write a Review
                    </button>
                )}
            </div>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-5 mb-6 pb-6 border-b border-slate-100">
                {ratings.map((rating, index) => (
                    <React.Fragment key={index}>
                        <div className="flex items-center justify-between text-sm">
                            <span className="font-medium text-slate-700">{rating.label}</span>
                            <span className="font-bold text-slate-900">{rating.value ? rating.value.toFixed(1) : '5.0'}</span>
                        </div>
                        <div className="w-full bg-slate-100 rounded-full h-2">
                            <div 
                                className="bg-slate-900 h-2 rounded-full transition-all duration-1000" 
                                style={{ width: `${(rating.value || 5) * 20}%` }}
                            ></div>
                        </div>
                    </React.Fragment>
                ))}
            </div>

            {showForm && (
                <div className="bg-slate-50 border border-slate-200 rounded-2xl p-3 mb-6 relative">
                    <button 
                        onClick={() => setShowForm(false)}
                        className="absolute top-4 right-4 text-slate-400 hover:text-slate-900 transition-colors"
                    >
                        <FiX className="w-5 h-5" />
                    </button>
                    <h3 className="text-xl font-bold text-slate-900 mb-6">Share your experience</h3>
                    
                    <form onSubmit={submitReview} className="space-y-6">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div className="flex flex-col gap-2">
                                <label className="text-sm font-semibold text-slate-700 flex items-center justify-between">
                                    Overall Rating <span className="text-red-500">*</span>
                                </label>
                                <StarInput value={data.overall_rating} onChange={(v) => setData('overall_rating', v)} />
                                {errors.overall_rating && <p className="text-xs text-red-500">{errors.overall_rating}</p>}
                            </div>
                            
                            {ratings.map((rating) => (
                                <div key={rating.key} className="flex flex-col gap-2">
                                    <label className="text-sm font-semibold text-slate-700 flex items-center justify-between">
                                        {rating.label} <span className="text-red-500">*</span>
                                    </label>
                                    <StarInput value={data[rating.key]} onChange={(v) => setData(rating.key, v)} />
                                    {errors[rating.key] && <p className="text-xs text-red-500">{errors[rating.key]}</p>}
                                </div>
                            ))}
                        </div>

                        <div className="flex flex-col gap-2">
                            <label className="text-sm font-semibold text-slate-700 flex items-center justify-between">
                                Your Review <span className="text-red-500">*</span>
                            </label>
                            <textarea 
                                rows="4"
                                value={data.comment}
                                onChange={(e) => setData('comment', e.target.value)}
                                placeholder="Tell others what you liked or didn't like about this property..."
                                className="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 transition-all bg-white resize-none"
                            ></textarea>
                            {errors.comment && <p className="text-xs text-red-500">{errors.comment}</p>}
                        </div>

                        <div className="flex justify-end gap-3">
                            <button 
                                type="button" 
                                onClick={() => setShowForm(false)}
                                className="px-5 py-2.5 rounded-xl font-semibold text-slate-700 hover:bg-slate-200 transition-colors text-sm"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                disabled={processing}
                                className="px-6 py-2.5 bg-slate-900 text-white rounded-xl font-semibold hover:bg-slate-800 transition-colors text-sm flex items-center gap-2 disabled:opacity-50"
                            >
                                {processing ? <><FiLoader className="animate-spin" /> Submitting...</> : 'Submit Review'}
                            </button>
                        </div>
                    </form>
                </div>
            )}

            {reviews && reviews.length > 0 ? (
                <div className="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-8 mb-5">
                    {reviews.map((review) => {
                        const isExpanded = expandedReviews[review.id];
                        const isLong = review.comment && review.comment.length > 220; 

                        return (
                            <div key={review.id} className="bg-white border border-slate-200 rounded-2xl p-3 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col">
                                <div className="flex items-start justify-between mb-4">
                                    <div className="flex items-center gap-3">
                                        <img 
                                            src={review.user?.image_url || "https://ui-avatars.com/api/?name=" + encodeURIComponent(review.user?.name || 'Guest') + "&background=0d9488&color=fff"} 
                                            className="w-12 h-12 rounded-full object-cover border border-slate-200 bg-slate-100" 
                                            alt={review.user?.name || 'Guest'} 
                                        />
                                        <div>
                                            <div className="font-bold text-slate-900 flex items-center gap-1.5">
                                                {review.guest_name || review.user?.name || 'Guest'}
                                                {review.user && <FiCheckCircle className="text-slate-900 text-sm" title="Verified User" />}
                                            </div>
                                            <div className="text-xs text-slate-500">Stayed in {formatDate(review.stay_date)}</div>
                                        </div>
                                    </div>
                                 
                                    <div className="flex items-center gap-1.5 bg-amber-50 border border-amber-100 px-3 py-1.5 rounded-full">
                                        <FiStar className="fill-amber-400 text-amber-400 text-sm" />
                                        <span className="font-bold text-amber-700 text-sm">
                                            {parseFloat(review.overall_rating).toFixed(1)}
                                        </span>
                                    </div>
                                </div>

                                <div className="mb-3">
                                    <DisplayStars rating={review.overall_rating} />
                                </div>

                                <div className="text-sm text-slate-700 leading-relaxed flex-1">
                                    <p className={isExpanded ? '' : 'line-clamp-4'}>
                                        "{review.comment}"
                                    </p>
                                    
                                    {isLong && (
                                        <button 
                                            onClick={() => toggleExpand(review.id)}
                                            className="text-slate-900 font-semibold underline underline-offset-2 mt-2 text-xs hover:text-slate-700 transition-colors"
                                        >
                                            {isExpanded ? 'Show less' : 'Read more'}
                                        </button>
                                    )}
                                </div>
                            </div>
                        );
                    })}
                </div>
            ) : (
                <div className="text-center py-6 bg-slate-50 rounded-2xl mb-4 border border-slate-100">
                    <FiMessageSquare className="mx-auto text-4xl text-slate-300 mb-3" />
                    <h3 className="text-lg font-semibold text-slate-700 mb-1">No reviews yet</h3>
                    <p className="text-slate-500 text-sm">Be the first to share your experience!</p>
                </div>
            )}

            {totalReviews > 6 && (
                <button className="w-full px-6 py-3.5 border border-slate-900 rounded-xl font-semibold text-slate-900 hover:bg-slate-50 transition flex items-center justify-center gap-2 group">
                    Show all {totalReviews} reviews <i className="fa-solid fa-chevron-down text-xs group-hover:translate-y-0.5 transition-transform"></i>
                </button>
            )}
        </section>
    );
}