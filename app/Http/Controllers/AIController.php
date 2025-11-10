<?php

namespace App\Http\Controllers;

use App\Models\AIRequest;
use App\Services\YandexGPTService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AIController extends Controller
{
    private $yandexGPT;

    public function __construct(YandexGPTService $yandexGPT)
    {
        $this->yandexGPT = $yandexGPT;
    }
    
    public function index()
    {
        return view('ai.index');
    }
    
    public function history()
    {
        $requests = AIRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('ai.history', compact('requests'));
    }
    
    public function process(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000'
        ]);
        
        $result = $this->yandexGPT->sendPrompt($request->prompt, [
            'temperature' => 0.7,
            'maxTokens' => 2000
        ]);
        
        if ($result['success']) {
            AIRequest::create([
                'user_id' => Auth::id(),
                'prompt_text' => $request->prompt,
                'response_text' => $result['text'],
                'model_used' => 'yandexgpt-5.1-pro',
                'tokens_used' => $result['tokens_used'] ?? null,
                'status' => 'completed'
            ]);
            
            return redirect()->route('ai.history')
                ->with('success', 'Запрос успешно обработан!');
        }
        
        AIRequest::create([
            'user_id' => Auth::id(),
            'prompt_text' => $request->prompt,
            'response_text' => null,
            'model_used' => 'yandexgpt-5.1-pro',
            'status' => 'error'
        ]);
        
        return back()->withInput()
            ->with('error', 'Ошибка при обращении к AI: ' . ($result['error'] ?? 'Неизвестная ошибка'));
    }
    
    public function destroy($id)
    {
        $aiRequest = AIRequest::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $aiRequest->delete();
        
        return redirect()->route('ai.history')
            ->with('success', 'Запрос успешно удален!');
    }
}