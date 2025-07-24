import { Head, router } from '@inertiajs/react';
import { Plus } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';
import { DataTable } from '@/pages/events/data-table';
import { Event, EventType } from '@/types/event';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Events',
        href: '/events',
    },
];
export default function Events() {
    const data: Event[] = [
        {
            id: 'aa',
            type: EventType.INSPECTION,
            vehicle: {
                name: 'aaa',
                licensePlate: 'aaa',
                id: '',
                year: 0,
                km: 0,
                isNew: false,
                version: undefined,
                owner: undefined,
            },
            data: {},
            occurrenceDate: new Date(),
            description: 'aaaa',
        },
    ];
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Events" />
            <div className="flex h-full flex-1 flex-col gap-6 p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold">Events</h1>
                    <Button asChild>
                        <a href={'/events/create'}>
                            <Plus className="mr-2 h-4 w-4" />
                            Add a new event
                        </a>
                    </Button>
                </div>

                <DataTable data={data} />
            </div>
        </AppLayout>
    );
}
