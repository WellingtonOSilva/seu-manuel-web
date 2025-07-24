import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

import {
    ResponsiveContainer,
    BarChart,
    Bar,
    XAxis,
    YAxis,
    Tooltip,
} from 'recharts';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
];

/** ─── Dummy data ────────────────────────────────────────────────────────── */
// KPIs (você pode buscar no back‑end depois)
const kpis = [
    { label: 'Gasto com manutenção preventiva (últimos 12 meses)', value: 0.4, sub: 'BRL' },
    { label: 'Gasto com manutenção corretiva (últimos 12 meses)', value: 17, sub: 'BRL' },
    { label: 'Variação na tabela FIPE (últimos 12 meses)', value: 1.25, sub: '▲ 89%' },
];

// Gráfico (últimas 24 h). Use Date‑fns/moment se precisar formatar.
const hourlyData = [
    { hour: '2 pm', value: 4 },
    { hour: '3 pm', value: 0 },
    { hour: '4 pm', value: 4 },
    { hour: '5 pm', value: 1 },
    { hour: '6 pm', value: 8 },
    { hour: '7 pm', value: 4 },
    { hour: '8 pm', value: 0 },
    { hour: '9 pm', value: 1 },
    { hour: '10 pm', value: 0 },
    { hour: '11 pm', value: 8 },
    { hour: '12 am', value: 8 },
    { hour: '1 am', value: 9 },
    { hour: '2 am', value: 1 },
    { hour: '3 am', value: 4 },
    { hour: '4 am', value: 1 },
    { hour: '5 am', value: 1 },
];

/** ─── Page ─────────────────────────────────────────────────────────────── */
export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex flex-col gap-4 p-4"> {/* remove h-full and overflow-x-auto */}
                {/* KPIs */}
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    {kpis.map((kpi) => (
                        <Card key={kpi.label} className="h-[120px] md:h-[200px]">
                            <CardHeader>
                                <CardTitle className="text-sm font-medium">
                                    {kpi.label}
                                </CardTitle>
                            </CardHeader>
                            <CardContent className="flex flex-col items-center justify-center h-full">
                <span className="text-4xl font-semibold">
                  {kpi.value}
                </span>
                                {kpi.sub && (
                                    <span className="ml-2 text-sm text-green-600 dark:text-green-400">
                    {kpi.sub}
                  </span>
                                )}
                            </CardContent>
                        </Card>
                    ))}
                </div>

                {/* Gráfico */}
                <Card className="w-full">
                    <CardHeader>
                        <CardTitle>Eventos por mês</CardTitle>
                    </CardHeader>
                    <CardContent className="h-[200px] md:h-[400px]">
                        <ResponsiveContainer width="100%" height="100%">
                            <BarChart data={hourlyData} margin={{ top: 8, right: 16, bottom: 24, left: 16 }}>
                                <XAxis dataKey="hour" tickLine={false} />
                                <YAxis allowDecimals={false} tickLine={false} width={32} />
                                <Tooltip cursor={{ opacity: 0.1 }} />
                                <Bar dataKey="value" barSize={20} radius={[4, 4, 0, 0]} />
                            </BarChart>
                        </ResponsiveContainer>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
