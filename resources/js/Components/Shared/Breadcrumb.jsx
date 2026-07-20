import React from 'react';
import { Link } from '@inertiajs/react';

export default function Breadcrumb({ items }) {
  return (
    <section className="bg-slate-50 border-b border-slate-200 py-4">
      <div className="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12">
        <nav aria-label="breadcrumb">
          <ol className="flex flex-wrap gap-2 text-sm list-none p-0 m-0">
            {items.map((item, index) => {
              const isLast = index === items.length - 1;
              return (
                <li key={index} className={`flex items-center ${isLast ? 'text-slate-600 font-medium' : 'text-slate-700'}`}>
                  {!isLast && item.url ? (
                    <>
                      <Link href={item.url} className="hover:text-brand hover:underline transition-colors">
                        {item.title}
                      </Link>
                      <span className="mx-2 text-slate-400">&gt;</span>
                    </>
                  ) : (
                    <span aria-current="page">{item.title}</span>
                  )}
                </li>
              );
            })}
          </ol>
        </nav>
      </div>
    </section>
  );
}