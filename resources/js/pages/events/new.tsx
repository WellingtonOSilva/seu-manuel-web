import { Head, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { Vehicle } from '@/types/vehicle';
import { CreateEventForm } from '@/components/ui/events/create-event-form';

type PageProps = {
    vehicles: Vehicle[];
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Events', href: '/events' },
    { title: 'New', href: '/events/new' },
];

export default function CreateCar() {
    const { vehicles } = usePage<PageProps>().props;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Novo evento" />
            <div className="ml-4 max-w-4xl p-6">
                <h1 className="mb-6 text-2xl font-bold">Informar novo evento</h1>
                <CreateEventForm vehicles={vehicles} />
            </div>
        </AppLayout>
    );
}
