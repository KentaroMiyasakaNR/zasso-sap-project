<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('report.create');
    }

    /**
     * 新しい報告を保存する
     */
    public function store(Request $request)
    {
        $request->validate([
            'identification_result' => 'required|string',
            'photo' => 'required|image|max:10240', // 10MBまでの画像ファイル
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // 画像を保存
        $photoPath = $request->file('photo')->store('reports', 'public');

        // 報告を作成
        $report = Report::create([
            'user_id' => Auth::id(),
            'identification_result' => $request->identification_result,
            'photo_path' => $photoPath,
            'reported_at' => now(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status_id' => 1, // デフォルトのステータスID
        ]);

        // 植物名を抽出して保存（簡易的な実装）
        $plantNames = explode(',', $request->plant_names);
        foreach ($plantNames as $name) {
            $plant = Plant::firstOrCreate(['name' => trim($name)]);
            $report->plants()->attach($plant->id);
        }

        return response()->json([
            'message' => '報告が正常に保存されました。',
            'report_id' => $report->id
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:10240', // 10MBまでの画像ファイル
        ]);

        $image = $request->file('photo');
        $imagePath = $image->store('temp', 'public');
        $fullPath = Storage::disk('public')->path($imagePath);

        $base64Image = base64_encode(file_get_contents($fullPath));

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.openai.api_key'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => 'この画像の植物の属名を教えてください。なるべく特定外来植物の可能性を考慮して'
                        ],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => "data:image/jpeg;base64,{$base64Image}"
                            ]
                        ]
                    ]
                ]
            ],
            'max_tokens' => 1000
        ]);

        Storage::disk('public')->delete($imagePath);

        return response()->json($response->json());
    }

    public function list()
    {
        $reports = Report::with('user')->latest()->paginate(6);
        return view('report.list', compact('reports'));
    }
}
