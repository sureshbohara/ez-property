import React, { useState, useEffect } from 'react';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import FrontLayout from '@/Layouts/FrontLayout';
import { Line } from 'react-chartjs-2';
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Tooltip, Filler } from 'chart.js';
import toast from 'react-hot-toast';
import { FiHome, FiCalendar, FiMessageSquare, FiStar, FiSettings, FiDollarSign, FiTrendingUp, FiUser, FiMapPin, FiHeart } from 'react-icons/fi';

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Tooltip, Filler);

export default function Dashboard({ auth, role, stats, listings, bookings, reviews, earningsData, messages }) {
    const [activeTab, setActiveTab] = useState('overview');
    const { flash } = usePage().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash]);

    const tabs = [
        { id: 'overview', label: 'Overview', icon: FiHome },
        { id: 'bookings', label: role === 'host' ? 'Reservations' : 'My Trips', icon: FiCalendar },
        { id: 'reviews', label: 'Reviews', icon: FiStar },
        { id: 'messages', label: 'Messages', icon: FiMessageSquare },
        { id: 'settings', label: 'Settings', icon: FiSettings },
    ];

    return (
        <FrontLayout>
            <Head title="Dashboard - EzProperty" />
            <div className="bg-slate-50 min-h-[calc(100vh-80px)] py-8">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-8">
                    
                    {/* Sidebar */}
                    <aside className="md:w-64 flex-shrink-0">
                        <div className="bg-white rounded-xl border border-slate-200 p-6 sticky top-24">
                            <div className="flex flex-col items-center text-center mb-6">
                                <img 
                                    src={auth.image_url || `https://ui-avatars.com/api/?name=${auth.name}&background=0d9488&color=fff`} 
                                    alt={auth.name} 
                                    className="w-20 h-20 rounded-full object-cover mb-3 border-2 border-brand"
                                />
                                <h3 className="text-lg font-bold text-slate-800">{auth.name}</h3>
                                <span className={`mt-2 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide ${role === 'host' ? 'bg-brand/10 text-brand' : 'bg-slate-100 text-slate-600'}`}>
                                    {role === 'host' ? 'Host' : 'Guest'}
                                </span>
                            </div>
                            
                            <nav className="space-y-1">
                                {tabs.map((tab) => (
                                    <button
                                        key={tab.id}
                                        onClick={() => setActiveTab(tab.id)}
                                        className={`w-full flex items-center gap-3 px-4 py-3 rounded-lg font-medium text-sm transition-colors ${
                                            activeTab === tab.id 
                                                ? 'bg-brand/10 text-brand font-semibold' 
                                                : 'text-slate-600 hover:bg-slate-50'
                                        }`}
                                    >
                                        <tab.icon className="h-5 w-5" />
                                        {tab.label}
                                    </button>
                                ))}
                            </nav>
                        </div>
                    </aside>

                    {/* Main Content */}
                    <main className="flex-1 min-w-0">
                        {activeTab === 'overview' && <OverviewTab role={role} stats={stats} bookings={bookings} earningsData={earningsData} />}
                        {activeTab === 'bookings' && <BookingsTab role={role} bookings={bookings} />}
                        {activeTab === 'reviews' && <ReviewsTab role={role} reviews={reviews} />}
                        {activeTab === 'messages' && <MessagesTab messages={messages} auth={auth} />}
                        {activeTab === 'settings' && <SettingsTab user={auth} />}
                    </main>
                </div>
            </div>
        </FrontLayout>
    );
}

/* =========================================
   TAB COMPONENTS
========================================= */

