import React from 'react';
import { Head } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import SearchSection from '../Components/HomeSections/SearchSection';
import FilterSection from '../Components/HomeSections/FilterSection';
import FeaturedSection from '../Components/HomeSections/FeaturedSection';
import StaysNearSection from '../Components/HomeSections/StaysNearSection';
import HomestaysSection from '../Components/HomeSections/HomestaysSection';
import RecommendedSection from '../Components/HomeSections/RecommendedSection';
import TrustSection from '../Components/HomeSections/TrustSection';

export default function Home({propertyTypes,popularDestinations,selectedType,categories,featuredProperties,homestays,nearby,recommended}) {
    return (
        <>
            <Head title="Home - Ez BNB Nepali" />
            <SearchSection popularDestinations={popularDestinations} />
            <FilterSection filter={propertyTypes} selectedType={selectedType} />
            <FeaturedSection listing={featuredProperties} />
            <StaysNearSection listing={nearby} />
            <HomestaysSection listing={homestays} />
            <RecommendedSection listing={recommended} />
            <TrustSection />
        </>
    );
}

Home.layout = page => <FrontLayout>{page}</FrontLayout>;