export enum EventType {
    MAINTENANCE_PREVENTIVE = 'MAINTENANCE_PREVENTIVE',
    MAINTENANCE_CORRECTIVE = 'MAINTENANCE_CORRECTIVE',
    REVISION = 'REVISION',
    INSPECTION = 'INSPECTION',
    INCIDENT = 'INCIDENT',
    DOCUMENTATION = 'DOCUMENTATION',
    CLEANING = 'CLEANING',
    FUELING = 'FUELING',
    ALERT = 'ALERT',
    CUSTOM = 'CUSTOM',
}

export interface Event {
    id: string;
    type: EventType;
    vehicleId: string;
    vehicleName: string;
    data: object;
    occurrenceDate: string;
    description: string;
}
