import { Wrench } from 'lucide-react';
import { TimelineLayout } from './timeline';
import type { TimelineElement } from '@/types/timeline';
import { Chat } from '@/components/ui/chat/chat';

export default function MaintenanceSection({ vehicleId }: {vehicleId: string}) {

    const timeLineData: TimelineElement[] = [
        {
            id: 1,
            title: 'Primeira Revisão',
            description: 'aaaaaa',
            date: 'aaaa',
            status: 'completed'
        },
        {
            id: 2,
            title: 'Segunda Revisão',
            description: 'aaaaaa',
            date: 'aaaa',
            status: 'in-progress'
        },
        {
            id: 3,
            title: 'Terceira Revisão',
            date: 'aaaaaa',
            description: 'Troca de Oléo \n Troca de filtro',
            status: 'pending'
        }
    ]

    return (
        <section className="grid grid-cols-12 gap-6">
            {/* Timeline / Revisões */}
            <div className="col-span-6 overflow-y-auto max-h-100">
                <TimelineLayout items={timeLineData} size="md" connectorColor={'primary'} iconColor="primary" customIcon={<Wrench />} />
            </div>

            {/* Chat com GenAI */}
            <div className="col-span-6 ">
                <Chat vehicleId={vehicleId}/>
            </div>
        </section>
    );
}
