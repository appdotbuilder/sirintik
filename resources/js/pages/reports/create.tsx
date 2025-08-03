import AppLayout from '@/components/app-layout';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { FormEvent, useState } from 'react';

interface ReportTemplateField {
    id: number;
    field_name: string;
    field_key: string;
    field_type: string;
    field_options?: string[];
    is_required: boolean;
    sort_order: number;
    [key: string]: unknown;
}

interface ReportCategory {
    id: number;
    name: string;
    slug: string;
    template_fields: ReportTemplateField[];
    [key: string]: unknown;
}

interface Props {
    categories: ReportCategory[];
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Laporan', href: '/reports' },
    { title: 'Buat Laporan', href: '/reports/create' },
];

export default function ReportsCreate({ categories }: Props) {
    const [selectedCategory, setSelectedCategory] = useState<ReportCategory | null>(null);
    
    const { data, setData, post, processing, errors } = useForm({
        report_category_id: '',
        title: '',
        description: '',
        data: {} as Record<string, string | number>,
        report_date: new Date().toISOString().split('T')[0],
        status: 'draft',
    });

    const handleCategoryChange = (categoryId: string) => {
        const category = categories.find(c => c.id.toString() === categoryId);
        setSelectedCategory(category || null);
        setData('report_category_id', categoryId);
        setData('data', {}); // Reset form data when category changes
    };

    const handleFieldChange = (fieldKey: string, value: string | number) => {
        setData('data', {
            ...data.data,
            [fieldKey]: value,
        });
    };

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        post(route('reports.store'));
    };

    const getCategoryIcon = (categoryName: string) => {
        switch (categoryName.toLowerCase()) {
            case 'tanaman pangan':
                return '🌾';
            case 'hortikultura':
                return '🥬';
            case 'perkebunan':
                return '🌴';
            case 'peternakan':
                return '🐄';
            default:
                return '📊';
        }
    };

    const renderField = (field: ReportTemplateField) => {
        const commonProps = {
            id: field.field_key,
            required: field.is_required,
            className: "w-full rounded-lg border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white",
        };

        switch (field.field_type) {
            case 'textarea':
                return (
                    <textarea
                        {...commonProps}
                        rows={4}
                        value={data.data[field.field_key] || ''}
                        onChange={(e) => handleFieldChange(field.field_key, e.target.value)}
                        placeholder={`Masukkan ${field.field_name.toLowerCase()}`}
                    />
                );
            
            case 'select':
                return (
                    <select
                        {...commonProps}
                        value={data.data[field.field_key] || ''}
                        onChange={(e) => handleFieldChange(field.field_key, e.target.value)}
                    >
                        <option value="">Pilih {field.field_name}</option>
                        {field.field_options?.map((option) => (
                            <option key={option} value={option}>
                                {option}
                            </option>
                        ))}
                    </select>
                );
            
            case 'number':
                return (
                    <input
                        {...commonProps}
                        type="number"
                        step="0.01"
                        value={data.data[field.field_key] || ''}
                        onChange={(e) => handleFieldChange(field.field_key, e.target.value)}
                        placeholder={`Masukkan ${field.field_name.toLowerCase()}`}
                    />
                );
            
            case 'date':
                return (
                    <input
                        {...commonProps}
                        type="date"
                        value={data.data[field.field_key] || ''}
                        onChange={(e) => handleFieldChange(field.field_key, e.target.value)}
                    />
                );
            
            default:
                return (
                    <input
                        {...commonProps}
                        type="text"
                        value={data.data[field.field_key] || ''}
                        onChange={(e) => handleFieldChange(field.field_key, e.target.value)}
                        placeholder={`Masukkan ${field.field_name.toLowerCase()}`}
                    />
                );
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Buat Laporan" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
                {/* Header */}
                <div>
                    <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                        ➕ Buat Laporan Baru
                    </h1>
                    <p className="text-gray-600 dark:text-gray-400">
                        Isi formulir di bawah untuk membuat laporan pertanian
                    </p>
                </div>

                {/* Form */}
                <form onSubmit={handleSubmit} className="space-y-6">
                    <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                        <h2 className="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                            📋 Informasi Dasar
                        </h2>
                        
                        <div className="grid gap-4 md:grid-cols-2">
                            <div>
                                <label htmlFor="report_category_id" className="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kategori Laporan *
                                </label>
                                <select
                                    id="report_category_id"
                                    value={data.report_category_id}
                                    onChange={(e) => handleCategoryChange(e.target.value)}
                                    className="w-full rounded-lg border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    required
                                >
                                    <option value="">Pilih Kategori</option>
                                    {categories.map((category) => (
                                        <option key={category.id} value={category.id}>
                                            {getCategoryIcon(category.name)} {category.name}
                                        </option>
                                    ))}
                                </select>
                                {errors.report_category_id && (
                                    <p className="mt-1 text-sm text-red-600">{errors.report_category_id}</p>
                                )}
                            </div>

                            <div>
                                <label htmlFor="report_date" className="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal Laporan *
                                </label>
                                <input
                                    type="date"
                                    id="report_date"
                                    value={data.report_date}
                                    onChange={(e) => setData('report_date', e.target.value)}
                                    className="w-full rounded-lg border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    required
                                />
                                {errors.report_date && (
                                    <p className="mt-1 text-sm text-red-600">{errors.report_date}</p>
                                )}
                            </div>
                        </div>

                        <div className="mt-4">
                            <label htmlFor="title" className="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Judul Laporan *
                            </label>
                            <input
                                type="text"
                                id="title"
                                value={data.title}
                                onChange={(e) => setData('title', e.target.value)}
                                className="w-full rounded-lg border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Masukkan judul laporan"
                                required
                            />
                            {errors.title && (
                                <p className="mt-1 text-sm text-red-600">{errors.title}</p>
                            )}
                        </div>

                        <div className="mt-4">
                            <label htmlFor="description" className="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Deskripsi
                            </label>
                            <textarea
                                id="description"
                                rows={3}
                                value={data.description}
                                onChange={(e) => setData('description', e.target.value)}
                                className="w-full rounded-lg border border-gray-300 px-3 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Masukkan deskripsi laporan (opsional)"
                            />
                            {errors.description && (
                                <p className="mt-1 text-sm text-red-600">{errors.description}</p>
                            )}
                        </div>
                    </div>

                    {/* Dynamic Fields */}
                    {selectedCategory && selectedCategory.template_fields.length > 0 && (
                        <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                            <h2 className="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                                {getCategoryIcon(selectedCategory.name)} Data {selectedCategory.name}
                            </h2>
                            
                            <div className="grid gap-4 md:grid-cols-2">
                                {selectedCategory.template_fields
                                    .sort((a, b) => a.sort_order - b.sort_order)
                                    .map((field) => (
                                        <div key={field.id}>
                                            <label 
                                                htmlFor={field.field_key} 
                                                className="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                            >
                                                {field.field_name}
                                                {field.is_required && <span className="text-red-500"> *</span>}
                                            </label>
                                            {renderField(field)}
                                            {errors[`data.${field.field_key}` as keyof typeof errors] && (
                                                <p className="mt-1 text-sm text-red-600">
                                                    {errors[`data.${field.field_key}` as keyof typeof errors]}
                                                </p>
                                            )}
                                        </div>
                                    ))}
                            </div>
                        </div>
                    )}

                    {/* Submit Buttons */}
                    <div className="flex justify-end gap-4">
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => setData('status', 'draft')}
                            disabled={processing}
                        >
                            💾 Simpan sebagai Draft
                        </Button>
                        <Button
                            type="submit"
                            onClick={() => setData('status', 'submitted')}
                            disabled={processing}
                            className="bg-green-600 hover:bg-green-700"
                        >
                            📤 {processing ? 'Menyimpan...' : 'Ajukan Laporan'}
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}