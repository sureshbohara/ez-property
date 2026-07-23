import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import toast from 'react-hot-toast';

export default function ForgotPassword() {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
    });
    const submit = (e) => {
        e.preventDefault();
        post('/forgot-password', {
            onFinish: () => reset('email'),
            onSuccess: (page) => {
                if (page.props.flash.success) {
                    toast.success(page.props.flash.success);
                }
            },
            onError: (errors) => {
                if (errors.email) {
                    toast.error(errors.email);
                } else {
                    toast.error('An error occurred. Please try again.');
                }
            },
        });
    };
    return (
        <>
            <Head title="Forgot Password - EzProperty" />
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
                                <path strokeLinecap="round" strokeLinejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <h1 className="text-2xl font-bold text-slate-900">Forgot Password</h1>
                        <p className="text-slate-500 text-sm mt-1">No worries, we'll send you reset instructions.</p>
                    </div>

                    <form onSubmit={submit} className="space-y-5">
                        <div>
                            <label className="block text-sm font-medium text-slate-700 mb-2">Email address</label>
                            <div className="relative">
                                <span className="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <input
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    className="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition"
                                    placeholder="you@example.com"
                                    required
                                />
                            </div>
                            {errors.email && <p className="text-red-500 text-xs mt-2">{errors.email}</p>}
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
                                    Sending...
                                </>
                            ) : 'Send Reset Link'}
                        </button>
                    </form>

                    <p className="text-center text-sm text-slate-600 mt-8">
                        Remember your password?{' '}
                        <Link href="/login" className="text-brand font-semibold hover:underline">Log in</Link>
                    </p>
                </div>
            </div>
        </>
    );
}