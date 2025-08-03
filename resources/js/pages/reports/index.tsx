import AppLayout from '@/components/app-layout';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface User {
    id: number;
    name: string;
    role: string;
    district?: string;
    [key: string]: unknown;
}

interface ReportCategory {
    id: number;
    name: string;
    slug: string;
    [key: string]: unknown;
}

interface Report {
    id: number;
    title: string;
    status: string;
    report_date: string;
    district: string;
    user?: User;
    report_category?: ReportCategory;
    verifier?: User;
    [key: string]: unknown;
}

interface Props {
    reports: {
        data: Report[];
        links: Array<{ url: string | null; label: string; active: boolean }>;
        meta: { last_page: number };
    };
    categories: ReportCategory[];
    filters: {
        status?: string;
        category?: string;
        district?: string;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Laporan', href: '/reports' },
];

export default function ReportsIndex({ reports, categories, filters }: Props) {
    const getStatusBadge = (status: string) => {
        const badges = {
            draft: 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
            submitted: 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-300',
            verified: 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-300',
            rejected: 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-300',
        };
        
        const labels = {
            draft: 'Draft',
            submitted: 'Diajukan',
            verified: 'Terverifikasi',
            rejected: 'Ditolak',
        };

        return (
            <span className={`inline-flex rounded-full px-2 py-1 text-xs font-medium ${badges[status as keyof typeof badges] || badges.draft}`}>
                {labels[status as keyof typeof labels] || status}
            </span>
        );
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

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Laporan" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                            📋 Daftar Laporan
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400">
                            Kelola laporan pertanian
                        </p>
                    </div>
                    <Link href="/reports/create">
                        <Button className="bg-green-600 hover:bg-green-700">
                            ➕ Buat Laporan
                        </Button>
                    </Link>
                </div>

                {/* Filter Section */}
                <div className="rounded-xl bg-white p-4 shadow-sm dark:bg-gray-800">
                    <div className="flex flex-wrap gap-4">
                        <select 
                            className="rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-700"
                            defaultValue={filters.status || ''}
                        >
                            <option value="">Semua Status</option>
                            <option value="draft">Draft</option>
                            <option value="submitted">Diajukan</option>
                            <option value="verified">Terverifikasi</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                        
                        <select 
                            className="rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-700"
                            defaultValue={filters.category || ''}
                        >
                            <option value="">Semua Kategori</option>
                            {categories.map((category) => (
                                <option key={category.id} value={category.id}>
                                    {category.name}
                                </option>
                            ))}
                        </select>
                    </div>
                </div>

                {/* Reports List */}
                <div className="rounded-xl bg-white shadow-sm dark:bg-gray-800">
                    {reports.data.length === 0 ? (
                        <div className="p-12 text-center">
                            <div className="text-6xl mb-4">📭</div>
                            <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                Belum ada laporan
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400 mb-6">
                                Mulai dengan membuat laporan pertama Anda
                            </p>
                            <Link href="/reports/create">
                                <Button className="bg-green-600 hover:bg-green-700">
                                    ➕ Buat Laporan Pertama
                                </Button>
                            </Link>
                        </div>
                    ) : (
                        <div className="divide-y divide-gray-200 dark:divide-gray-700">
                            {reports.data.map((report) => (
                                <div key={report.id} className="p-6">
                                    <div className="flex items-center justify-between">
                                        <div className="flex-1">
                                            <div className="flex items-center gap-3 mb-2">
                                                <div className="text-xl">
                                                    {report.report_category && getCategoryIcon(report.report_category.name)}
                                                </div>
                                                <Link 
                                                    href={`/reports/${report.id}`}
                                                    className="text-lg font-medium text-gray-900 hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                                >
                                                    {report.title}
                                                </Link>
                                            </div>
                                            
                                            <div className="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                                {report.report_category && (
                                                    <span className="flex items-center gap-1">
                                                        📊 {report.report_category.name}
                                                    </span>
                                                )}
                                                {report.user && (
                                                    <span className="flex items-center gap-1">
                                                        👤 {report.user.name}
                                                    </span>
                                                )}
                                                <span className="flex items-center gap-1">
                                                    🏢 {report.district}
                                                </span>
                                                <span className="flex items-center gap-1">
                                                    📅 {new Date(report.report_date).toLocaleDateString('id-ID')}
                                                </span>
                                                {report.verifier && (
                                                    <span className="flex items-center gap-1">
                                                        ✅ Diverifikasi oleh {report.verifier.name}
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                        
                                        <div className="flex items-center gap-3">
                                            {getStatusBadge(report.status)}
                                            <Link href={`/reports/${report.id}`}>
                                                <Button variant="outline" size="sm">
                                                    Lihat
                                                </Button>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>

                {/* Pagination */}
                {reports.data.length > 0 && reports.meta.last_page > 1 && (
                    <div className="flex justify-center">
                        <div className="flex gap-2">
                            {reports.links.map((link, index) => (
                                <Link
                                    key={index}
                                    href={link.url || '#'}
                                    className={`px-3 py-2 rounded-lg text-sm ${
                                        link.active 
                                            ? 'bg-blue-600 text-white' 
                                            : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700'
                                    }`}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                />
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}