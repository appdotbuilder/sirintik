import AppLayout from '@/components/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

interface User {
    id: number;
    name: string;
    email: string;
    role: string;
    district?: string;
    bidang?: string;
    [key: string]: unknown;
}

interface Report {
    id: number;
    title: string;
    status: string;
    report_date: string;
    user?: User;
    report_category?: {
        name: string;
    };
    [key: string]: unknown;
}

interface Stats {
    totalUsers?: number;
    totalReports?: number;
    pendingReports?: number;
    verifiedReports?: number;
    rejectedReports?: number;
    categories?: number;
    myReports?: number;
    draftReports?: number;
    submittedReports?: number;
    myVerifications?: number;
    recentReports?: Report[];
    [key: string]: unknown;
}

interface Props {
    user: User;
    stats: Stats;
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ user, stats }: Props) {
    const getRoleDisplay = (role: string) => {
        switch (role) {
            case 'superadmin':
                return '🔐 Super Administrator';
            case 'admin_bidang':
                return '📋 Admin Bidang';
            case 'admin_kecamatan':
                return '🏢 Admin Kecamatan';
            default:
                return role;
        }
    };

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

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
                {/* Welcome Section */}
                <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                    <div className="flex items-center gap-4">
                        <div className="text-4xl">👋</div>
                        <div>
                            <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                                Selamat Datang, {user.name}!
                            </h1>
                            <p className="text-gray-600 dark:text-gray-400">
                                {getRoleDisplay(user.role)}
                                {user.district && ` - ${user.district}`}
                                {user.bidang && ` - ${user.bidang}`}
                            </p>
                        </div>
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    {user.role === 'superadmin' && (
                        <>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">👥</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Total Pengguna</p>
                                        <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.totalUsers || 0}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">📊</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Total Laporan</p>
                                        <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.totalReports || 0}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">⏳</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Menunggu Verifikasi</p>
                                        <p className="text-2xl font-bold text-blue-600 dark:text-blue-400">{stats.pendingReports || 0}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">✅</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Terverifikasi</p>
                                        <p className="text-2xl font-bold text-green-600 dark:text-green-400">{stats.verifiedReports || 0}</p>
                                    </div>
                                </div>
                            </div>
                        </>
                    )}

                    {user.role === 'admin_bidang' && (
                        <>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">⏳</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Menunggu Verifikasi</p>
                                        <p className="text-2xl font-bold text-blue-600 dark:text-blue-400">{stats.pendingReports || 0}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">✅</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Terverifikasi</p>
                                        <p className="text-2xl font-bold text-green-600 dark:text-green-400">{stats.verifiedReports || 0}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">❌</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Ditolak</p>
                                        <p className="text-2xl font-bold text-red-600 dark:text-red-400">{stats.rejectedReports || 0}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">🔍</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Saya Verifikasi</p>
                                        <p className="text-2xl font-bold text-purple-600 dark:text-purple-400">{stats.myVerifications || 0}</p>
                                    </div>
                                </div>
                            </div>
                        </>
                    )}

                    {user.role === 'admin_kecamatan' && (
                        <>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">📋</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Total Laporan Saya</p>
                                        <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.myReports || 0}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">📝</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Draft</p>
                                        <p className="text-2xl font-bold text-gray-600 dark:text-gray-400">{stats.draftReports || 0}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">📤</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Diajukan</p>
                                        <p className="text-2xl font-bold text-blue-600 dark:text-blue-400">{stats.submittedReports || 0}</p>
                                    </div>
                                </div>
                            </div>
                            <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                                <div className="flex items-center gap-3">
                                    <div className="text-2xl">✅</div>
                                    <div>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Terverifikasi</p>
                                        <p className="text-2xl font-bold text-green-600 dark:text-green-400">{stats.verifiedReports || 0}</p>
                                    </div>
                                </div>
                            </div>
                        </>
                    )}
                </div>

                {/* Recent Reports */}
                {stats.recentReports && stats.recentReports.length > 0 && (
                    <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                        <h2 className="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                            📋 Laporan Terbaru
                        </h2>
                        <div className="space-y-4">
                            {stats.recentReports.map((report) => (
                                <div key={report.id} className="flex items-center justify-between rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                                    <div className="flex-1">
                                        <h3 className="font-medium text-gray-900 dark:text-white">
                                            {report.title}
                                        </h3>
                                        <div className="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                            {report.report_category && (
                                                <span>📊 {report.report_category.name}</span>
                                            )}
                                            {report.user && user.role !== 'admin_kecamatan' && (
                                                <span>👤 {report.user.name}</span>
                                            )}
                                            <span>📅 {new Date(report.report_date).toLocaleDateString('id-ID')}</span>
                                        </div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        {getStatusBadge(report.status)}
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                )}

                {/* Quick Actions */}
                <div className="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
                    <h2 className="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                        🚀 Aksi Cepat
                    </h2>
                    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {user.role === 'admin_kecamatan' && (
                            <a
                                href="/reports/create"
                                className="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700 hover:bg-green-100 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400 dark:hover:bg-green-900/30"
                            >
                                <div className="text-xl">➕</div>
                                <span className="font-medium">Buat Laporan Baru</span>
                            </a>
                        )}
                        
                        <a
                            href="/reports"
                            className="flex items-center gap-3 rounded-lg border border-blue-200 bg-blue-50 p-4 text-blue-700 hover:bg-blue-100 dark:border-blue-800 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30"
                        >
                            <div className="text-xl">📋</div>
                            <span className="font-medium">Lihat Semua Laporan</span>
                        </a>

                        {user.role === 'superadmin' && (
                            <a
                                href="/admin/users"
                                className="flex items-center gap-3 rounded-lg border border-purple-200 bg-purple-50 p-4 text-purple-700 hover:bg-purple-100 dark:border-purple-800 dark:bg-purple-900/20 dark:text-purple-400 dark:hover:bg-purple-900/30"
                            >
                                <div className="text-xl">👥</div>
                                <span className="font-medium">Kelola Pengguna</span>
                            </a>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}