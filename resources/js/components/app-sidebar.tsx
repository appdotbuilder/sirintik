
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { FileText, LayoutGrid, Users, Settings, BarChart3, Shield } from 'lucide-react';




export function AppSidebar() {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user;

    // Build navigation items based on user role
    const mainNavItems: NavItem[] = [
        {
            title: 'Dashboard',
            href: '/dashboard',
            icon: LayoutGrid,
        },
    ];

    // Add Reports for all authenticated users
    if (user) {
        mainNavItems.push({
            title: 'Laporan',
            href: '/reports',
            icon: FileText,
        });
    }

    // Add role-specific navigation
    if (user?.role === 'superadmin') {
        mainNavItems.push(
            {
                title: 'Pengguna',
                href: '/admin/users',
                icon: Users,
            },
            {
                title: 'Kategori',
                href: '/admin/categories',
                icon: Settings,
            }
        );
    }

    if (user?.role === 'admin_bidang') {
        mainNavItems.push({
            title: 'Verifikasi',
            href: '/reports?status=submitted',
            icon: Shield,
        });
        mainNavItems.push({
            title: 'Ringkasan',
            href: '/summaries',
            icon: BarChart3,
        });
    }

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard" prefetch>
                                <div className="flex items-center gap-2">
                                    <div className="text-2xl">🌾</div>
                                    <div className="grid flex-1 text-left text-sm leading-tight">
                                        <span className="truncate font-semibold">Sirintik</span>
                                        <span className="truncate text-xs">Laporan Pertanian</span>
                                    </div>
                                </div>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}