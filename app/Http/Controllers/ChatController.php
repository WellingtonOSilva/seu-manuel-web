<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use App\Services\VehicleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function __construct(
        public VehicleService $vehicleService,
        public EventService $eventService,
    ) {}

    public function __invoke(Request $request)
    {
        $vehicleId = $request->query('vehicle');
        $incomingMessages = json_decode($request->query('messages'), true) ?? [];

        if (!$vehicleId || empty($incomingMessages)) {
            return response()->json([
                'error' => 'Parâmetros obrigatórios: "vehicle" e "messages".'
            ], 400);
        }

        $vehicle = $this->vehicleService->find($vehicleId);
        if (!$vehicle) {
            return response()->json(['error' => 'Veículo não encontrado.'], 404);
        }

        $cacheKey = "chat:vehicle:{$vehicleId}:session:{a}";

        // Carrega histórico do cache (ou inicializa com system prompt)
        $history = Cache::get($cacheKey, []);

        if (empty($history)) {
            $history[] = [
                'role' => 'system',
                'content' => implode("\n", [
                    'Você é um assistente chamado Seu Manuel (trocadilho com "Seu Manual"), focado em manutenção de veículos.',
                    'Responda com base em dados técnicos e no manual do proprietário.',
                    'Abaixo estão os dados do veículo (events são o histórico de manutenção/revisão etc):',
                    json_encode($vehicle, JSON_PRETTY_PRINT),
                    ' A seguir, você encontrará o json com Eventos/Manutenções: ' . json_encode($this->eventService->listAllByVehicleId($vehicle->id), JSON_PRETTY_PRINT),
                ])
            ];
        }

        // Adiciona as novas mensagens do usuário
        foreach ($incomingMessages as $msg) {
            if ($msg['role'] === 'user') {
                $history[] = $msg;
            }
        }

        // Mantém o system + as últimas 9 mensagens
        $systemMessage = $history[0];
        $lastMessages = array_slice($history, -9);
        $finalMessages = array_merge([$systemMessage], $lastMessages);

        // Faz o stream internamente e monta a resposta final
        $assistantMessage = ['role' => 'assistant', 'content' => ''];
        $stream = OpenAI::chat()->createStreamed([
            'model' => 'gpt-4',
            'messages' => $finalMessages,
            'stream' => true,
        ]);

        foreach ($stream as $response) {
            $assistantMessage['content'] .= $response->choices[0]->delta->content ?? '';
        }

        $history[] = $assistantMessage;
        Cache::put($cacheKey, $history, now()->addMinutes(30)); // TTL: 30 minutos

        return response()->json($assistantMessage);
    }
}