function OverviewTab({ role, stats, bookings, earningsData }) {
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
                        <StatCard icon={<FiHeart />} title="Saved" value="0" color="text-red-500 bg-red-50" />
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

function BookingsTab({ role, bookings }) {
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

function ReviewsTab({ role, reviews }) {
    return (
        <div className="space-y-6">
            <h1 className="text-2xl font-bold text-slate-900">Reviews {role === 'host' ? 'Received' : 'Written'}</h1>
            <div className="space-y-4">
                {reviews?.length > 0 ? reviews.map(review => (
                    <div key={review.id} className="bg-white border border-slate-200 rounded-xl p-6">
                        <div className="flex justify-between items-start mb-3">
                            <div>
                                <h3 className="font-bold text-slate-800">{role === 'host' ? (review.user?.name || 'Guest') : (review.listing?.title || 'Property')}</h3>
                                <p className="text-sm text-slate-500">{review.stay_date ? new Date(review.stay_date).toLocaleDateString() : new Date(review.created_at).toLocaleDateString()}</p>
                            </div>
                            <div className="flex text-amber-400 gap-0.5">
                                {[...Array(5)].map((_, i) => <FiStar key={i} className={`h-4 w-4 ${i < Math.round(review.overall_rating) ? 'fill-current' : 'text-slate-300'}`} />)}
                            </div>
                        </div>
                        <p className="text-slate-600 leading-relaxed">{review.comment}</p>
                    </div>
                )) : (
                    <div className="bg-white border border-slate-200 rounded-xl p-16 text-center">
                        <FiStar className="mx-auto text-4xl text-slate-300 mb-4" />
                        <h3 className="text-lg font-semibold text-slate-700">No reviews yet</h3>
                    </div>
                )}
            </div>
        </div>
    );
}

function MessagesTab({ messages, auth }) {
    return (
        <div className="space-y-6">
            <h1 className="text-2xl font-bold text-slate-900">Messages</h1>
            <div className="bg-white border border-slate-200 rounded-xl overflow-hidden min-h-[400px]">
                {messages?.length > 0 ? (
                    <div className="divide-y divide-slate-100">
                        {messages.map((msg, idx) => {
                            const otherPerson = msg.sender_id === auth.id ? msg.receiver : msg.sender;
                            return (
                                <div key={idx} className="p-4 hover:bg-slate-50 transition-colors cursor-pointer flex gap-4">
                                    <img src={`https://ui-avatars.com/api/?name=${otherPerson?.name}&background=random`} className="w-10 h-10 rounded-full flex-shrink-0" alt="User" />
                                    <div className="flex-1 min-w-0">
                                        <div className="flex justify-between items-center">
                                            <h4 className="font-semibold text-slate-800 text-sm">{otherPerson?.name}</h4>
                                            <span className="text-xs text-slate-400">{new Date(msg.created_at).toLocaleDateString()}</span>
                                        </div>
                                        <p className="text-sm text-slate-500 truncate mt-1">{msg.message || msg.body}</p>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                ) : (
                    <div className="p-16 text-center flex flex-col items-center justify-center h-full">
                        <FiMessageSquare className="text-4xl text-slate-300 mb-4" />
                        <h3 className="text-lg font-semibold text-slate-700">No messages yet</h3>
                        <p className="text-slate-500 mt-1 text-sm">Your conversations will appear here.</p>
                    </div>
                )}
            </div>
        </div>
    );
}

function SettingsTab({ user }) {
    const [subTab, setSubTab] = useState('profile');
    return (
        <div className="space-y-6">
            <h1 className="text-2xl font-bold text-slate-900">Account Settings</h1>
            <div className="flex border-b border-slate-200 mb-6">
                <button onClick={() => setSubTab('profile')} className={`px-4 py-3 font-medium text-sm border-b-2 transition-colors ${subTab === 'profile' ? 'border-brand text-brand' : 'border-transparent text-slate-500 hover:text-slate-700'}`}>Profile Info</button>
                <button onClick={() => setSubTab('password')} className={`px-4 py-3 font-medium text-sm border-b-2 transition-colors ${subTab === 'password' ? 'border-brand text-brand' : 'border-transparent text-slate-500 hover:text-slate-700'}`}>Change Password</button>
            </div>
            {subTab === 'profile' ? <ProfileForm user={user} /> : <PasswordForm />}
        </div>
    );
}

/* =========================================
   SHARED UI COMPONENTS
========================================= */

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

function ProfileForm({ user }) {
    const { data, setData, post, processing, errors } = useForm({ 
        name: user.name || '', 
        email: user.email || '', 
        phone: user.phone || '', 
        address: user.address || '',
        image: null // Required for file upload
    });

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData('image', file);
        }
    };

    const submit = (e) => {
        e.preventDefault();
        // forceFormData: true is MANDATORY for file uploads in Inertia
        post('/account/profile', { 
            forceFormData: true, 
            preserveScroll: true, 
            onSuccess: () => toast.success('Profile updated successfully!') 
        });
    };

    // Live preview of the selected image or fallback to existing image
    const imagePreview = data.image 
        ? URL.createObjectURL(data.image) 
        : (user.image_url || `https://ui-avatars.com/api/?name=${user.name}&background=0d9488&color=fff`);

    return (
        <form onSubmit={submit} className="bg-white border border-slate-200 rounded-xl p-6 space-y-6">
            
            {/* Image Upload Section */}
            <div>
                <label className="block text-sm font-semibold text-slate-700 mb-3">Profile Picture</label>
                <div className="flex items-center gap-6">
                    <img 
                        src={imagePreview} 
                        alt="Profile Preview" 
                        className="w-20 h-20 rounded-full object-cover border-2 border-slate-200 bg-slate-50"
                    />
                    <div>
                        <label className="cursor-pointer bg-white border border-slate-300 text-slate-700 px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors inline-flex items-center gap-2 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Choose Photo
                            <input type="file" className="hidden" accept="image/jpeg, image/png, image/webp" onChange={handleImageChange} />
                        </label>
                        <p className="text-xs text-slate-500 mt-2">JPG, PNG or WebP. Maximum size 2MB.</p>
                        {errors.image && <p className="text-red-500 text-xs mt-1 font-medium">{errors.image}</p>}
                    </div>
                </div>
            </div>

            <div className="border-t border-slate-100 pt-2"></div>

            {/* Text Inputs */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                <Input label="Full Name" value={data.name} onChange={e => setData('name', e.target.value)} error={errors.name} />
                <Input label="Email Address" type="email" value={data.email} onChange={e => setData('email', e.target.value)} error={errors.email} />
            </div>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                <Input label="Phone Number" value={data.phone} onChange={e => setData('phone', e.target.value)} error={errors.phone} />
                <Input label="Address" value={data.address} onChange={e => setData('address', e.target.value)} error={errors.address} />
            </div>

            <div className="pt-2">
                <button 
                    type="submit" 
                    disabled={processing} 
                    className="bg-brand text-white px-6 py-2.5 rounded-lg font-semibold transition-colors hover:bg-brand/90 disabled:opacity-70 disabled:cursor-not-allowed flex items-center gap-2"
                >
                    {processing && (
                        <svg className="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    )}
                    {processing ? 'Saving...' : 'Save Changes'}
                </button>
            </div>
        </form>
    );
}

function PasswordForm() {
    const { data, setData, post, processing, errors, reset } = useForm({ current_password: '', password: '', password_confirmation: '' });
    const submit = (e) => {
        e.preventDefault();
        post('/account/password', { preserveScroll: true, onSuccess: () => { toast.success('Password changed successfully!'); reset(); } });
    };
    return (
        <form onSubmit={submit} className="bg-white border border-slate-200 rounded-xl p-6 space-y-5">
            <Input label="Current Password" type="password" value={data.current_password} onChange={e => setData('current_password', e.target.value)} error={errors.current_password} />
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                <Input label="New Password" type="password" value={data.password} onChange={e => setData('password', e.target.value)} error={errors.password} />
                <Input label="Confirm New Password" type="password" value={data.password_confirmation} onChange={e => setData('password_confirmation', e.target.value)} error={errors.password_confirmation} />
            </div>
            <div className="pt-2">
                <button type="submit" disabled={processing} className="bg-brand text-white px-6 py-2.5 rounded-lg font-semibold transition-colors hover:bg-brand/90 disabled:opacity-70 disabled:cursor-not-allowed">
                    {processing ? 'Updating...' : 'Update Password'}
                </button>
            </div>
        </form>
    );
}

function Input({ label, type = "text", value, onChange, error }) {
    return (
        <div>
            <label className="block text-sm font-semibold text-slate-700 mb-1.5">{label}</label>
            <input 
                type={type} 
                value={value} 
                onChange={onChange} 
                className={`w-full p-2.5 border rounded-lg outline-none transition-colors ${
                    error ? 'border-red-300 focus:border-red-500 focus:ring-1 focus:ring-red-500' : 'border-slate-300 focus:border-brand focus:ring-1 focus:ring-brand'
                }`} 
            />
            {error && <p className="text-red-500 text-xs mt-1.5 font-medium">{error}</p>}
        </div>
    );
}