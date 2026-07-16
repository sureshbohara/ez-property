import React from 'react';
import { Head, Link } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import SearchSection from '../Components/HomeSections/SearchSection';
import FilterSection from '../Components/HomeSections/FilterSection'; 
import PropertyCard from '../Components/PropertyCard';

export default function Services({ services, propertyTypes, selectedType, popularDestinations }) {
    return (
        <>
        <Head title="Services - EzProperty" />

        <SearchSection popularDestinations={popularDestinations} />

        <FilterSection filter={propertyTypes} selectedType={selectedType} />

        <section className="bg-white px-4 sm:px-6 lg:px-8 py-10 pb-16">
            <div className="max-w-[1536px] mx-auto">

                <div className="flex items-end justify-between mb-6">
                    <div>
                        <h2 className="section-title">All Services for you</h2>
                        <p className="section-subtitle">Everything you need for a seamless journey</p>
                    </div>
                </div>

                {services && services.length > 0 ? (
                    <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                        {services.map((item) => (
                            <PropertyCard key={item.id} listing={item} variant="square" />
                            ))}
                    </div>
                    ) : (
                    <div className="text-center py-20 bg-white rounded-2xl border border-slate-200">
                        <i className="fa-solid fa-briefcase text-5xl text-slate-300 mb-4"></i>
                        <p className="text-slate-500 text-lg">No services found at the moment.</p>
                        <Link href="/" className="text-brand font-semibold hover:underline mt-2 inline-block">
                        Browse Homes instead
                    </Link>
                </div>
                )}
                </div>
            </section>
            </>
            );
}

Services.layout = page => <FrontLayout>{page}</FrontLayout>;