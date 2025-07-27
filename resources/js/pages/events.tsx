import { Head, usePage } from '@inertiajs/react';
import { Plus } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';
import { DataTable } from '@/components/ui/events/data-table';
import { Event, EventType } from '@/types/event';
import * as converters from '@/helpers/converters';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Eventos e Manutenções',
        href: '/events',
    },
];

type PageProps = {
    events: Event[]
}
export default function Events() {
    const { events } = usePage<PageProps>().props
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Eventos e Manutenções" />
            <div className="flex h-full flex-1 flex-col gap-6 p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold">Eventos e Manutenções</h1>
                    <Button asChild>
                        <a href={'/events/create'}>
                            <Plus className="mr-2 h-4 w-4" />
                            Novo evento
                        </a>
                    </Button>
                </div>

                <DataTable data={converters.toEventTable(events)} />
            </div>
        </AppLayout>
    );
}
