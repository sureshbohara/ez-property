import React, { useState } from 'react';
import ProfileForm from './ProfileForm';
import PasswordForm from './PasswordForm';

export default function Settings({ user }) {
    const [subTab, setSubTab] = useState('profile');

    return (
        <div className="space-y-6">
            <h1 className="text-2xl font-bold text-slate-900">Account Settings</h1>
            <div className="flex border-b border-slate-200 mb-6">
                <button 
                    onClick={() => setSubTab('profile')} 
                    className={`px-4 py-3 font-medium text-sm border-b-2 transition-colors ${subTab === 'profile' ? 'border-brand text-brand' : 'border-transparent text-slate-500 hover:text-slate-700'}`}
                >
                    Profile Info
                </button>
                <button 
                    onClick={() => setSubTab('password')} 
                    className={`px-4 py-3 font-medium text-sm border-b-2 transition-colors ${subTab === 'password' ? 'border-brand text-brand' : 'border-transparent text-slate-500 hover:text-slate-700'}`}
                >
                    Change Password
                </button>
            </div>
            
            {subTab === 'profile' ? <ProfileForm user={user} /> : <PasswordForm />}
        </div>
    );
}