import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';
import toast from 'react-hot-toast';
import { FiUpload } from 'react-icons/fi';

export default function ProfileForm({ user }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: user?.name || '',
        email: user?.email || '',
        phone: user?.phone || '',
        address: user?.address || '',
        gender: user?.gender || '',
        details: user?.details || '',
        image: null,
    });

    const [imagePreview, setImagePreview] = useState(user?.image_url || null);

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData('image', file);
            const reader = new FileReader();
            reader.onload = (ev) => setImagePreview(ev.target.result);
            reader.readAsDataURL(file);
        }
    };

    const submit = (e) => {
        e.preventDefault();
        post('/account/profile', {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Profile updated successfully!');
                reset('image');
            },
            onError: () => toast.error('Please fix the errors in the form.')
        });
    };

    const displayImage = data.image ? URL.createObjectURL(data.image) : (user?.image_url || `https://ui-avatars.com/api/?name=${data.name}&background=0d9488&color=fff`);

    return (
        <form onSubmit={submit} className="bg-white border border-slate-200 rounded-xl p-6 space-y-6">
            <div>
                <label className="block text-sm font-semibold text-slate-700 mb-3">Profile Picture</label>
                <div className="flex items-center gap-6">
                    <img src={displayImage} alt="Profile" className="w-20 h-20 rounded-full object-cover border-2 border-slate-200 bg-slate-50" />
                    <div>
                        <label className="cursor-pointer bg-white border border-slate-300 text-slate-700 px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors inline-flex items-center gap-2 shadow-sm">
                            <FiUpload className="w-4 h-4" /> Choose Photo
                            <input type="file" className="hidden" accept="image/jpeg, image/png, image/webp" onChange={handleImageChange} />
                        </label>
                        <p className="text-xs text-slate-500 mt-2">JPG, PNG or WebP. Maximum size 2MB.</p>
                        {errors.image && <p className="text-red-500 text-xs mt-1 font-medium">{errors.image}</p>}
                    </div>
                </div>
            </div>

            <div className="border-t border-slate-100 pt-2"></div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                <Input label="Full Name" value={data.name} onChange={e => setData('name', e.target.value)} error={errors.name} />
                <Input label="Email Address" type="email" value={data.email} onChange={e => setData('email', e.target.value)} error={errors.email} />
            </div>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                <Input label="Phone Number" value={data.phone} onChange={e => setData('phone', e.target.value)} error={errors.phone} />
                <div>
                    <label className="block text-sm font-semibold text-slate-700 mb-1.5">Gender</label>
                    <select value={data.gender} onChange={e => setData('gender', e.target.value)} className={`w-full p-2.5 border rounded-lg outline-none transition-colors bg-white ${errors.gender ? 'border-red-300 focus:border-red-500 focus:ring-1 focus:ring-red-500' : 'border-slate-300 focus:border-brand focus:ring-1 focus:ring-brand'}`}>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    {errors.gender && <p className="text-red-500 text-xs mt-1.5 font-medium">{errors.gender}</p>}
                </div>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-1 gap-5">
                <Input label="Address" value={data.address} onChange={e => setData('address', e.target.value)} error={errors.address} />
               
            </div>


             <div>
                    <label className="block text-sm font-semibold text-slate-700 mb-1.5">About / Details</label>
                    <textarea rows="3" value={data.details} onChange={e => setData('details', e.target.value)} className={`w-full p-2.5 border rounded-lg outline-none transition-colors ${errors.details ? 'border-red-300 focus:border-red-500 focus:ring-1 focus:ring-red-500' : 'border-slate-300 focus:border-brand focus:ring-1 focus:ring-brand'}`} placeholder="Tell us a little about yourself..."></textarea>
                    {errors.details && <p className="text-red-500 text-xs mt-1.5 font-medium">{errors.details}</p>}
                </div>

            <div className="pt-2">
                <button type="submit" disabled={processing} className="bg-brand text-white px-6 py-2.5 rounded-lg font-semibold transition-colors hover:bg-brand/90 disabled:opacity-70 disabled:cursor-not-allowed flex items-center gap-2">
                    {processing && <svg className="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle><path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>}
                    {processing ? 'Saving...' : 'Save Changes'}
                </button>
            </div>
        </form>
    );
}

function Input({ label, type = "text", value, onChange, error }) {
    return (
        <div>
            <label className="block text-sm font-semibold text-slate-700 mb-1.5">{label}</label>
            <input type={type} value={value} onChange={onChange} className={`w-full p-2.5 border rounded-lg outline-none transition-colors ${error ? 'border-red-300 focus:border-red-500 focus:ring-1 focus:ring-red-500' : 'border-slate-300 focus:border-brand focus:ring-1 focus:ring-brand'}`} />
            {error && <p className="text-red-500 text-xs mt-1.5 font-medium">{error}</p>}
        </div>
    );
}