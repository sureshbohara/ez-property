import React from 'react';
import { Link } from '@inertiajs/react';

export default function FilterSection({ filter, selectedType }) {
    return (
        <section className="bg-white border-b border-slate-100 px-4 sm:px-6 lg:px-8 py-4 z-30 sticky top-[65px] md:top-[73px]">
            <div className="max-w-[1536px] mx-auto flex items-center gap-4">
                <div className="flex-1 overflow-x-auto hide-scrollbar fade-edges">
                    <div className="flex gap-3 min-w-max py-1 justify-start lg:justify-center">
                        {filter && Object.entries(filter).map(([key, type]) => (
                            <Link
                                key={key}
                                href={`/?type=${key}`}
                                preserveState
                                className={`flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition whitespace-nowrap ${
                                    selectedType === key 
                                        ? 'bg-brand text-white shadow-sm' 
                                        : 'text-slate-600 hover:bg-slate-50 border border-slate-200 hover:border-slate-300'
                                }`}
                            >
                                <i className={type.icon}></i> <span>{type.label}</span>
                            </Link>
                        ))}
                    </div>
                </div>
                <button className="shrink-0 flex items-center gap-2 px-4 py-2 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 hover:border-dark hover:shadow-sm transition bg-white">
                    <i className="fa-solid fa-sliders"></i> <span className="hidden sm:inline">Filters</span>
                </button>
            </div>
        </section>
    );
}