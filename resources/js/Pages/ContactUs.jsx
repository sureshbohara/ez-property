import React from 'react';
import { Head, useForm, usePage } from '@inertiajs/react';
import FrontLayout from '@/Layouts/FrontLayout';
import Breadcrumb from '../Components/Shared/Breadcrumb';
import { FiMail, FiPhone, FiMapPin, FiSend, FiLoader, FiClock } from 'react-icons/fi';
import toast from 'react-hot-toast'; 

export default function ContactUs({ page, metaTitle }) {
    const { setting } = usePage().props;
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '', email: '', subject: '', message: ''
    });
    const submit = (e) => {
        e.preventDefault();
        post('/contact-submit', {
            preserveScroll: true,
            onSuccess: (page) => {
                if (page.props.flash?.success) {
                    toast.success(page.props.flash.success);
                    reset();
                } 
                else if (page.props.flash?.error) {
                    toast.error(page.props.flash.error);
                }
            },
            onError: (errors) => {
                toast.error('Please check the form for errors and try again.');
            }
        });
    };

    const contactInfo = [
        setting?.address && { icon: <FiMapPin />, title: 'Our Location', text: setting.address },
        setting?.email && { icon: <FiMail />, title: 'Email Us', text: setting.email },
        setting?.phone && { icon: <FiPhone />, title: 'Call Us', text: setting.phone },
        setting?.work_hours && { icon: <FiClock />, title: 'Office Hours', text: setting.work_hours },
    ].filter(Boolean); 

    return (
        <>
            <Head title={metaTitle || 'Contact Us - EzProperty'} />
            <FrontLayout>
                <Breadcrumb items={[{ title: 'Home', url: '/' }, { title: 'Contact Us', url: '' }]} />
                
                <div className="bg-white min-h-screen">
                    <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-4 py-8">
                        
                        <div className="text-center mb-12">
                            <h1 className="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">Get in Touch</h1>
                            <p className="text-lg text-slate-500 leading-relaxed font-light max-w-2xl mx-auto">Have questions or feedback? We'd love to hear from you. Fill out the form below and our team will get back to you.</p>
                        </div>

                        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            
                            <div className="lg:col-span-1 space-y-4">
                                {contactInfo.map((info, index) => (
                                    <div key={index} className="flex items-start gap-4 p-5 border border-slate-100 rounded-xl bg-slate-50">
                                        <div className="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-brand flex-shrink-0">{info.icon}</div>
                                        <div>
                                            <h3 className="font-bold text-slate-800 text-sm mb-1">{info.title}</h3>
                                            <p className="text-slate-500 text-sm">{info.text}</p>
                                        </div>
                                    </div>
                                ))}
                            </div>

                            <div className="lg:col-span-2">
                                <form onSubmit={submit} className="space-y-5 p-6 sm:p-8 border border-slate-200 rounded-xl shadow-sm">
                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <div>
                                            <label className="block text-sm font-semibold text-slate-700 mb-1">Name</label>
                                            <input type="text" value={data.name} onChange={(e) => setData('name', e.target.value)} className="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition-all" placeholder="John Doe" />
                                            {errors.name && <p className="text-xs text-red-500 mt-1">{errors.name}</p>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                                            <input type="email" value={data.email} onChange={(e) => setData('email', e.target.value)} className="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition-all" placeholder="john@example.com" />
                                            {errors.email && <p className="text-xs text-red-500 mt-1">{errors.email}</p>}
                                        </div>
                                    </div>

                                    <div>
                                        <label className="block text-sm font-semibold text-slate-700 mb-1">Subject</label>
                                        <input type="text" value={data.subject} onChange={(e) => setData('subject', e.target.value)} className="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition-all" placeholder="How can we help?" />
                                        {errors.subject && <p className="text-xs text-red-500 mt-1">{errors.subject}</p>}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-semibold text-slate-700 mb-1">Message</label>
                                        <textarea rows="5" value={data.message} onChange={(e) => setData('message', e.target.value)} className="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition-all resize-none" placeholder="Write your message here..."></textarea>
                                        {errors.message && <p className="text-xs text-red-500 mt-1">{errors.message}</p>}
                                    </div>

                                    <div className="flex">
                                        <button type="submit" disabled={processing} className="px-6 py-3 bg-brand text-white rounded-lg font-semibold hover:bg-brand-hover transition-colors text-sm flex items-center gap-2 disabled:opacity-50">
                                            {processing ? <><FiLoader className="animate-spin" /> Sending...</> : <><FiSend /> Send Message</>}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {setting?.google_map && (
                            <div className="mt-12 rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                                <iframe src={setting.google_map} width="100%" height="400" style={{ border: 0 }} allowFullScreen="" loading="lazy" referrerPolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        )}

                    </div>
                </div>
            </FrontLayout>
        </>
    );
}