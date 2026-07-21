import React from 'react';
import { Link } from '@inertiajs/react';
import { FiCalendar, FiUser, FiMapPin } from 'react-icons/fi';

export default function Reservations({ role, bookings }) {
    return (
        <div className="space-y-6">
            <h1 className="text-2xl font-bold text-slate-900">{role === 'host' ? 'Reservations' : 'My Trips'}</h1>
            <div className="bg-white border border-slate-200 rounded-xl overflow-hidden">
                {bookings?.length > 0 ? (
                    <div className="divide-y divide-slate-100">
                        {bookings.map(b => <BookingRow key={b.id} booking={b} role={role} />)}
                    </div>
                ) : (
                    <div className="p-16 text-center">
                        <FiCalendar className="mx-auto text-4xl text-slate-300 mb-4" />
                        <h3 className="text-lg font-semibold text-slate-700">No bookings found</h3>
                        <Link href="/" className="mt-4 inline-block bg-brand text-white px-6 py-2.5 rounded-lg font-medium transition-colors hover:bg-brand/90">Explore Properties</Link>
                    </div>
                )}
            </div>
        </div>
    );
}

function BookingRow({ booking, role }) {
    const item = booking.listing || booking.property;
    const otherUser = role === 'host' ? booking.user : (item?.host || item?.user); 
    
    return (
        <div className="p-5 flex flex-col sm:flex-row gap-4 sm:items-center hover:bg-slate-50 transition-colors">
            <img src={item?.image_url || 'https://via.placeholder.com/150'} alt={item?.title} className="w-full sm:w-24 h-32 sm:h-24 rounded-lg object-cover flex-shrink-0 bg-slate-100" />
            <div className="flex-1 min-w-0">
                <h3 className="font-bold text-slate-800 text-base sm:text-lg truncate">{item?.title || 'Property'}</h3>
                <p className="text-sm text-slate-500 flex items-center gap-1.5 mt-1.5">
                    <FiMapPin className="w-4 h-4 flex-shrink-0" /> {item?.address || item?.city || 'Unknown Location'}
                </p>
                <div className="flex flex-wrap gap-x-4 gap-y-2 mt-3 text-sm text-slate-600">
                    <span className="flex items-center gap-1.5"><FiUser className="w-4 h-4 text-slate-400" /> {role === 'host' ? 'Guest:' : 'Host:'} {otherUser?.name || 'Unknown'}</span>
                    <span className="flex items-center gap-1.5"><FiCalendar className="w-4 h-4 text-slate-400" /> {booking.check_in ? new Date(booking.check_in).toLocaleDateString() : 'N/A'}</span>
                </div>
            </div>
            <div className="flex flex-col sm:items-end gap-2 mt-2 sm:mt-0">
                <span className={`px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide ${
                    booking.status === 'confirmed' || booking.status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'
                }`}>{booking.status}</span>
                <span className="font-bold text-slate-800 text-lg">Rs {booking.total_price || booking.total || 0}</span>
            </div>
        </div>
    );
}