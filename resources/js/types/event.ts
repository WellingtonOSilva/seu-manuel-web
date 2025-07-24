import { Vehicle } from '@/types/vehicle';

export enum EventType {
    MAINTENANCE_PREVENTIVE,   // Manutenção para evitar falhas futuras
    MAINTENANCE_CORRECTIVE,   // Manutenção para corrigir um problema já ocorrido
    REVISION,                 // Revisão programada (ex: plano de fábrica)
    INSPECTION,               // Verificações técnicas, vistorias, check-ups
    INCIDENT,                 // Ocorrências inesperadas (pane, acidente, avaria)
    DOCUMENTATION,            // Licenciamento, IPVA, transferência, multas
    CLEANING,                 // Lavagens, higienizações
    FUELING,                  // Abastecimento
    ALERT,                    // Notificações do veículo (ex: luz no painel)
    CUSTOM,
}

export interface Event {
    id: string;
    type: EventType;
    vehicle: Vehicle;
    data: object;
    occurrenceDate: Date;
    description: string;
}
