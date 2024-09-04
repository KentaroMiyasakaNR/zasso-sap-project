<x-app-layout>
    <x-slot name="header">
        <h2 style="text-align: center; font-size: 24px; color: #333;">
            {{ __('新規報告作成') }}
        </h2>
    </x-slot>
    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div>
            <h2 style="text-align: center; font-size: 20px; color: #333; margin-bottom: 30px;">植物の写真をアップロード</h2>
           
            <div style="display: flex; flex-direction: column; align-items: center;">
                <form id="uploadForm" action="{{ route('report.analyze') }}" method="POST" enctype="multipart/form-data" style="width: 100%; max-width: 300px;">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <input type="file" name="photo" id="photo" accept="image/*" style="display: none;">
                        <button type="button" id="selectPhotoBtn" style="display: inline-block; width: 100%; padding: 12px 24px; background-color: #4CAF50; color: white; text-decoration: none; text-align: center; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer; margin-bottom: 10px;">
                            写真を選択
                        </button>
                    </div>
                   
                    <div id="imagePreview" style="margin-top: 20px; display: none;">
                        <img id="preview" src="#" alt="プレビュー" style="max-width: 100%; height: auto; border-radius: 8px;">
                    </div>
                   
                    <div style="margin-top: 20px;">
                        <button type="submit" id="analyzeBtn" style="display: inline-block; width: 100%; padding: 12px 24px; background-color: #2196F3; color: white; text-decoration: none; text-align: center; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer;">
                            植物を同定
                        </button>
                    </div>
                </form>
                <div id="result" style="margin-top: 20px; text-align: center;"></div>
                <button id="reportBtn" style="display: none; margin-top: 20px; padding: 12px 24px; background-color: #FF5722; color: white; text-decoration: none; text-align: center; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer;">
                    報告する
                </button>
            </div>
        </div>
    </div>

    <!-- モーダル -->
    <div id="reportModal" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 10px;">
            <h2 style="text-align: center; margin-bottom: 20px;">この内容を報告しますか？</h2>
            <img id="modalPreview" src="#" alt="選択した写真" style="max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-around;">
                <button id="confirmReportBtn" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">報告する</button>
                <button id="cancelReportBtn" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">キャンセル</button>
            </div>
        </div>
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/report.js'])
</x-app-layout>