import { Event, EventType } from '@/types/event';
import { EventRow } from '@/types/table/event-row';

export function toEventTable(events: Event[]): EventRow[] {
    return events.map((value) => (
        {
            id: value.id,
            type: eventTypeToString(value.type),
            vehicleName: value.vehicleName,
            occurrenceDate: new Date(value.occurrenceDate).toLocaleDateString('pt-BR'),
            vehicleId: value.vehicleId,
        }
    ))
}

export function eventTypeToString(type: EventType) {
    switch (type) {
        case EventType.MAINTENANCE_PREVENTIVE:
            return 'Manutenção preventiva';
        case EventType.MAINTENANCE_CORRECTIVE:
            return 'Manutenção corretiva';
        case EventType.REVISION:
            return 'Revisão';
        case EventType.INSPECTION:
            return 'Inspeção';
        case EventType.INCIDENT:
            return 'Incidente';
        case EventType.DOCUMENTATION:
            return 'Documentação';
        case EventType.CLEANING:
            return 'Limpeza';
        case EventType.FUELING:
            return 'Abastecimento';
        case EventType.ALERT:
            return 'Alerta';
        case EventType.CUSTOM:
            return 'Personalizado';
        default:
            return type;
    }
}

