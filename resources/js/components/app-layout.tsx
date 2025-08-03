import { AppContent } from '@/components/app-content';
import { AppHeader } from '@/components/app-header';
import { AppShell } from '@/components/app-shell';
import { AppSidebar } from '@/components/app-sidebar';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { type BreadcrumbItem } from '@/types';

interface AppLayoutProps {
    children: React.ReactNode;
    breadcrumbs?: BreadcrumbItem[];
}

export default function AppLayout({ children, breadcrumbs }: AppLayoutProps) {
    return (
        <AppShell variant="sidebar">
            <AppSidebar />
            <div className="flex min-h-screen w-full flex-col">
                <AppHeader />
                <AppContent>
                    {breadcrumbs && <Breadcrumbs breadcrumbs={breadcrumbs} />}
                    {children}
                </AppContent>
            </div>
        </AppShell>
    );
}