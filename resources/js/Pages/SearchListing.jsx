import React from 'react';
import { Head, Link } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import SearchSection from '../Components/HomeSections/SearchSection';
import FilterSection from '../Components/HomeSections/FilterSection';
import PropertyCard from '../Components/PropertyCard';

export default function SearchListing({ searchResults, searchParams, propertyTypes, selectedType, popularDestinations }) {
    const totalGuests = (searchParams.adults || 0) + (searchParams.children || 0);
    
    const formatDate = (dateStr) => {
        if (!dateStr) return 'Add dates';
        return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    };

    const dateText = searchParams.checkIn && searchParams.checkOut 
        ? `${formatDate(searchParams.checkIn)} - ${formatDate(searchParams.checkOut)}`
        : 'Add dates';
        
    const locationText = searchParams.location || 'Anywhere';
    const guestText = totalGuests > 0 ? `${totalGuests} Guest${totalGuests > 1 ? 's' : ''}` : 'Add guests';

    return (
        <>
            <Head title={`Search: ${locationText} · ${dateText} · ${guestText} - EzProperty`} />
            
            <SearchSection popularDestinations={popularDestinations} />
            <FilterSection filter={propertyTypes} selectedType={selectedType} />
            
            <section className="bg-white px-4 sm:px-6 lg:px-8 py-10 pb-16">
                <div className="max-w-[1536px] mx-auto">
                    <div className="flex items-end justify-between mb-6">
                        <div>
                            <h2 className="text-2xl font-bold text-dark">
                                {searchResults.total} stays in {locationText}
                            </h2>
                            <p className="text-slate-500 mt-1">
                                {dateText} · {guestText}
                            </p>
                        </div>
                    </div>

                    {searchResults.data && searchResults.data.length > 0 ? (
                        <>
                            <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 gap-4">
                                {searchResults.data.map((item) => (
                                    <PropertyCard key={item.id} listing={item} variant="square" />
                                ))}
                            </div>

           
                            {searchResults.last_page > 1 && (
                                <div className="mt-12 flex justify-center">
                                    <nav className="flex items-center gap-2">
                                        {searchResults.prev_page_url ? (
                                            <Link 
                                                href={searchResults.prev_page_url}
                                                className="px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50 transition text-sm font-medium text-dark flex items-center gap-2"
                                            >
                                                <i className="fa-solid fa-chevron-left text-xs"></i> Previous
                                            </Link>
                                        ) : (
                                            <button 
                                                disabled
                                                className="px-4 py-2 border border-slate-100 rounded-lg text-slate-300 text-sm font-medium cursor-not-allowed flex items-center gap-2"
                                            >
                                                <i className="fa-solid fa-chevron-left text-xs"></i> Previous
                                            </button>
                                        )}

                                        <div className="flex items-center gap-1">
                                            {searchResults.links.map((link, index) => {
                                                if (link.label.includes('Previous') || link.label.includes('Next')) return null;
                                                
                                                const isActive = link.active;
                                                
                                                return (
                                                    <Link
                                                        key={index}
                                                        href={link.url || '#'}
                                                        className={`w-10 h-10 flex items-center justify-center rounded-lg text-sm font-medium transition ${
                                                            isActive 
                                                                ? 'bg-brand text-white shadow-sm' 
                                                                : 'text-dark hover:bg-slate-100 border border-transparent hover:border-slate-200'
                                                        } ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`}
                                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                                    />
                                                );
                                            })}
                                        </div>

                                 
                                        {searchResults.next_page_url ? (
                                            <Link 
                                                href={searchResults.next_page_url}
                                                className="px-4 py-2 border border-slate-200 rounded-lg hover:bg-slate-50 transition text-sm font-medium text-dark flex items-center gap-2"
                                            >
                                                Next <i className="fa-solid fa-chevron-right text-xs"></i>
                                            </Link>
                                        ) : (
                                            <button 
                                                disabled
                                                className="px-4 py-2 border border-slate-100 rounded-lg text-slate-300 text-sm font-medium cursor-not-allowed flex items-center gap-2"
                                            >
                                                Next <i className="fa-solid fa-chevron-right text-xs"></i>
                                            </button>
                                        )}
                                    </nav>
                                </div>
                            )}

                   
                            <div className="mt-4 text-center text-sm text-slate-500">
                                Showing {searchResults.from} to {searchResults.to} of {searchResults.total} results
                            </div>
                        </>
                    ) : (
                        <div className="text-center py-20 bg-slate-50 rounded-2xl border border-slate-200">
                            <i className="fa-solid fa-compass text-5xl text-slate-300 mb-4"></i>
                            <p className="text-slate-500 text-lg">No properties found matching your criteria.</p>
                            <Link href="/" className="text-brand font-semibold hover:underline mt-2 inline-block">
                                Clear filters and browse all homes
                            </Link>
                        </div>
                    )}
                </div>
            </section>
        </>
    );
}

SearchListing.layout = page => <FrontLayout>{page}</FrontLayout>;