import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import toast from 'react-hot-toast';

export default function Create({ categories, amenities, propertyTypes, cancellationPolicies }) {
    const { data, setData, post, processing, errors } = useForm({
        title: '',
        description: '',
        address: '',
        city: '',
        province: '',
        country: 'Nepal',
        latitude: '',
        longitude: '',
        highlight_key: [],
        guests: 1,
        bedrooms: 1,
        beds: 1,
        bathrooms: 1,
        base_price: '',
        cleaning_fee: '',
        minimum_nights: 1,
        instant_bookable: false,
        image: null,
        gallery: [],
        category_id: '',
        listing_type: '',
        cancellation_policy: '',
        order_level: 0,
        status: true,
        amenities: [],
    });

    const [imagePreview, setImagePreview] = useState(null);

    const submit = (e) => {
        e.preventDefault();
        post('/properties', {
            onSuccess: (page) => {
                if (page.props.flash.success) {
                    toast.success(page.props.flash.success);
                }
            },
            onError: (errors) => {
                toast.error('Please fix the errors in the form.');
            },
        });
    };

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        setData('image', file);
        if (file) {
            const reader = new FileReader();
            reader.onload = (ev) => setImagePreview(ev.target.result);
            reader.readAsDataURL(file);
        } else {
            setImagePreview(null);
        }
    };

    const handleGalleryChange = (e) => {
        const files = Array.from(e.target.files);
        setData('gallery', files);
    };

    const addHighlight = () => setData('highlight_key', [...data.highlight_key, '']);
    const updateHighlight = (i, value) => {
        const highlights = [...data.highlight_key];
        highlights[i] = value;
        setData('highlight_key', highlights);
    };
    const removeHighlight = (i) => {
        setData('highlight_key', data.highlight_key.filter((_, index) => index !== i));
    };

    const toggleAmenity = (id) => {
        const currentAmenities = data.amenities;
        if (currentAmenities.includes(id)) {
            setData('amenities', currentAmenities.filter(a => a !== id));
        } else {
            setData('amenities', [...currentAmenities, id]);
        }
    };

    return (
        <>
            <Head title="List your property" />
            
            <div className="relative min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 px-4 py-6">
                <div className="max-w-7xl mx-auto">
                    <Link 
                        href="/dashboard" 
                        className="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-brand transition-colors group mb-8"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Dashboard
                    </Link>

                    <div className="bg-white rounded-2xl p-6 sm:p-8 mb-4">
                        <h1 className="text-2xl font-bold text-slate-900">List your property</h1>
                        <p className="text-slate-500 text-sm mt-1">Provide accurate details to attract more guests.</p>
                    </div>

                    <form onSubmit={submit} className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        
                     
                        <div className="lg:col-span-2">
                            <div className="bg-white rounded-xl shadow-sm border border-slate-100 p-6 sm:p-8">
                                
                                {/* Basic Information */}
                                <h5 className="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Basic Information</h5>
                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-slate-700 mb-1">Listing Title <span className="text-red-500">*</span></label>
                                    <input
                                        type="text"
                                        value={data.title}
                                        onChange={(e) => setData('title', e.target.value)}
                                        className="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition"
                                        placeholder="e.g., Cozy Apartment in Thamel"
                                    />
                                    {errors.title && <p className="text-red-500 text-xs mt-1">{errors.title}</p>}
                                </div>
                                <div className="mb-6">
                                    <label className="block text-sm font-medium text-slate-700 mb-1">Full Description</label>
                                    <textarea
                                        rows="5"
                                        value={data.description}
                                        onChange={(e) => setData('description', e.target.value)}
                                        className="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition"
                                        placeholder="Describe the property..."
                                    ></textarea>
                                    {errors.description && <p className="text-red-500 text-xs mt-1">{errors.description}</p>}
                                </div>

                                <hr className="border-slate-100 my-6" />

                                {/* Location */}
                                <h5 className="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Location</h5>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <div className="md:col-span-2">
                                        <label className="block text-sm font-medium text-slate-700 mb-1">Street Address <span className="text-red-500">*</span></label>
                                        <input type="text" value={data.address} onChange={(e) => setData('address', e.target.value)} className="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" />
                                        {errors.address && <p className="text-red-500 text-xs mt-1">{errors.address}</p>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-slate-700 mb-1">City <span className="text-red-500">*</span></label>
                                        <input type="text" value={data.city} onChange={(e) => setData('city', e.target.value)} className="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" />
                                        {errors.city && <p className="text-red-500 text-xs mt-1">{errors.city}</p>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-slate-700 mb-1">Province/State <span className="text-red-500">*</span></label>
                                        <input type="text" value={data.province} onChange={(e) => setData('province', e.target.value)} className="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" />
                                        {errors.province && <p className="text-red-500 text-xs mt-1">{errors.province}</p>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-slate-700 mb-1">Country <span className="text-red-500">*</span></label>
                                        <input type="text" value={data.country} onChange={(e) => setData('country', e.target.value)} className="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" />
                                        {errors.country && <p className="text-red-500 text-xs mt-1">{errors.country}</p>}
                                    </div>
                                    <div className="grid grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-slate-700 mb-1">Latitude</label>
                                            <input type="number" step="any" value={data.latitude} onChange={(e) => setData('latitude', e.target.value)} className="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" />
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-slate-700 mb-1">Longitude</label>
                                            <input type="number" step="any" value={data.longitude} onChange={(e) => setData('longitude', e.target.value)} className="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition" />
                                        </div>
                                    </div>
                                </div>

                                <hr className="border-slate-100 my-6" />

                                {/* Amenities & Highlights */}
                                <h5 className="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Amenities & Highlights</h5>
                                <div className="mb-6">
                                    <label className="block text-sm font-medium text-slate-700 mb-2">Highlights</label>
                                    <div className="space-y-2">
                                        {data.highlight_key.map((highlight, i) => (
                                            <div key={i} className="flex items-center gap-2">
                                                <input
                                                    type="text"
                                                    value={highlight}
                                                    onChange={(e) => updateHighlight(i, e.target.value)}
                                                    className="flex-1 px-4 py-2 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition"
                                                    placeholder="Highlight point"
                                                />
                                                <button
                                                    type="button"
                                                    onClick={() => removeHighlight(i)}
                                                    className="p-2.5 text-red-500 bg-red-50 rounded-lg hover:bg-red-100 transition"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2"><path strokeLinecap="round" strokeLinejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </div>
                                        ))}
                                    </div>
                                    <button
                                        type="button"
                                        onClick={addHighlight}
                                        className="mt-2 inline-flex items-center gap-2 text-sm text-brand font-semibold hover:underline"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2"><path strokeLinecap="round" strokeLinejoin="round" d="M12 4v16m8-8H4" /></svg>
                                        Add Highlight
                                    </button>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-slate-700 mb-2">Amenities</label>
                                    <div className="grid grid-cols-2 md:grid-cols-3 gap-3">
                                        {amenities.map((amenity) => (
                                            <label key={amenity.id} className={`flex items-center gap-2 p-3 border rounded-lg cursor-pointer transition ${data.amenities.includes(amenity.id) ? 'bg-brand/5 border-brand text-brand font-medium' : 'border-slate-200 text-slate-700 hover:bg-slate-50'}`}>
                                                <input
                                                    type="checkbox"
                                                    checked={data.amenities.includes(amenity.id)}
                                                    onChange={() => toggleAmenity(amenity.id)}
                                                    className="w-4 h-4 rounded text-brand border-slate-300 focus:ring-brand/30"
                                                />
                                                <span className="text-sm">{amenity.name}</span>
                                            </label>
                                        ))}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Right Column - Single Card */}
                        <div className="lg:col-span-1">
                            <div className="bg-white rounded-xl shadow-sm border border-slate-100 p-6 sm:p-8">
                                
                                {/* Capacity & Pricing */}
                                <h5 className="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Capacity & Pricing</h5>
                                <div className="grid grid-cols-2 gap-3 mb-4">
                                    <div>
                                        <label className="block text-sm text-slate-600 mb-1">Guests</label>
                                        <input type="number" min="1" value={data.guests} onChange={(e) => setData('guests', e.target.value)} className="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none" />
                                    </div>
                                    <div>
                                        <label className="block text-sm text-slate-600 mb-1">Bedrooms</label>
                                        <input type="number" min="0" value={data.bedrooms} onChange={(e) => setData('bedrooms', e.target.value)} className="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none" />
                                    </div>
                                    <div>
                                        <label className="block text-sm text-slate-600 mb-1">Beds</label>
                                        <input type="number" min="0" value={data.beds} onChange={(e) => setData('beds', e.target.value)} className="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none" />
                                    </div>
                                    <div>
                                        <label className="block text-sm text-slate-600 mb-1">Bathrooms</label>
                                        <input type="number" step="0.5" min="0" value={data.bathrooms} onChange={(e) => setData('bathrooms', e.target.value)} className="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none" />
                                    </div>
                                </div>

                                <div className="mb-3">
                                    <label className="block text-sm text-slate-600 mb-1">Base Price (per night) <span className="text-red-500">*</span></label>
                                    <input type="number" step="0.01" min="0" value={data.base_price} onChange={(e) => setData('base_price', e.target.value)} className="w-full px-3 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none" />
                                    {errors.base_price && <p className="text-red-500 text-xs mt-1">{errors.base_price}</p>}
                                </div>
                                
                                <div className="mb-3">
                                    <label className="block text-sm text-slate-600 mb-1">Cleaning Fee</label>
                                    <input type="number" step="0.01" min="0" value={data.cleaning_fee} onChange={(e) => setData('cleaning_fee', e.target.value)} className="w-full px-3 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none" />
                                </div>

                                <div className="mb-4">
                                    <label className="block text-sm text-slate-600 mb-1">Minimum Nights</label>
                                    <input type="number" min="1" value={data.minimum_nights} onChange={(e) => setData('minimum_nights', e.target.value)} className="w-full px-3 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none" />
                                </div>

                                <label className="flex items-center gap-2 cursor-pointer mb-6">
                                    <input type="checkbox" checked={data.instant_bookable} onChange={(e) => setData('instant_bookable', e.target.checked)} className="w-4 h-4 rounded text-brand border-slate-300 focus:ring-brand/30" />
                                    <span className="text-sm text-slate-700 font-medium">Instant Bookable</span>
                                </label>

                                <hr className="border-slate-100 my-6" />

                                {/* Media Upload */}
                                <h5 className="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Media</h5>
                                
                                <label className="block text-sm font-medium text-slate-700 mb-1">Cover Image</label>
                                <input 
                                    type="file" 
                                    accept="image/*" 
                                    onChange={handleImageChange} 
                                    className="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand/10 file:text-brand hover:file:bg-brand/20 cursor-pointer mb-3"
                                />
                                {imagePreview && (
                                    <div className="mt-2 mb-4">
                                        <img src={imagePreview} className="w-full h-32 object-cover rounded-lg border" alt="Preview" />
                                    </div>
                                )}

                                <div className="mb-6">
                                    <label className="block text-sm font-medium text-slate-700 mb-1 mt-3">Gallery Images</label>
                                    <input 
                                        type="file" 
                                        accept="image/*" 
                                        multiple 
                                        onChange={handleGalleryChange} 
                                        className="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer"
                                    />
                                </div>

                                <hr className="border-slate-100 my-6" />

                                {/* Settings */}
                                <h5 className="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3 mb-4">Settings</h5>
                                
                                <div className="mb-3">
                                    <label className="block text-sm font-medium text-slate-700 mb-1">Category</label>
                                    <select value={data.category_id} onChange={(e) => setData('category_id', e.target.value)} className="w-full px-3 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none bg-white">
                                        <option value="">Select Category</option>
                                        {categories.map((cat) => (
                                            <option key={cat.id} value={cat.id}>{cat.name}</option>
                                        ))}
                                    </select>
                                </div>

                                <div className="mb-3">
                                    <label className="block text-sm font-medium text-slate-700 mb-1">Property Type <span className="text-red-500">*</span></label>
                                    <select value={data.listing_type} onChange={(e) => setData('listing_type', e.target.value)} className="w-full px-3 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none bg-white">
                                        <option value="" disabled>Select Type</option>
                                        {Object.entries(propertyTypes).map(([value, label]) => (
                                            <option key={value} value={value}>{label}</option>
                                        ))}
                                    </select>
                                    {errors.listing_type && <p className="text-red-500 text-xs mt-1">{errors.listing_type}</p>}
                                </div>

                                <div className="mb-6">
                                    <label className="block text-sm font-medium text-slate-700 mb-1">Cancellation Policy <span className="text-red-500">*</span></label>
                                    <select value={data.cancellation_policy} onChange={(e) => setData('cancellation_policy', e.target.value)} className="w-full px-3 py-2.5 rounded-lg border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none bg-white">
                                        <option value="" disabled>Select Policy</option>
                                        {Object.entries(cancellationPolicies).map(([value, label]) => (
                                            <option key={value} value={value}>{label}</option>
                                        ))}
                                    </select>
                                    {errors.cancellation_policy && <p className="text-red-500 text-xs mt-1">{errors.cancellation_policy}</p>}
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full bg-brand hover:bg-brand-hover text-white font-bold py-3 rounded-xl transition-all active:scale-[0.98] disabled:opacity-50 flex items-center justify-center gap-2 shadow-sm hover:shadow-md"
                                >
                                    {processing ? (
                                        <>
                                            <svg className="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                                <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Saving...
                                        </>
                                    ) : 'List Property'}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}