import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import FrontLayout from '@/Layouts/FrontLayout';
import { FiPlus, FiEdit2, FiEye, FiHome } from 'react-icons/fi';
export default function MyListings({ listings }) {
    return (
        <FrontLayout>
            <Head title="My Listings - EzProperty" />
            
            <div className="bg-white py-4">
                <div className="max-w-7xl mx-auto px-2 sm:px-3 lg:px-4">
                    
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                        <div>
                            <h1 className="text-2xl font-bold text-slate-900">My Properties</h1>
                            <p className="text-slate-500 mt-1">Manage your listed properties and their availability.</p>
                        </div>
                        <Link 
                            href="/properties/create" 
                            className="inline-flex items-center gap-2 bg-brand text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-brand/90 transition shadow-sm"
                        >
                            <FiPlus className="w-5 h-5" />
                            List New Property
                        </Link>
                    </div>

                    {listings && listings.length > 0 ? (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {listings.map((listing) => (
                                <div key={listing.id} className="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                                    <div className="relative h-48 bg-slate-100">
                                        <img 
                                            src={listing.image_url || 'https://via.placeholder.com/400x300?text=No+Image'} 
                                            alt={listing.title} 
                                            className="w-full h-full object-cover"
                                        />
                                        <span className={`absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide ${
                                            listing.status ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'
                                        }`}>
                                            {listing.status ? 'Active' : 'Inactive'}
                                        </span>
                                    </div>

                                    <div className="p-5">
                                        <div className="flex items-center gap-2 mb-2">
                                            <span className="text-xs font-semibold text-brand bg-brand/10 px-2 py-0.5 rounded">
                                                {listing.category?.name || 'Property'}
                                            </span>
                                            <span className="text-xs text-slate-500">
                                                {listing.listing_type?.replace('_', ' ').toUpperCase()}
                                            </span>
                                        </div>
                                        
                                        <h3 className="font-bold text-slate-800 text-lg truncate mb-1">{listing.title}</h3>
                                        <p className="text-sm text-slate-500 mb-4 flex items-center gap-1">
                                            <FiHome className="w-4 h-4" /> {listing.city}, {listing.province}
                                        </p>

                                        <div className="flex items-center justify-between pt-4 border-t border-slate-100">
                                            <div>
                                                <span className="text-xl font-bold text-slate-900">Rs {listing.base_price}</span>
                                                <span className="text-sm text-slate-500"> / night</span>
                                            </div>
                                            
                                            <div className="flex items-center gap-2">

                                                <Link 
                                                    href={`/property/${listing.slug}`}
                                                    className="p-2 text-slate-500 hover:text-brand hover:bg-brand/10 rounded-lg transition"
                                                    title="View Property"
                                                >
                                                    <FiEye className="w-5 h-5" />
                                                </Link>
                                                <Link 
                                                    href={`/properties/${listing.id}/edit`} 
                                                    className="p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                                    title="Edit Property"
                                                >
                                                    <FiEdit2 className="w-5 h-5" />
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="bg-white border border-slate-200 rounded-xl p-16 text-center">
                            <div className="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <FiHome className="w-8 h-8 text-slate-400" />
                            </div>
                            <h3 className="text-lg font-bold text-slate-800 mb-2">No properties listed yet</h3>
                            <p className="text-slate-500 mb-6 max-w-md mx-auto">
                                Start earning by listing your first property. It's quick and easy to set up.
                            </p>
                            <Link 
                                href="/properties/create" 
                                className="inline-flex items-center gap-2 bg-brand text-white px-6 py-3 rounded-lg font-semibold hover:bg-brand/90 transition"
                            >
                                <FiPlus className="w-5 h-5" />
                                List Your First Property
                            </Link>
                        </div>
                    )}
                </div>
            </div>
        </FrontLayout>
    );
}