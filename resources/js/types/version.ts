import { Model } from '@/types/model';

export interface Version {
    id: string;
    name: string;
    engine: string;
    data: object;
    model: Model;
}
