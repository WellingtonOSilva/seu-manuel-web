import { Head, usePage } from '@inertiajs/react';
import { Plus } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';
import { DataTable } from '@/components/ui/vehicles/data-table';
import { Vehicle } from '@/types/vehicle';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Minha garagem',
        href: '/vehicles',
    },
];

type PageProps = {
    vehicles: Vehicle[]
}
export default function Vehicles() {
    const { vehicles } = usePage<PageProps>().props;
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="My Vehicles" />
            <div className="flex h-full flex-1 flex-col gap-6 p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold">Minha garagem</h1>
                    <Button asChild>
                        <a href="/vehicles/new">
                            <Plus className="mr-2 h-4 w-4" />
                            Novo carro
                        </a>
                    </Button>
                </div>

                <DataTable data={vehicles} />
            </div>
        </AppLayout>
    );
}
