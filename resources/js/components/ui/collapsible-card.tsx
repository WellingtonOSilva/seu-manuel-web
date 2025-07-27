import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from "@/components/ui/collapsible";
import { ChevronDown } from "lucide-react";
import { ReactNode, useState } from "react";

type CollapsibleCardProps = {
    title: string;
    children: ReactNode;
};

export function CollapsibleCard({ title, children }: CollapsibleCardProps) {
    const [isOpen, setIsOpen] = useState(false);

    return (
        <Collapsible open={isOpen} onOpenChange={setIsOpen}>
            <Card>
                <CollapsibleTrigger asChild>
                    <CardHeader className="cursor-pointer flex flex-row justify-between items-center">
                        <CardTitle>{title}</CardTitle>
                        <ChevronDown
                            className={`transition-transform ${isOpen ? "rotate-180" : ""}`}
                        />
                    </CardHeader>
                </CollapsibleTrigger>
                <CollapsibleContent asChild>
                    <CardContent className="space-y-4">{children}</CardContent>
                </CollapsibleContent>
            </Card>
        </Collapsible>
    );
}
