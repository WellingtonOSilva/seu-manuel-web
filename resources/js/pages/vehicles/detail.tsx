import { Head, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Vehicle } from '@/types/vehicle';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'My Vehicles', href: '/vehicles' },
    { title: 'Detail', href: '/vehicles' },
];

type VehicleDetailProps = {
    vehicle: Vehicle,
}
export default function VehicleDetail() {
    const { vehicle } = usePage<VehicleDetailProps>().props

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex flex-col gap-4 p-4">{vehicle.name}</div>
        </AppLayout>
    );
}
