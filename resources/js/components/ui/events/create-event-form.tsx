import { useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Badge } from '@/components/ui/badge';
import { DatePicker } from '@/components/ui/datepicker';
import { Textarea } from '@/components/ui/textarea';
import { Input } from '@/components/ui/input';
import { EventType } from '@/types/event';
import type { Vehicle } from '@/types/vehicle';
import { NumericFormat } from 'react-number-format';
import { eventTypeToString } from '@/helpers/converters';

type Props = {
    vehicles?: Vehicle[];
    vehicleId?: string;
};

export function CreateEventForm({ vehicles = [], vehicleId }: Props) {
    const { data, setData, post, processing, errors, recentlySuccessful, transform } = useForm({
        event: '',
        vehicle: vehicleId ?? '',
        date: new Date(),
        km: '',
        cost: '',
        notes: '',
    });

    transform((data) => ({
        ...data,
        cost: Number(
            String(data.cost).replace(/\s/g, '').replace('R$', '').replace('.', '').replace(',', '.')
        ),
    }));
    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/events');
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-6">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <Label htmlFor="event">Evento</Label>
                    <Select value={data.event} onValueChange={(value) => setData('event', value)}>
                        <SelectTrigger className="w-full">
                            <SelectValue placeholder="Selecione o tipo de evento" />
                        </SelectTrigger>
                        <SelectContent>
                            {Object.entries(EventType).map(([key, label]) => (
                                <SelectItem key={key} value={key}>
                                    {eventTypeToString(label)}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    {errors.event && <p className="text-sm text-red-500">{errors.event}</p>}
                </div>

                {!vehicleId && (
                    <div>
                        <Label htmlFor="vehicle">Veículo</Label>
                        <Select value={data.vehicle} onValueChange={(value) => setData('vehicle', value)}>
                            <SelectTrigger className="w-full">
                                <SelectValue placeholder="Selecione o veículo" />
                            </SelectTrigger>
                            <SelectContent>
                                {vehicles.map((v) => (
                                    <SelectItem key={v.id} value={v.id}>
                                        {v.name} <Badge variant="secondary">{v.licensePlate}</Badge>
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {errors.vehicle && <p className="mt-1 text-sm text-red-500">{errors.vehicle}</p>}
                    </div>
                )}

                <div>
                    <Label>Quilometragem</Label>
                    <Input
                        className="w-full"
                        placeholder="KM"
                        value={data.km}
                        onChange={(e) => setData('km', e.target.value)}
                    />
                    {errors.km && <p className="mt-1 text-sm text-red-500">{errors.km}</p>}
                </div>

                <div>
                    <Label htmlFor="cost">Valor da Manutenção</Label>
                    <NumericFormat
                        prefix="R$ "
                        thousandSeparator="."
                        decimalSeparator=","
                        decimalScale={2}
                        fixedDecimalScale
                        allowNegative={false}
                        value={data.cost}
                        onValueChange={(values) => {
                            setData('cost', values.value === '' ? '' : values.formattedValue);
                        }}
                        customInput={Input}
                        className="w-full"
                        placeholder="R$ 0,00"
                    />
                    {errors.cost && <p className="mt-1 text-sm text-red-500">{errors.cost}</p>}
                </div>

                <div>
                    <Label htmlFor="date">Data</Label>
                    <DatePicker
                        value={data.date}
                        onChange={(value) => setData('date', value ?? new Date())}
                    />
                    {errors.date && <p className="text-sm text-red-500">{errors.date}</p>}
                </div>

                <div className="md:col-span-2">
                    <Label htmlFor="notes">Observações</Label>
                    <Textarea
                        id="notes"
                        className="w-full"
                        placeholder="Detalhes adicionais sobre o evento..."
                        value={data.notes}
                        onChange={(e) => setData('notes', e.target.value)}
                    />
                </div>
            </div>

            <div className="flex justify-end">
                <Button type="submit" disabled={processing ?? recentlySuccessful}>
                    {processing ? 'Salvando...' : 'Adicionar Evento'}
                </Button>
            </div>
        </form>
    );
}
