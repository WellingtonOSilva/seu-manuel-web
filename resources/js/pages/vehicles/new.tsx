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
    { title: 'My Cars', href: '/vehicles' },
    { title: 'New', href: '/vehicles/new' },
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
                            <Select value={data.brand} onValueChange={(value) => setData('brand', value)}>
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a brand" />
                                </SelectTrigger>
                                <SelectContent>
                                    {brands.map((brand) => (
                                        <SelectItem key={brand.id} value={brand.id}>
                                            {brand.name}
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            {errors.brand && <p className="mt-1 text-sm text-red-500">{errors.brand}</p>}
                        </div>

                        {/* Version grouped by Model */}
                        <div className="md:col-span-2">
                            <Label htmlFor="version">Model & Version</Label>
                            <Select
                                value={data.version}
                                onValueChange={(value) => {
                                    setData('version', value);
                                    const parentModel = filteredModels.find((model) => model.versions?.some((v) => v.id === value));
                                    if (parentModel) {
                                        setData('model', parentModel.id);
                                    }
                                }}
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a version">
                                        {filteredModels.flatMap((m) => m.versions).find((v) => v?.id === data.version)?.name}
                                    </SelectValue>
                                </SelectTrigger>
                                <SelectContent>
                                    {filteredModels.map((model) => (
                                        <SelectGroup key={model.id}>
                                            <SelectLabel>{model.name}</SelectLabel>
                                            {model.versions?.map((version) => (
                                                <SelectItem key={version.id} value={version.id}>
                                                    {version.name}
                                                </SelectItem>
                                            ))}
                                        </SelectGroup>
                                    ))}
                                </SelectContent>
                            </Select>
                            {errors.version && <p className="mt-1 text-sm text-red-500">{errors.version}</p>}
                        </div>

                        {/* Year */}
                        <div>
                            <Label htmlFor="year">Year</Label>
                            <Input
                                id="year"
                                type="number"
                                value={data.year}
                                onChange={(e) => setData('year', e.target.value)}
                                className={errors.year ? 'border-red-500' : ''}
                            />
                            {errors.year && <p className="mt-1 text-sm text-red-500">{errors.year}</p>}
                        </div>

                        {/* Is a new car */}
                        <div>
                            <Label htmlFor={'newCar'}>É um carro novo?</Label>
                            <RadioGroup value={data.isNew ? 'yes' : 'no'} onValueChange={(value) => setData('isNew', value === 'yes')}>
                                <div className={'mt-3 flex items-center space-x-6'}>
                                    <div className="flex items-center space-x-2">
                                        <RadioGroupItem value="yes" id="is-new-yes" />
                                        <Label htmlFor="is-new-yes">Sim</Label>
                                    </div>
                                    <div className="flex items-center space-x-2">
                                        <RadioGroupItem value="no" id="is-new-no" />
                                        <Label htmlFor="is-new-no">Não</Label>
                                    </div>
                                </div>
                            </RadioGroup>
                        </div>

                        {/* License Plate */}
                        <div>
                            <Label htmlFor="licensePlate">License Plate</Label>
                            <Input
                                id="licensePlate"
                                value={data.licensePlate}
                                onChange={(e) => setData('licensePlate', e.target.value)}
                                className={errors.licensePlate ? 'border-red-500' : ''}
                            />
                            {errors.licensePlate && <p className="mt-1 text-sm text-red-500">{errors.licensePlate}</p>}
                        </div>

                        {/* KM */}
                        <div>
                            <Label htmlFor="km">KM</Label>
                            <NumericFormat
                                id="km"
                                thousandSeparator="."
                                decimalSeparator=","
                                allowNegative={false}
                                allowLeadingZeros={false}
                                isAllowed={(values) => {
                                    const { floatValue } = values;
                                    return floatValue === undefined || floatValue <= 999999;
                                }}
                                onChange={(e) => setData('km', Number.parseInt(e.target.value))}
                                placeholder="0"
                                customInput={Input}
                            />
                            {errors.km && <p className="mt-1 text-sm text-red-500">{errors.km}</p>}
                        </div>

                        {/*  */}
                        {/*<div>*/}
                        {/*    <Label htmlFor="year">Color</Label>*/}
                        {/*    <Input*/}
                        {/*        id="year"*/}
                        {/*        type="number"*/}
                        {/*        value={data.color}*/}
                        {/*        onChange={(e) => setData('year', e.target.value)}*/}
                        {/*        className={errors.color ? 'border-red-500' : ''}*/}
                        {/*    />*/}
                        {/*    {errors.color && (*/}
                        {/*        <p className="text-sm text-red-500 mt-1">{errors.year}</p>*/}
                        {/*    )}*/}
                        {/*</div>*/}
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
