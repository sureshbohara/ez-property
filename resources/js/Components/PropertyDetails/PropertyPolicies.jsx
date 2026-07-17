import React from 'react';

export default function PropertyPolicies({ listing }) {
    const policyText = listing.cancellation_policy === 'flexible' ? 'Free cancellation for 48 hours after booking.' : 
                       listing.cancellation_policy === 'moderate' ? 'Free cancellation up to 5 days before check-in.' : '50% refund up to 1 week before check-in.';
    return (
        <section id="policies" className="border-t border-slate-200 pt-10 scroll-mt-36 pb-8">
            <h2 className="text-2xl font-bold text-dark mb-8">Things to know</h2>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div className="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <h3 className="font-bold text-dark mb-4 flex items-center gap-2"><i className="fa-solid fa-house-chimney text-brand text-lg"></i> House rules</h3>
                    <ul className="space-y-3 text-sm text-slate-600">
                        <li className="flex items-start gap-3"><i className="fa-solid fa-check text-brand mt-0.5 shrink-0"></i><span>Check-in: 2:00 PM - 8:00 PM</span></li>
                        <li className="flex items-start gap-3"><i className="fa-solid fa-check text-brand mt-0.5 shrink-0"></i><span>Checkout: 11:00 AM</span></li>
                        <li className="flex items-start gap-3"><i className="fa-solid fa-ban text-red-400 mt-0.5 shrink-0"></i><span>No smoking inside the property</span></li>
                    </ul>
                </div>
                <div className="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <h3 className="font-bold text-dark mb-4 flex items-center gap-2"><i className="fa-solid fa-receipt text-brand text-lg"></i> Cancellation policy</h3>
                    <ul className="space-y-3 text-sm text-slate-600">
                        <li className="flex items-start gap-3"><i className="fa-solid fa-clock text-brand mt-0.5 shrink-0"></i><span>{policyText}</span></li>
                    </ul>
                    <a href="#" className="text-sm text-brand font-semibold underline underline-offset-4 mt-4 inline-block hover:text-brand-hover">Read full policy</a>
                </div>
                <div className="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <h3 className="font-bold text-dark mb-4 flex items-center gap-2"><i className="fa-solid fa-shield-halved text-brand text-lg"></i> Safety & property</h3>
                    <ul className="space-y-3 text-sm text-slate-600">
                        <li className="flex items-start gap-3"><i className="fa-solid fa-check text-brand mt-0.5 shrink-0"></i><span>Carbon monoxide alarm installed</span></li>
                        <li className="flex items-start gap-3"><i className="fa-solid fa-check text-brand mt-0.5 shrink-0"></i><span>Smoke alarm installed</span></li>
                    </ul>
                </div>
            </div>
            
      
            <div className="mt-10 bg-brand-lightest/50 p-6 rounded-2xl border border-brand/10 flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <img src={listing.user?.image_url || "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150"} className="w-20 h-20 rounded-full object-cover border-2 border-white shadow-md" alt="Host" />
                <div className="flex-1">
                    <h3 className="text-lg font-bold text-dark flex items-center gap-2">Hosted by {listing.user?.name || 'Host'} <i className="fa-solid fa-medal text-brand text-sm" title="Superhost"></i></h3>
                    <p className="text-sm text-slate-600 mt-1">Superhost · Response rate: 100%</p>
                    <p className="text-sm text-slate-600 mt-2 max-w-lg">Committed to providing great stays for guests.</p>
                </div>
                <button className="shrink-0 px-6 py-2.5 border border-slate-800 rounded-xl font-semibold text-dark hover:bg-white transition whitespace-nowrap">Contact Host</button>
            </div>
        </section>
    );
}