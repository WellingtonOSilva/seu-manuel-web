import { Owner } from '@/types/owner';
import { Version } from '@/types/version';

export interface Vehicle {
    id: string;
    name: string;
    licensePlate: string;
    year: number;
    km: number;
    isNew: boolean;
    version?: Version;
    owner?: Owner;
}
