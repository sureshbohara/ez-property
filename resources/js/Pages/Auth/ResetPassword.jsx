import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import toast from 'react-hot-toast';
export default function ResetPassword({ token, email }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        token: token,
        email: email || '',
        password: '',
        password_confirmation: '',
    });
    const submit = (e) => {
        e.preventDefault();
        post('/reset-password', {
            onFinish: () => reset('password', 'password_confirmation'),
            onSuccess: (page) => {
                if (page.props.flash.success) {
                    toast.success(page.props.flash.success);
                }
            },
            onError: (errors) => {
                if (errors.email) {
                    toast.error(errors.email);
                } else {
                    toast.error('Failed to reset password. Please try again.');
                }
            },
        });
    };
    return (
        <>
            <Head title="Reset Password - EzProperty" />
            
            <div className="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-slate-100 to-slate-200 px-4 py-12">
                
                <Link 
                    href="/login" 
                    className="absolute top-6 left-6 inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-brand transition-colors group z-10"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Login
                </Link>

                <div className="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                    <div className="text-center mb-8">
                        <div className="inline-flex items-center justify-center w-12 h-12 bg-brand/10 rounded-xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h1 className="text-2xl font-bold text-slate-900">Reset Password</h1>
                        <p className="text-slate-500 text-sm mt-1">Enter your new password below.</p>
                    </div>

                    <form onSubmit={submit} className="space-y-5">
                        <div>
                            <label className="block text-sm font-medium text-slate-700 mb-2">Email address</label>
                            <input
                                type="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                className="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition"
                                placeholder="you@example.com"
                                required
                            />
                            {errors.email && <p className="text-red-500 text-xs mt-2">{errors.email}</p>}
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 mb-2">New Password</label>
                            <input
                                type="password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                className="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition"
                                placeholder="••••••••"
                                required
                            />
                            {errors.password && <p className="text-red-500 text-xs mt-2">{errors.password}</p>}
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 mb-2">Confirm Password</label>
                            <input
                                type="password"
                                value={data.password_confirmation}
                                onChange={(e) => setData('password_confirmation', e.target.value)}
                                className="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition"
                                placeholder="••••••••"
                                required
                            />
                            {errors.password_confirmation && <p className="text-red-500 text-xs mt-2">{errors.password_confirmation}</p>}
                        </div>

                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-brand hover:bg-brand-hover text-white font-bold py-3.5 rounded-xl transition-all active:scale-[0.98] disabled:opacity-50 flex items-center justify-center gap-2 shadow-sm hover:shadow-md"
                        >
                            {processing ? (
                                <>
                                    <svg className="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                        <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Resetting...
                                </>
                            ) : 'Reset Password'}
                        </button>
                    </form>
                </div>
            </div>
        </>
    );
}