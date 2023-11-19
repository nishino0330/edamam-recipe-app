<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatGptController extends Controller
{

    public function chat(Request $request)
    {
        // バリデーション
        $request->validate([
            'sentence' => 'required',
        ], [
            // カスタムエラーメッセージ
            'sentence.required' => '文章を入力してください',
        ]);

        // 文章
        $sentence = $request->input('sentence');

        // ChatGPT API処理
        $chat_response = $this->chat_gpt("日本語で応答してください", $sentence);

        return view('chat', compact('sentence', 'chat_response'));
    }

    /**
     * chat
     *
     * @param  Request  $request
     */
    public function chat(array $requestData)
    {
        // 料理名
        $recipeName = $requestData['sentences'][0] ?? null;

        // $recipeNameがnullの場合のエラー処理
        if ($recipeName === null) {
            return view('error', ['message' => '料理名が提供されていません。']);
        }
        
        // ChatGPT API処理
        $chat_response = $this->chat_gpt("この料理の作り方を教えてください", $requestData['sentences']);

        return view('search', compact('recipeName', 'chat_response'));
    }

    /**
     * ChatGPT API呼び出し
     * ライブラリ
     */
    function chat_gpt($system, $sentences)
    {
        // APIキー
        $api_key = env('CHAT_GPT_KEY');

        // パラメータ
        $messages = [
            [
                "role" => "system",
                "content" => $system
            ]
        ];

        // ユーザーからの各食材メッセージを追加
        foreach ($sentences as $sentence) {
            $messages[] = [
                "role" => "user",
                "content" => $sentence
            ];
        }

        $data = [
            "model" => "gpt-3.5-turbo",
            "messages" => $messages
        ];

        // APIにリクエストを送信
        $openaiClient = \Tectalic\OpenAi\Manager::build(
            new \GuzzleHttp\Client(),
            new \Tectalic\OpenAi\Authentication($api_key)
        );

        try {
            $response = $openaiClient->chatCompletions()->create(
                new \Tectalic\OpenAi\Models\ChatCompletions\CreateRequest($data)
            )->toModel();

            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            return "ERROR";
        }
    }

}
