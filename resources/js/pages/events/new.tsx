import { Head, useForm, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useEffect, useState } from 'react';
import type { BreadcrumbItem } from '@/types';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { Brand } from '@/types/brand';
import { Model } from '@/types/model';
import { NumericFormat } from 'react-number-format';

type PageProps = {
    brands: Brand[];
    models: Model[];
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Events', href: '/events' },
    { title: 'New', href: '/events/new' },
];

export default function CreateCar() {
    const { brands, models } = usePage<PageProps>().props;

    const { data, setData, post, processing, errors, reset, recentlySuccessful } = useForm({
        licensePlate: '',
        brand: '',
        model: '',
        version: '',
        year: '',
        km: null,
        isNew: true,
    });

    const [filteredModels, setFilteredModels] = useState<Model[]>([]);

    useEffect(() => {
        if (data.brand) {
            const filtered = models.filter((m) => m.brand?.id === data.brand);
            setFilteredModels(filtered);
            setData('model', '');
            setData('version', '');
        }
    }, [data.brand]);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/vehicles');
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Add New Car" />
            <div className="ml-4 max-w-4xl p-6">
                <h1 className="mb-6 text-2xl font-bold">Register Your Car</h1>
                <form onSubmit={handleSubmit} className="space-y-6">
                    <div className="grid grid-cols-1 gap-6 md:grid-cols-4">
                        {/* Brand */}
                        <div>
                            <Label htmlFor="brand">Brand</Label>
                        </div>
                    </div>

                    <div className="flex justify-end">
                        <Button type="submit" disabled={processing}>
                            {processing ? 'Saving...' : 'Add Car'}
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
