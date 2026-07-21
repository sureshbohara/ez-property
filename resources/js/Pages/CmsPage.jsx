import React from 'react';
import { Head } from '@inertiajs/react';
import FrontLayout from '@/Layouts/FrontLayout';
import Breadcrumb from '../Components/Shared/Breadcrumb';

export default function CmsPage({ page, metaTitle, metaDescription, metaKeywords }) {
    const pageTitle = page?.title || 'Page';

    const updatedDate = page?.updated_at 
        ? new Date(page.updated_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })
        : null;

    return (
        <>
            <Head title={metaTitle || pageTitle}>
                {metaDescription && <meta name="description" content={metaDescription} />}
                {metaKeywords && <meta name="keywords" content={metaKeywords} />}
            </Head>
            
            <FrontLayout>
                
                <Breadcrumb items={[{ title: 'Home', url: '/' }, { title: pageTitle, url: '' }]} />
                
                <div className="bg-white min-h-screen">
                    <div className="max-w-7xl mx-auto px-3 sm:px-4 lg:px-3 py-4 sm:py-5">
                        
    
                        <div className="mb-10 border-b border-slate-200 pb-4">
                            <h1 className="text-2xl sm:text-2xl font-extrabold text-slate-900 tracking-tight mb-4">
                                {pageTitle}
                            </h1>
                            
                            {page?.short_content && (
                                <p className="text-lg sm:text-xl text-slate-500 leading-relaxed font-light">
                                    {page.short_content}
                                </p>
                            )}
                        </div>

                   
                        {page?.content && (
                            <article 
                                className="prose prose-lg max-w-none 
                                           prose-headings:text-slate-800 prose-headings:font-bold prose-headings:tracking-tight
                                           prose-h2:text-2xl prose-h2:mt-10 prose-h2:mb-4
                                           prose-h3:text-xl prose-h3:mt-6 prose-h3:mb-3
                                           prose-p:text-slate-600 prose-p:leading-relaxed prose-p:my-4
                                           prose-ul:my-4 prose-li:text-slate-600 prose-li:my-2 prose-ul:list-disc prose-ul:pl-6
                                           prose-a:text-brand prose-a:no-underline hover:prose-a:underline
                                           prose-strong:text-slate-800 prose-strong:font-semibold"
                                dangerouslySetInnerHTML={{ __html: page.content }} 
                            />
                        )}

            
                        {updatedDate && (
                            <div className="mt-12 pt-8 border-t border-slate-200 text-center">
                                <p className="text-sm text-slate-400">
                                    Last updated: {updatedDate}
                                </p>
                            </div>
                        )}

                    </div>
                </div>
            </FrontLayout>
        </>
    );
}