import { Head, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Vehicle } from '@/types/vehicle';
import { Event } from '@/types/event';
import { DataTable } from '@/components/ui/events/data-table';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { CollapsibleCard } from '@/components/ui/collapsible-card';
import MaintenanceSection from '@/components/ui/maintenance-section';
import { Button } from '@/components/ui/button';
import { toEventTable } from '@/helpers/converters';
import { useState } from 'react';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { CreateEventForm } from '@/components/ui/events/create-event-form';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Minha garagem', href: '/vehicles' },
    { title: 'Detalhes', href: '/vehicles' },
];

type VehicleDetailProps = {
    vehicle: Vehicle;
    events: Event[];
};

export default function VehicleDetail() {
    const { vehicle, events } = usePage<VehicleDetailProps>().props;
    const [isOpen, setIsOpen] = useState(false);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Vehicle Detail" />
            <div className="flex flex-col gap-6 p-8">
                <div className="flex items-center justify-between">
                    <h3 className="text-2xl font-bold">{vehicle.name}</h3>
                    <p className="text-lg font-semibold text-muted-foreground">{vehicle.version?.model?.brand?.name}</p>
                </div>
                <Card>
                    <CardHeader>
                        <CardTitle>{vehicle.version?.name}</CardTitle>
                    </CardHeader>
                    <CardContent className="grid grid-cols-2 gap-4">
                        <div>
                            <Label>Placa</Label>
                            <p>{vehicle.licensePlate}</p>
                        </div>
                        <div>
                            <Label>Ano</Label>
                            <p>{vehicle.year}</p>
                        </div>
                        <div>
                            <Label>Quilometragem</Label>
                            <p>{vehicle.km}</p>
                        </div>
                        <div>
                            <Label>Condição</Label>
                            <p>{vehicle.isNew ? 'New' : 'Used'}</p>
                        </div>
                        <div>
                            <Label>Motor</Label>
                            <p>{vehicle.version?.engine}</p>
                        </div>
                        <div>
                            <Label>Modelo</Label>
                            <p>{vehicle.version?.model?.name}</p>
                        </div>
                    </CardContent>
                </Card>
                <CollapsibleCard title={'Manual do proprietário'}>
                    <MaintenanceSection vehicleId={vehicle.id} />
                </CollapsibleCard>
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between">
                        <CardTitle>Histórico</CardTitle>
                        <Dialog open={isOpen} onOpenChange={setIsOpen}>
                            <DialogTrigger asChild>
                                <Button variant="default" size="sm">
                                    + Adicionar evento
                                </Button>
                            </DialogTrigger>
                            <DialogContent className="max-w-4xl">
                                <DialogHeader>
                                    <DialogTitle>Novo Evento</DialogTitle>
                                </DialogHeader>
                                <CreateEventForm vehicleId={vehicle.id} />
                            </DialogContent>
                        </Dialog>
                    </CardHeader>

                    <CardContent>
                        <DataTable data={toEventTable(events)} />
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
