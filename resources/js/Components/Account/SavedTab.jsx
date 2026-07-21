import React from 'react';
import { Link } from '@inertiajs/react';
import { FiHeart, FiUser, FiHome } from 'react-icons/fi';
import PropertyCard from '../PropertyCard';

export default function SavedTab({ role, savedListings, myListingsSavedByOthers }) {
    if (role === 'guest') {
        return (
            <div className="space-y-6">
                <h1 className="text-2xl font-bold text-slate-900">My Saved Properties</h1>
                {savedListings && savedListings.length > 0 ? (
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        {savedListings.map(listing => (
                            <PropertyCard key={listing.id} listing={listing} variant="default" />
                        ))}
                    </div>
                ) : (
                    <div className="bg-white border border-slate-200 rounded-xl p-16 text-center">
                        <FiHeart className="mx-auto text-4xl text-slate-300 mb-4" />
                        <h3 className="text-lg font-semibold text-slate-700">No saved properties yet</h3>
                        <p className="text-slate-500 mt-2 mb-6">Start exploring and save your favorite stays!</p>
                        <Link href="/" className="inline-block bg-brand text-white px-6 py-2.5 rounded-lg font-medium hover:bg-brand/90 transition">
                            Explore Properties
                        </Link>
                    </div>
                )}
            </div>
        );
    }
    return (
        <div className="space-y-8">
            <h1 className="text-2xl font-bold text-slate-900">Saved Properties Overview</h1>
            <div className="bg-white border border-slate-200 rounded-xl overflow-hidden">
                <div className="p-6 border-b border-slate-100 bg-slate-50">
                    <h2 className="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <FiHome className="text-brand" /> My Properties Saved by Guests
                    </h2>
                    <p className="text-sm text-slate-500 mt-1">See which of your listings are popular among guests.</p>
                </div>
                
                {myListingsSavedByOthers && myListingsSavedByOthers.length > 0 ? (
                    <div className="divide-y divide-slate-100">
                        {myListingsSavedByOthers.map(listing => (
                            <div key={listing.id} className="p-6 hover:bg-slate-50 transition-colors">
                                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div className="flex items-start gap-4">
                                        <img src={listing.image_url || 'https://via.placeholder.com/150'} alt={listing.title} className="w-20 h-20 rounded-lg object-cover flex-shrink-0" />
                                        <div>
                                            <h3 className="font-bold text-slate-800">{listing.title}</h3>
                                            <p className="text-sm text-slate-500 flex items-center gap-1 mt-1">
                                                <FiHeart className="text-red-500" /> Saved by <span className="font-semibold text-slate-700">{listing.saved_by_users_count}</span> guest(s)
                                            </p>
                                            <div className="flex flex-wrap gap-2 mt-2">
                                                {listing.saved_by_users.slice(0, 5).map((user, idx) => (
                                                    <span key={idx} className="inline-flex items-center gap-1 bg-slate-100 text-slate-600 px-2 py-1 rounded-full text-xs">
                                                        <FiUser className="w-3 h-3" /> {user.name}
                                                    </span>
                                                ))}
                                                {listing.saved_by_users_count > 5 && (
                                                    <span className="text-xs text-slate-400 py-1">+{listing.saved_by_users_count - 5} more</span>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                    <Link href={`/properties/${listing.id}/edit`} className="text-sm text-brand font-medium hover:underline whitespace-nowrap">
                                        Edit Listing
                                    </Link>
                                </div>
                            </div>
                        ))}
                    </div>
                ) : (
                    <div className="p-10 text-center text-slate-500">
                        <p>No guests have saved your properties yet.</p>
                    </div>
                )}
            </div>

            <div>
                <h2 className="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <FiHeart className="text-red-500" /> Properties I Have Saved
                </h2>
                {savedListings && savedListings.length > 0 ? (
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        {savedListings.map(listing => (
                            <PropertyCard key={listing.id} listing={listing} variant="default" />
                        ))}
                    </div>
                ) : (
                    <div className="bg-white border border-slate-200 rounded-xl p-10 text-center">
                        <p className="text-slate-500">You haven't saved any properties yet.</p>
                    </div>
                )}
            </div>
        </div>
    );
}