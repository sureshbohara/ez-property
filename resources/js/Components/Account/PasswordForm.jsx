import React from 'react';
import { useForm } from '@inertiajs/react';
import toast from 'react-hot-toast';
import { FiInfo } from 'react-icons/fi';

export default function PasswordForm() {
    const { data, setData, post, processing, errors, reset } = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post('/account/password', {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Password changed successfully!');
                reset();
            },
            onError: () => toast.error('Please check your current password and try again.')
        });
    };

    return (
        <form onSubmit={submit} className="bg-white border border-slate-200 rounded-xl p-6 space-y-6">
            <div>
                <label className="block text-sm font-semibold text-slate-700 mb-1.5">Current Password *</label>
                <input type="password" value={data.current_password} onChange={e => setData('current_password', e.target.value)} className={`w-full p-2.5 border rounded-lg outline-none transition-colors ${errors.current_password ? 'border-red-300 focus:border-red-500 focus:ring-1 focus:ring-red-500' : 'border-slate-300 focus:border-brand focus:ring-1 focus:ring-brand'}`} />
                {errors.current_password ? (
                    <p className="text-red-500 text-xs mt-1.5 font-medium">⚠️ {errors.current_password}</p>
                ) : (
                    <p className="text-slate-500 text-xs mt-1.5 flex items-center gap-1">
                        <FiInfo className="w-3.5 h-3.5 flex-shrink-0" /> Enter the password you currently use to log in.
                    </p>
                )}
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label className="block text-sm font-semibold text-slate-700 mb-1.5">New Password *</label>
                    <input type="password" value={data.password} onChange={e => setData('password', e.target.value)} className={`w-full p-2.5 border rounded-lg outline-none transition-colors ${errors.password ? 'border-red-300 focus:border-red-500 focus:ring-1 focus:ring-red-500' : 'border-slate-300 focus:border-brand focus:ring-1 focus:ring-brand'}`} minLength="6" />
                    {errors.password ? (
                        <p className="text-red-500 text-xs mt-1.5 font-medium">⚠️ {errors.password}</p>
                    ) : (
                        <p className="text-slate-500 text-xs mt-1.5 flex items-center gap-1">
                            <FiInfo className="w-3.5 h-3.5 flex-shrink-0" /> Minimum 6 characters.
                        </p>
                    )}
                </div>

                <div>
                    <label className="block text-sm font-semibold text-slate-700 mb-1.5">Confirm New Password *</label>
                    <input type="password" value={data.password_confirmation} onChange={e => setData('password_confirmation', e.target.value)} className={`w-full p-2.5 border rounded-lg outline-none transition-colors ${errors.password_confirmation ? 'border-red-300 focus:border-red-500 focus:ring-1 focus:ring-red-500' : 'border-slate-300 focus:border-brand focus:ring-1 focus:ring-brand'}`} />
                    {errors.password_confirmation && <p className="text-red-500 text-xs mt-1.5 font-medium">⚠️ {errors.password_confirmation}</p>}
                </div>
            </div>

            <div className="bg-teal-50 border border-teal-100 rounded-lg p-3 flex items-start gap-2">
                <FiInfo className="w-4 h-4 text-teal-600 mt-0.5 flex-shrink-0" />
                <p className="text-xs text-teal-700">
                    <strong>Security Tip:</strong> For maximum security, avoid using passwords that you use on other websites.
                </p>
            </div>

            <div className="pt-2">
                <button type="submit" disabled={processing} className="bg-brand text-white px-6 py-2.5 rounded-lg font-semibold transition-colors hover:bg-brand/90 disabled:opacity-70 disabled:cursor-not-allowed flex items-center gap-2">
                    {processing && <svg className="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle><path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>}
                    {processing ? 'Updating...' : 'Update Password'}
                </button>
            </div>
        </form>
    );
}