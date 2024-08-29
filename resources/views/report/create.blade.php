@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; min-height: 80vh; background-color: #f0f2f5;">
    <div style="width: 100%; max-width: 500px; background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 30px;">新規報告作成</h2>
        
        <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 20px;">
            <input type="file" name="photo" id="photo" accept="image/*" capture="environment" style="display: none;" onchange="previewImage(this);">
                <label for="photo" style="display: block; font-size: 16px; color: #333; margin-bottom: 10px;">
                    植物の写真をアップロード
                </label>
                <button type="button" onclick="document.getElementById('photo').click();" style="display: inline-block; width: 100%; padding: 12px 24px; background-color: #4CAF50; color: white; text-decoration: none; text-align: center; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer;">
                    写真を撮影/選択
                </button>
            </div>
            
            <div id="imagePreview" style="margin-top: 20px; display: none;">
                <img id="preview" src="#" alt="プレビュー" style="max-width: 100%; height: auto; border-radius: 8px;">
            </div>
            
            <div style="margin-top: 30px;">
                <button type="submit" style="display: inline-block; width: 100%; padding: 12px 24px; background-color: #2196F3; color: white; text-decoration: none; text-align: center; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer;">
                    植物を同定
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    var preview = document.getElementById('preview');
    var previewDiv = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection