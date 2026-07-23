import React from 'react';
import { Head } from '@inertiajs/react';
import FrontLayout from '../Layouts/FrontLayout';
import Breadcrumb from '../Components/Shared/Breadcrumb';
import { FiInfo } from 'react-icons/fi';

export default function CmsPage({ page, setting, metaTitle, metaDescription, metaKeywords, pageImage }) {
    const pageTitle = metaTitle || page?.title || 'Page';

    return (
        <>
            <Head title={pageTitle} />
            {metaDescription && (
                <Head>
                    <meta name="description" content={metaDescription} />
                </Head>
            )}
            {metaKeywords && (
                <Head>
                    <meta name="keywords" content={metaKeywords} />
                </Head>
            )}
            <FrontLayout>
                <Breadcrumb items={[{ title: 'Home', url: '/' }, { title: page?.title || 'Page', url: '' }]} />
                
                <section className="py-12 bg-white">
                    <div className="max-w-5xl mx-auto px-4">
                        
       
                        <div className="mb-8 text-center">
                            <h1 className="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                                {page?.title}
                            </h1>
                        </div>

                        {page?.short_content && (
                            <div className="mb-10 p-4 bg-slate-50 border-l-4 border-brand rounded-r-lg flex items-start gap-3 shadow-sm">
                                <FiInfo className="w-5 h-5 text-brand flex-shrink-0 mt-0.5" />
                                <p className="text-slate-600 font-medium text-sm sm:text-base leading-relaxed">
                                    {page.short_content}
                                </p>
                            </div>
                        )}

     
                        {pageImage && (
                            <div className="mb-10 rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                                <img src={pageImage} alt={page?.title} className="w-full h-64 sm:h-80 object-cover" />
                            </div>
                        )}

         
                        {page?.content && (
                            <div className="mb-12 prose prose-lg max-w-none prose-headings:text-slate-900 prose-p:text-slate-600 prose-a:text-brand prose-li:text-slate-600 prose-strong:text-slate-800">
                                <div dangerouslySetInnerHTML={{ __html: page.content }} />
                            </div>
                        )}

                    </div>
                </section>
            </FrontLayout>
        </>
    );
}