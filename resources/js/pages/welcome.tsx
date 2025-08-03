import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Sirintik - Sistem Informasi Laporan Pertanian">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col items-center bg-gradient-to-br from-green-50 to-blue-50 p-6 text-gray-900 lg:justify-center lg:p-8 dark:from-gray-900 dark:to-gray-800 dark:text-white">
                <header className="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-6xl">
                    <nav className="flex items-center justify-end gap-4">
                        {auth.user ? (
                            <Link
                                href={route('dashboard')}
                                className="inline-block rounded-lg border border-green-200 bg-green-600 px-6 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 transition-colors dark:border-green-700 dark:bg-green-700 dark:hover:bg-green-600"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link
                                    href={route('login')}
                                    className="inline-block rounded-lg border border-transparent px-6 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition-colors dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700"
                                >
                                    Masuk
                                </Link>
                                <Link
                                    href={route('register')}
                                    className="inline-block rounded-lg border border-green-200 bg-green-600 px-6 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 transition-colors dark:border-green-700 dark:bg-green-700 dark:hover:bg-green-600"
                                >
                                    Daftar
                                </Link>
                            </>
                        )}
                    </nav>
                </header>
                
                <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                    <main className="flex w-full max-w-[335px] flex-col lg:max-w-6xl lg:flex-row lg:gap-12">
                        {/* Hero Section */}
                        <div className="flex-1 text-center lg:text-left">
                            <div className="mb-8">
                                <h1 className="mb-4 text-4xl font-bold tracking-tight text-gray-900 lg:text-6xl dark:text-white">
                                    🌾 <span className="text-green-600 dark:text-green-400">Sirintik</span>
                                </h1>
                                <p className="mb-6 text-xl text-gray-600 lg:text-2xl dark:text-gray-300">
                                    Sistem Informasi Laporan Pertanian
                                </p>
                                <p className="mb-8 text-lg text-gray-500 dark:text-gray-400">
                                    Platform manajemen laporan pertanian terintegrasi untuk mengoptimalkan 
                                    data dan informasi sektor pertanian di seluruh kecamatan.
                                </p>
                            </div>

                            {/* Features Grid */}
                            <div className="mb-12 grid gap-6 md:grid-cols-2">
                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-3xl">📊</div>
                                    <h3 className="mb-2 text-lg font-semibold text-gray-900 dark:text-white">
                                        Laporan Dinamis
                                    </h3>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">
                                        Formulir laporan yang dapat disesuaikan untuk Tanaman Pangan, 
                                        Hortikultura, Perkebunan, dan Peternakan.
                                    </p>
                                </div>

                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-3xl">👥</div>
                                    <h3 className="mb-2 text-lg font-semibold text-gray-900 dark:text-white">
                                        Multi-Role Access
                                    </h3>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">
                                        Akses berbasis peran untuk Superadmin, Admin Bidang, 
                                        dan Admin Kecamatan.
                                    </p>
                                </div>

                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-3xl">✅</div>
                                    <h3 className="mb-2 text-lg font-semibold text-gray-900 dark:text-white">
                                        Verifikasi Laporan
                                    </h3>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">
                                        Sistem verifikasi bertingkat untuk memastikan 
                                        kualitas dan akurasi data laporan.
                                    </p>
                                </div>

                                <div className="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                                    <div className="mb-4 text-3xl">📈</div>
                                    <h3 className="mb-2 text-lg font-semibold text-gray-900 dark:text-white">
                                        Analisis & Statistik
                                    </h3>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">
                                        Dashboard analitik dengan statistik dan ringkasan 
                                        data untuk pengambilan keputusan.
                                    </p>
                                </div>
                            </div>

                            {/* CTA Buttons */}
                            {!auth.user && (
                                <div className="flex flex-col gap-4 sm:flex-row sm:justify-center lg:justify-start">
                                    <Link
                                        href={route('register')}
                                        className="inline-flex items-center justify-center rounded-lg bg-green-600 px-8 py-3 text-base font-medium text-white shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors dark:bg-green-700 dark:hover:bg-green-600"
                                    >
                                        🚀 Mulai Sekarang
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-8 py-3 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                    >
                                        👋 Masuk
                                    </Link>
                                </div>
                            )}
                        </div>

                        {/* Visual Side */}
                        <div className="mt-12 flex-1 lg:mt-0">
                            <div className="rounded-2xl bg-white p-8 shadow-2xl dark:bg-gray-800">
                                <div className="mb-6">
                                    <h3 className="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                                        📋 Kategori Laporan
                                    </h3>
                                    <div className="space-y-4">
                                        <div className="flex items-center gap-3 rounded-lg bg-green-50 p-3 dark:bg-green-900/20">
                                            <div className="text-2xl">🌾</div>
                                            <div>
                                                <div className="font-medium text-gray-900 dark:text-white">Tanaman Pangan</div>
                                                <div className="text-sm text-gray-600 dark:text-gray-400">Padi, Jagung, Kedelai</div>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-3 rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                                            <div className="text-2xl">🥬</div>
                                            <div>
                                                <div className="font-medium text-gray-900 dark:text-white">Hortikultura</div>
                                                <div className="text-sm text-gray-600 dark:text-gray-400">Sayuran & Buah-buahan</div>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-3 rounded-lg bg-yellow-50 p-3 dark:bg-yellow-900/20">
                                            <div className="text-2xl">🌴</div>
                                            <div>
                                                <div className="font-medium text-gray-900 dark:text-white">Perkebunan</div>
                                                <div className="text-sm text-gray-600 dark:text-gray-400">Kelapa Sawit, Karet, Kopi</div>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-3 rounded-lg bg-orange-50 p-3 dark:bg-orange-900/20">
                                            <div className="text-2xl">🐄</div>
                                            <div>
                                                <div className="font-medium text-gray-900 dark:text-white">Peternakan</div>
                                                <div className="text-sm text-gray-600 dark:text-gray-400">Sapi, Ayam, Ikan</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div className="border-t border-gray-200 pt-6 dark:border-gray-700">
                                    <div className="grid grid-cols-3 gap-4 text-center">
                                        <div>
                                            <div className="text-2xl font-bold text-green-600 dark:text-green-400">100+</div>
                                            <div className="text-sm text-gray-600 dark:text-gray-400">Kecamatan</div>
                                        </div>
                                        <div>
                                            <div className="text-2xl font-bold text-blue-600 dark:text-blue-400">1K+</div>
                                            <div className="text-sm text-gray-600 dark:text-gray-400">Laporan</div>
                                        </div>
                                        <div>
                                            <div className="text-2xl font-bold text-purple-600 dark:text-purple-400">24/7</div>
                                            <div className="text-sm text-gray-600 dark:text-gray-400">Online</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                
                <footer className="mt-12 text-center text-sm text-gray-500 dark:text-gray-400">
                    <p>
                        Dikembangkan dengan ❤️ untuk kemajuan sektor pertanian Indonesia
                    </p>
                </footer>
                
                <div className="hidden h-14.5 lg:block"></div>
            </div>
        </>
    );
}