import { Version } from '@/types/version';
import { Brand } from '@/types/brand';

export enum BodyStyle {
    SUV = 'SUV',
    SEDAN = 'SEDAN',
    PICKUP = 'PICKUP',
    HATCHBACK = 'HATCHBACK',
    CROSSOVER = 'CROSSOVER'
}

export interface Model {
    id: string;
    name: string;
    platform: string;
    versions?: Version[];
    brand?: Brand;
    bodyStyle: BodyStyle;
}
