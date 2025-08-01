<?php

namespace App\Data;

enum EventType: string
{
    case MAINTENANCE_PREVENTIVE = 'MAINTENANCE_PREVENTIVE';
    case MAINTENANCE_CORRECTIVE = 'MAINTENANCE_CORRECTIVE';
    case REVISION = 'REVISION';
    case INSPECTION = 'INSPECTION';
    case INCIDENT = 'INCIDENT';
    case DOCUMENTATION = 'DOCUMENTATION';
    case CLEANING = 'CLEANING';
    case FUELING = 'FUELING';
    case ALERT = 'ALERT';
    case CUSTOM = 'CUSTOM';

}
