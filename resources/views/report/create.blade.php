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
                <form id="uploadForm" enctype="multipart/form-data" style="width: 100%; max-width: 300px;" data-analyze-url="{{ route('report.analyze') }}">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <input type="file" name="photo" id="photo" accept="image/*" style="display: none;">
                        <button type="button" id="selectPhotoBtn" style="display: inline-block; width: 100%; padding: 12px 24px; background-color: #4CAF50; color: white; text-decoration: none; text-align: center; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer; margin-bottom: 10px;">
                            写真を選択
                        </button>
                        <button type="button" id="takePictureBtn" style="display: inline-block; width: 100%; padding: 12px 24px; background-color: #FF9800; color: white; text-decoration: none; text-align: center; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer;">
                            写真を撮影
                        </button>
                    </div>
                   
                    <div id="imagePreview" style="margin-top: 20px; display: none;">
                        <img id="preview" src="#" alt="プレビュー" style="max-width: 100%; height: auto; border-radius: 8px;">
                    </div>
                   
                    <div style="margin-top: 20px;">
                        <button type="button" id="analyzeBtn" style="display: inline-block; width: 100%; padding: 12px 24px; background-color: #2196F3; color: white; text-decoration: none; text-align: center; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer;">
                            植物を同定
                        </button>
                    </div>
                </form>
                <div id="result" style="margin-top: 20px; text-align: center;"></div>
            </div>
        </div>
    </div>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/report.js'])
</x-app-layout>