import React, { useState } from 'react';

export default function PropertyOverview({ listing }) {
    const [showMore, setShowMore] = useState(false);

    const description = listing?.description || '';
    const shouldCollapse = description.length > 300;

    const displayDescription =
        showMore || !shouldCollapse
            ? description
            : `${description.substring(0, 300)}...`;

    const details = [
        {
            icon: 'fa-user-group',
            value: `${listing.guests} guests`,
        },
        {
            icon: 'fa-bed',
            value: `${listing.bedrooms} bedroom${listing.bedrooms > 1 ? 's' : ''}`,
        },
        {
            icon: 'fa-bed',
            value: `${listing.beds} bed${listing.beds > 1 ? 's' : ''}`,
        },
        {
            icon: 'fa-bath',
            value: `${listing.bathrooms} bath${listing.bathrooms > 1 ? 's' : ''}`,
        },
    ];
    return (
        <section id="overview" className="scroll-mt-36">
            <div className="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
                {details.map((item, index) => (
                    <div
                        key={index}
                        className="
                            flex items-center gap-3
                            px-3 py-3
                            bg-slate-50
                            rounded-xl
                            border border-slate-100
                        "
                    >
                        <i className={`fa-solid ${item.icon} text-brand text-lg`} />

                        <span className="text-sm font-medium text-dark">
                            {item.value}
                        </span>
                    </div>
                ))}
            </div>


            <div className="space-y-5 mb-8">

                {listing.instant_bookable && (
                    <div className="flex gap-4 items-start">
                        <div className="
                            w-11 h-11 shrink-0
                            flex items-center justify-center
                            rounded-full
                            bg-brand-lightest
                        ">
                            <i className="fa-solid fa-key text-brand" />
                        </div>

                        <div>
                            <h3 className="font-semibold text-dark">
                                Self check-in
                            </h3>

                            <p className="text-sm text-slate-600 mt-1">
                                Check yourself in with the keypad lockbox.
                            </p>
                        </div>
                    </div>
                )}


                <div className="flex gap-4 items-start">
                    <div className="
                        w-11 h-11 shrink-0
                        flex items-center justify-center
                        rounded-full
                        bg-brand-lightest
                    ">
                        <i className="fa-solid fa-location-dot text-brand" />
                    </div>

                    <div>
                        <h3 className="font-semibold text-dark">
                            Great location
                        </h3>

                        <p className="text-sm text-slate-600 mt-1">
                            95% of recent guests gave the location a 5-star rating.
                        </p>
                    </div>
                </div>

            </div>



            <div className="border-t border-slate-200 pt-6">

                <p className="
                    text-slate-700
                    leading-relaxed
                    whitespace-pre-line
                ">
                    {displayDescription}
                </p>


                {shouldCollapse && (
                    <button
                        onClick={() => setShowMore(!showMore)}
                        className="
                            mt-4
                            flex items-center gap-2
                            font-semibold
                            text-dark
                            underline
                            hover:text-brand
                            transition
                        "
                    >
                        {showMore ? 'Show less' : 'Show more'}

                        <i
                            className={`
                                fa-solid
                                fa-chevron-down
                                text-xs
                                transition-transform
                                ${showMore ? 'rotate-180' : ''}
                            `}
                        />
                    </button>
                )}

            </div>

        </section>
    );
}