import { useEffect, useRef, useState } from "react";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Skeleton } from "@/components/ui/skeleton";

type Message = {
    role: "user" | "assistant";
    content: string;
};

export function Chat({ vehicleId }: { vehicleId: string }) {
    const [messages, setMessages] = useState<Message[]>([]);
    const [input, setInput] = useState("");
    const [loading, setLoading] = useState(false);
    const containerRef = useRef<HTMLDivElement | null>(null);

    useEffect(() => {
        // Scroll automático para o final ao adicionar mensagens
        containerRef.current?.scrollTo({
            top: containerRef.current.scrollHeight,
            behavior: "smooth",
        });
    }, [messages]);

    const sendMessage = () => {
        if (!input.trim() || loading) return;

        const updated = [...messages, { role: "user", content: input.trim() }];
        setMessages(updated);
        setInput("");
        setLoading(true);

        const eventSource = new EventSource(
            `/chat/stream?${new URLSearchParams({
                vehicle: vehicleId,
                messages: JSON.stringify(updated),
            })}`
        );

        let assistantReply = "";

        eventSource.onmessage = (e) => {
            if (e.data === "[DONE]") {
                setMessages((prev) => [...prev, { role: "assistant", content: assistantReply }]);
                setLoading(false);
                eventSource.close();
            } else {
                assistantReply += e.data;
            }
        };

        eventSource.onerror = (e) => {
            console.error("Erro no stream:", e);
            eventSource.close();
            setLoading(false);
        };
    };

    return (
        <div className="max-w-2xl mx-auto space-y-4">
            <div
                ref={containerRef}
                className="space-y-2 min-h-[400px] p-4 border rounded-md overflow-y-auto max-h-[500px] bg-muted/10"
            >
                {messages.map((msg, i) => (
                    <div
                        key={i}
                        className={`flex ${msg.role === "user" ? "justify-end" : "justify-start"}`}
                    >
                        <span
                            className={`inline-block px-4 py-2 rounded-lg max-w-[80%] text-sm ${
                                msg.role === "user"
                                    ? "bg-blue-100 text-blue-900"
                                    : "bg-green-100 text-green-900"
                            }`}
                        >
                            {msg.content}
                        </span>
                    </div>
                ))}
                {loading && (
                    <div className="flex items-center gap-2 text-sm text-muted-foreground">
                        <Skeleton className="h-4 w-1/4 rounded" />
                        <Skeleton className="h-4 w-1/5 rounded" />
                        <Skeleton className="h-4 w-1/6 rounded" />
                    </div>
                )}
            </div>
            <div className="flex gap-2 mt-4">
                <Input
                    value={input}
                    onChange={(e) => setInput(e.target.value)}
                    disabled={loading}
                    placeholder="Digite sua pergunta..."
                />
                <Button onClick={sendMessage} disabled={loading}>
                    Enviar
                </Button>
            </div>
        </div>
    );
}
