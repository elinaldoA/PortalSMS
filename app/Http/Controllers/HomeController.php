<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\UsersPhoneNumber;

class HomeController extends Controller
{
    /**
     * Mostra os formulários com os detalhes do número de telefone dos usuários.
     *
     * @return Response
     */
    public function show()
    {
        $users = UsersPhoneNumber::all();
        return view('welcome', compact("users"));
    }
    /**
     * Armazene um novo número de telefone de usuário.
     *
     * @param  Request  $request
     * @return Response
     */
    public function storePhoneNumber(Request $request)
    {
        $validatedData = $request->validate([
            'phone_number' => 'required|unique:users_phone_number|numeric',
        ]);
        $user_phone_number_model = new UsersPhoneNumber($request->all());
        $user_phone_number_model->save();
        $this->sendMessage('Usuário registrado com sucesso!!', $request->phone_number);
        return back()->with(['success' => "{$request->phone_number} registered"]);
    }
    /**
     * Enviar mensagem para um usuário selecionado
     */
    public function sendCustomMessage(Request $request)
    {
        $validatedData = $request->validate([
            'users' => 'required|array',
            'body' => 'required',
        ]);
        $recipients = $validatedData["users"];
        // iterar sobre a matriz de destinatários e enviar uma solicitação twilio para cada
        foreach ($recipients as $recipient) {
            $this->sendMessage($validatedData["body"], $recipient);
        }
        return back()->with(['success' => "Mensagem enviada com sucesso!"]);
    }
    /**
     * Envia sms para o usuário usando o cliente de sms programável do Twilio
     * @param String $message Body of sms
     * @param Number $recipients Number of recipient
     */
    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
    }
}
