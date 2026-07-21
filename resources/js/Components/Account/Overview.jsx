import React from 'react';
import { Link } from '@inertiajs/react';
import { Line } from 'react-chartjs-2';
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Tooltip, Filler } from 'chart.js'; 
import { FiHome, FiCalendar, FiDollarSign, FiStar, FiTrendingUp, FiHeart, FiUser, FiMapPin } from 'react-icons/fi';
ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Tooltip, Filler);

export default function Overview({ role, stats, bookings, earningsData, reviews, savedCount }) {
    const chartData = {
        labels: earningsData?.map(d => d.date) || [],
        datasets: [{
            label: 'Earnings (Rs)',
            data: earningsData?.map(d => d.earning) || [],
            borderColor: 'rgb(13, 148, 136)',
            backgroundColor: 'rgba(13, 148, 136, 0.08)',
            tension: 0.4,
            fill: true,
            pointRadius: 3,
            pointHoverRadius: 5
        }]
    };
    const chartOptions = {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
        scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
    };

    return (
        <div className="space-y-6">
            <h1 className="text-2xl font-bold text-slate-900">{role === 'host' ? 'Host Overview' : 'Welcome Back!'}</h1>
            
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {role === 'host' ? (
                    <>
                    <StatCard icon={<FiHome />} title="Properties" value={stats.total_properties} color="text-blue-600 bg-blue-50" />
                    <StatCard icon={<FiCalendar />} title="Bookings" value={stats.total_bookings} color="text-purple-600 bg-purple-50" />
                    <StatCard icon={<FiDollarSign />} title="Total Earned" value={`Rs ${stats.total_earnings}`} color="text-green-600 bg-green-50" />
                    <StatCard icon={<FiStar />} title="Avg Rating" value={stats.avg_rating} color="text-amber-500 bg-amber-50" />
                    </>
                ) : (
                    <>
                    <StatCard icon={<FiCalendar />} title="Total Trips" value={stats.total_trips} color="text-blue-600 bg-blue-50" />
                    <StatCard icon={<FiTrendingUp />} title="Upcoming" value={stats.upcoming_trips} color="text-green-600 bg-green-50" />
                    <StatCard icon={<FiHeart />} title="Saved" value={savedCount || 0} color="text-red-500 bg-red-50" />
                    <StatCard icon={<FiStar />} title="Reviews" value={reviews?.length || 0} color="text-amber-500 bg-amber-50" />
                    </>
                )}
            </div>

            {role === 'host' && earningsData && earningsData.length > 0 && (
                <div className="bg-white border border-slate-200 rounded-xl p-6">
                    <h3 className="text-lg font-bold text-slate-800 mb-4">Earnings (Last 30 Days)</h3>
                    <div className="h-64"><Line data={chartData} options={chartOptions} /></div>
                </div>
            )}

            <div className="bg-white border border-slate-200 rounded-xl overflow-hidden">
                <div className="p-6 border-b border-slate-100"><h3 className="text-lg font-bold text-slate-800">Recent Activity</h3></div>
                {bookings?.length > 0 ? (
                    <div className="divide-y divide-slate-100">
                        {bookings.slice(0, 3).map(b => <BookingRow key={b.id} booking={b} role={role} compact />)}
                    </div>
                ) : <div className="p-10 text-center text-slate-500">No recent activity.</div>}
            </div>
        </div>
    );
}

function StatCard({ icon, title, value, color }) {
    return (
        <div className="bg-white border border-slate-200 rounded-xl p-5 flex items-center gap-4">
            <div className={`p-3 rounded-lg ${color}`}>{icon}</div>
            <div>
                <p className="text-sm text-slate-500 font-medium">{title}</p>
                <h3 className="text-xl font-bold text-slate-800 mt-0.5">{value}</h3>
            </div>
        </div>
    );
}

function BookingRow({ booking, role, compact }) {
    const item = booking.listing || booking.property;
    const otherUser = role === 'host' ? booking.user : (item?.host || item?.user); 
    return (
        <div className={`p-5 flex flex-col sm:flex-row gap-4 sm:items-center hover:bg-slate-50 transition-colors ${compact ? 'py-4' : ''}`}>
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