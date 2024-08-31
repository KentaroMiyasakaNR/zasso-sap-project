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
                <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" style="width: 100%; max-width: 300px;">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <input type="file" name="photo" id="photo" accept="image/*" style="display: none;" onchange="previewImage(this);">
                        <button type="button" onclick="document.getElementById('photo').click();" style="display: inline-block; width: 100%; padding: 12px 24px; background-color: #4CAF50; color: white; text-decoration: none; text-align: center; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer; margin-bottom: 10px;">
                            写真を選択
                        </button>
                        <button type="button" onclick="takePicture();" style="display: inline-block; width: 100%; padding: 12px 24px; background-color: #FF9800; color: white; text-decoration: none; text-align: center; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer;">
                            写真を撮影
                        </button>
                    </div>
                    
                    <div id="imagePreview" style="margin-top: 20px; display: none;">
                        <img id="preview" src="#" alt="プレビュー" style="max-width: 100%; height: auto; border-radius: 8px;">
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <button type="submit" style="display: inline-block; width: 100%; padding: 12px 24px; background-color: #2196F3; color: white; text-decoration: none; text-align: center; border-radius: 25px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; cursor: pointer;">
                            植物を同定
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function takePicture() {
        navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            var video = document.createElement('video');
            document.body.appendChild(video);
            video.srcObject = stream;
            video.play();

            var canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            setTimeout(function() {
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                var imageDataUrl = canvas.toDataURL('image/jpeg');
                document.getElementById('preview').src = imageDataUrl;
                document.getElementById('imagePreview').style.display = 'block';

                // 撮影した画像をファイル入力に設定
                fetch(imageDataUrl)
                    .then(res => res.blob())
                    .then(blob => {
                        const file = new File([blob], "camera_photo.jpg", { type: "image/jpeg" });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        document.getElementById('photo').files = dataTransfer.files;
                    });

                stream.getTracks().forEach(track => track.stop());
                document.body.removeChild(video);
            }, 1000);
        })
        .catch(function(error) {
            console.error("カメラにアクセスできません: ", error);
            alert("カメラにアクセスできません。デバイスの設定を確認してください。");
        });
    }
    </script>
</x-app-layout>