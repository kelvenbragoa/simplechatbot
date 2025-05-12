<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\WhatsappNotification;
use App\Trait\WhatsAppRecipient as TraitWhatsAppRecipient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use WhatsAppRecipient;

class ChatBotController extends Controller
{
    //
        public function sendwhatsapp($number){
            try {
                $recipient = new TraitWhatsAppRecipient($number);
                $ticket = new WhatsappNotification($number);
                Notification::send($recipient,$ticket);
            } catch (Exception $e) {
                return $e;
            }
        }

        public function getwebhook(Request $request){
            $verify_token = 'sk_test_4eC1f2a0-3b8d-4c5b-9a7f-6c1e2d3f4a5b'; // Token definido na configuração do webhook no Meta

            if ($request->hub_mode === 'subscribe' && $request->hub_verify_token === $verify_token) {
                return response($request->hub_challenge, 200); // Verificação de webhook
            }

            return response('Erro de verificação', 403); // Se o token não bater
        }

        public function postwebhook(Request $request){
            $entry = $request->input('entry')[0] ?? null;
            if (!$entry) {
                return response('No data', 400);
            }

            // Pega a mensagem
            $message = $entry['changes'][0]['value']['messages'][0] ?? null;

            if ($message) {
                $from = $message['from']; // Número que enviou a mensagem
                $text = $message['text']['body'] ?? ''; // Corpo da mensagem

                // Exemplo de resposta simples
                $response_text = 'Você disse: ' . $text;

                // Enviar resposta de volta
                $this->enviarMensagemWhatsApp($from, $response_text);
            }

            return response()->json(['status' => 'received'], 200);
        }

        public function enviarMensagemWhatsApp($to, $message)
        {
            $token = 'EAAQZCPJhz2wYBO5vcfZCCMfvbIOvujugelg0DDGZAHZBC51dhH7P68Xob46OorOFhk05OkvtEvsMniN8i7Q8YgFGVwKZBbLnynHUBboENOX19McBKVXJ8ZC6CFvOAnOJHQPlgpZBUkONpWR30ZAQETfHlULTqXixrXj9OHPkBKrZBBnmatM3CB0p3SlhyCZBXXLbHaTwZDZD'; // Token de acesso do Meta
            $phone_number_id = '397344770133312'; // ID do número do WhatsApp associado

            $response = Http::withToken($token)->post("https://graph.facebook.com/v22.0/{$phone_number_id}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'text',
                'text' => [
                    'body' => $message,
                ],
            ]);

            if ($response->successful()) {
                return true;
            }

            return false;
        }
}
