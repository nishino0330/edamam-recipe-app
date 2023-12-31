<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class RecipeController extends Controller
{
    public function search(Request $request)
    {
        // 入力された食材を取得
        $ingredients = $request->input('ingredients');

        // 入力された食材をスペースで区切って配列に変換
        $ingredientList = explode(' ', $ingredients);

        // Edamam APIのエンドポイント
        $url = "https://api.edamam.com/search";

        // Edamam APIに送信するクエリパラメータ
        $params = [
            "q" => implode(",", $ingredientList),  // 食材をカンマで区切って文字列に結合
            "app_id" => env('APPLICATION_ID'),  // 環境変数からアプリケーションIDを取得
            "app_key" => env('APPLICATION_KEY'),  // 環境変数からアプリケーションキーを取得
            "from" => 0,  // 検索結果の開始位置
            "to" => 2,  // 検索結果の終了位置
            // "cuisineType" => 'japanese or italian',
        ];

        // 選択された料理タイプをクエリに追加
        if ($request->has('cuisineType')) {
            $selectedCuisines = $request->input('cuisineType');
                $params["cuisineType"] = implode(' or ', $selectedCuisines);
        }

        // Edamam APIにリクエストを送信
        $response = Http::get($url, $params);

        // レスポンスをJSON形式で取得
        $data = $response->json();
        
        //dd($data["hits"]);
        // var_dump($data["hits"][0]["recipe"]["label"]);
        // dd($data["hits"][0]["recipe"]["label"]);

        
        
        //sendMessage($data);
        // sendMessageメソッドを呼び出し、データを渡す
        // $menuInfo = $this->sendMessage($data["hits"][0]["recipe"]["label"]);



        // 検索結果の料理をビューに渡す
        //　, 'produceByGpt' => $produceByGpt
        return view('search', ['recipes' => $data["hits"]]);
    }

    public function sendMessage($n)
    {
        $message_1 = "ok!";
        if($n == 10){
            $testMessage = $message_1;
        }else{
            $testMessage = "bbb";
            // $testMessage = $data["hits"][0]["recipe"]["label"];
        }
        
        // レスポンスをJSON形式で返す
        return new JsonResponse(['test' => $testMessage]);
    }
}
