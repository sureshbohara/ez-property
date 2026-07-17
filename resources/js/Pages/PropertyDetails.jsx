import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import PropertyHeader from '../Components/PropertyDetails/PropertyHeader';
import PropertyGallery from '../Components/PropertyDetails/PropertyGallery';
import PropertyOverview from '../Components/PropertyDetails/PropertyOverview';
import PropertyAmenities from '../Components/PropertyDetails/PropertyAmenities';
import PropertyCalendar from '../Components/PropertyDetails/PropertyCalendar';
import PropertyReviews from '../Components/PropertyDetails/PropertyReviews';
import PropertyPolicies from '../Components/PropertyDetails/PropertyPolicies';
import BookingCard from '../Components/PropertyDetails/BookingCard';

export default function PropertyDetails({ 
    listing, 
    calendarData, 
    totalReviews, 
    reviews,
    avgOverall, 
    avgCleanliness, 
    avgAccuracy, 
    avgCheckIn, 
    avgLocation, 
    avgValue 
}) {
    const [checkIn, setCheckIn] = useState(null);
    const [checkOut, setCheckOut] = useState(null);
    const [guests, setGuests] = useState({ adults: 1, children: 0 });
    const [showGuestDropdown, setShowGuestDropdown] = useState(false);

    const scrollToCalendar = () => {
        const calendarSection = document.getElementById('availability');
        if (calendarSection) {
            calendarSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    };

    return (
        <>
            <Head title={`${listing.title} - EzProperty`} />
            <div className="flex-1 max-w-[1280px] mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
                <PropertyHeader listing={listing} totalReviews={totalReviews} avgOverall={avgOverall} />
                <PropertyGallery listing={listing} />
                
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-12 relative mt-4 items-start">
                    {/* LEFT COLUMN */}
                    <div className="lg:col-span-2 space-y-12">
                        <PropertyOverview listing={listing} />
                        <PropertyAmenities listing={listing} />
                        
                        <PropertyCalendar 
                            listing={listing} 
                            calendarData={calendarData} 
                            checkIn={checkIn}
                            setCheckIn={setCheckIn}
                            checkOut={checkOut}
                            setCheckOut={setCheckOut}
                        />
                        
                        <PropertyReviews 
                            totalReviews={totalReviews} 
                            avgOverall={avgOverall} 
                            reviews={reviews}
                            avgCleanliness={avgCleanliness} 
                            avgAccuracy={avgAccuracy} 
                            avgCheckIn={avgCheckIn} 
                            avgLocation={avgLocation} 
                            avgValue={avgValue} 
                        />
                        <PropertyPolicies listing={listing} />
                    </div>
                    
                    <div className="lg:col-span-1 self-start">
                        <BookingCard 
                            listing={listing}
                            calendarData={calendarData}
                            checkIn={checkIn}
                            checkOut={checkOut}
                            onDateFieldClick={scrollToCalendar}
                            guests={guests}
                            setGuests={setGuests}
                            showGuestDropdown={showGuestDropdown}
                            setShowGuestDropdown={setShowGuestDropdown}
                        />
                    </div>
                </div>
            </div>
        </>
    );
}

PropertyDetails.layout = page => <FrontLayout>{page}</FrontLayout>;