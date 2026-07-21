import React from 'react';
import { Link } from '@inertiajs/react';
import { 
    FiStar, FiDroplet, FiTarget, FiMapPin, 
    FiCheckCircle, FiDollarSign, FiMessageSquare 
} from 'react-icons/fi';


const RatingRow = ({ icon, label, score }) => {
    if (score === null || score === undefined) return null;
    
    return (
        <div className="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
            <div className="flex items-center gap-2 text-sm text-slate-600">
                {icon}
                <span>{label}</span>
            </div>
            <div className="flex items-center gap-2 w-24">
                <div className="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div 
                        className="h-full bg-amber-400 rounded-full" 
                        style={{ width: `${(parseFloat(score) / 5) * 100}%` }}
                    ></div>
                </div>
                <span className="text-xs font-semibold text-slate-700 w-6 text-right">
                    {parseFloat(score).toFixed(1)}
                </span>
            </div>
        </div>
    );
};

export default function Reviews({ role, reviews }) {
    const isHost = role === 'host';

    return (
        <div className="space-y-6">
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-bold text-slate-900">
                    {isHost ? 'Reviews Received' : 'Reviews Written'}
                </h1>
                {reviews?.length > 0 && (
                    <span className="px-4 py-1.5 bg-slate-100 text-slate-600 rounded-full text-sm font-medium">
                        {reviews.length} Total
                    </span>
                )}
            </div>

            <div className="space-y-6">
                {reviews?.length > 0 ? (
                    reviews.map(review => {
                        const reviewDate = review.stay_date 
                            ? new Date(review.stay_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
                            : new Date(review.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                        
           
                        const title = isHost 
                            ? (review.user?.name || review.guest_name || 'Guest') 
                            : (review.listing?.title || 'Property');
                            
                        const subtitle = isHost 
                            ? `Stayed at: ${review.listing?.title || 'Your Property'}` 
                            : `Hosted by: ${review.listing?.host?.name || 'Host'}`;
                            
                        const imageUrl = isHost 
                            ? review.user?.image_url 
                            : review.listing?.image_url;
                            
                        const link = !isHost && review.listing?.slug ? `/property/${review.listing.slug}` : null;

                        return (
                            <div key={review.id} className="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                                <div className="flex flex-col md:flex-row">
                                
                                    <div className="md:w-56 h-40 md:h-auto flex-shrink-0 bg-slate-100 relative">
                                        {imageUrl ? (
                                            <img src={imageUrl} alt={title} className="w-full h-full object-cover" />
                                        ) : (
                                            <div className="w-full h-full flex items-center justify-center text-slate-300">
                                                <FiMessageSquare className="w-12 h-12" />
                                            </div>
                                        )}
                                     
                                        <div className="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5">
                                            <FiStar className="w-4 h-4 fill-amber-400 text-amber-400" />
                                            <span className="font-bold text-slate-800 text-sm">
                                                {parseFloat(review.overall_rating).toFixed(1)}
                                            </span>
                                        </div>
                                    </div>

                            
                                    <div className="p-6 flex-1 flex flex-col">
                                        <div className="flex justify-between items-start mb-2">
                                            <div>
                                                <h3 className="font-bold text-slate-900 text-lg leading-tight">{title}</h3>
                                                <p className="text-sm text-slate-500 mt-1">{subtitle}</p>
                                                <p className="text-xs text-slate-400 mt-1">
                                                    {review.stay_date ? `Stayed in ${reviewDate}` : `Reviewed on ${reviewDate}`}
                                                </p>
                                            </div>
                                        </div>

                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-x-8 mb-2">
                                            <RatingRow icon={<FiDroplet className="w-4 h-4 text-slate-400" />} label="Cleanliness" score={review.cleanliness} />
                                            <RatingRow icon={<FiTarget className="w-4 h-4 text-slate-400" />} label="Accuracy" score={review.accuracy} />
                                            <RatingRow icon={<FiCheckCircle className="w-4 h-4 text-slate-400" />} label="Check-in" score={review.check_in} />
                                            <RatingRow icon={<FiMapPin className="w-4 h-4 text-slate-400" />} label="Location" score={review.location} />
                                            <RatingRow icon={<FiDollarSign className="w-4 h-4 text-slate-400" />} label="Value" score={review.value} />
                                        </div>

                            
                                        <div className="mt-auto bg-slate-50 border-l-4 border-brand/50 p-4 rounded-r-lg">
                                            <p className="text-slate-600 leading-relaxed text-sm italic">
                                                "{review.comment}"
                                            </p>
                                        </div>

                                        {link && (
                                            <div className="mt-4 text-right">
                                                <Link href={link} className="text-brand hover:text-brand/80 text-sm font-semibold transition-colors">
                                                    View Property →
                                                </Link>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>
                        );
                    })
                ) : (
                    <div className="bg-white border border-dashed border-slate-300 rounded-2xl p-16 text-center">
                        <div className="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <FiStar className="w-8 h-8 text-slate-300" />
                        </div>
                        <h3 className="text-lg font-semibold text-slate-700 mb-1">No reviews yet</h3>
                        <p className="text-sm text-slate-400 max-w-xs mx-auto">
                            {isHost 
                                ? "Once guests complete their stays, their reviews will show up here." 
                                : "You haven't left any reviews for your recent stays yet."
                            }
                        </p>
                    </div>
                )}
            </div>
        </div>
    );
}