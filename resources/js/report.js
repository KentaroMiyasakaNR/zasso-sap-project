// スクリプトの重複読み込みを防ぐためのフラグ
if (typeof window.reportScriptLoaded === 'undefined') {
    window.reportScriptLoaded = true;

    // DOM elements
    const preview = document.getElementById('preview');
    const imagePreview = document.getElementById('imagePreview');
    const uploadForm = document.getElementById('uploadForm');
    const resultDiv = document.getElementById('result');
    const photoInput = document.getElementById('photo');
    const selectPhotoBtn = document.getElementById('selectPhotoBtn');
    const analyzeBtn = document.getElementById('analyzeBtn');

    // Debug logging function
    function debugLog(message) {
        console.log(`[DEBUG] ${message}`);
    }

    // Function to preview the selected image
    function previewImage(input) {
        debugLog('previewImage called');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                debugLog('FileReader onload called');
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Function to analyze the image
    function analyzeImage(event) {
        debugLog('analyzeImage called');
        event.preventDefault(); // フォームのデフォルトの送信を防ぐ    
        // ファイルが選択されているか確認
        if (!photoInput.files || photoInput.files.length === 0) {
            resultDiv.innerHTML = '<p>写真を選択してください。</p>';
            debugLog('No file selected');
            return;
        }
        
        debugLog('Preparing to send request');
        const formData = new FormData(uploadForm);
        fetch(uploadForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            debugLog('Response received');
            return response.json();
        })
        .then(data => {
            debugLog('Data parsed');
            if (data && data.choices && data.choices[0] && data.choices[0].message) {
                resultDiv.innerHTML = `<p>${data.choices[0].message.content}</p>`;
                debugLog('Result displayed');
            } else {
                console.error('Unexpected data structure:', data);
                resultDiv.innerHTML = '<p>予期しないデータ構造です。管理者に連絡してください。</p>';
                debugLog('Unexpected data structure');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resultDiv.innerHTML = '<p>エラーが発生しました。もう一度お試しください。</p>';
            debugLog('Error occurred: ' + error.message);
        });
    }

    // Event listeners
    function initializeEventListeners() {
        debugLog('Initializing event listeners');
        
        selectPhotoBtn.addEventListener('click', function() {
            debugLog('selectPhotoBtn clicked');
            photoInput.click();
        });

        photoInput.addEventListener('change', function() {
            debugLog('File selected: ' + (this.files[0] ? this.files[0].name : 'No file'));
            previewImage(this);
        });
        
        // フォームの送信イベントを処理
        uploadForm.addEventListener('submit', analyzeImage);
        
        debugLog('Event listeners initialized');
    }

    // Check if elements are correctly loaded
    function checkElements() {
        debugLog('Checking elements');
        debugLog('selectPhotoBtn: ' + (selectPhotoBtn ? 'Found' : 'Not found'));
        debugLog('photoInput: ' + (photoInput ? 'Found' : 'Not found'));
        debugLog('uploadForm: ' + (uploadForm ? 'Found' : 'Not found'));
        debugLog('analyzeBtn: ' + (analyzeBtn ? 'Found' : 'Not found'));
    }

    // DOMContentLoaded イベントリスナーを一度だけ追加
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', onDOMContentLoaded);
    } else {
        onDOMContentLoaded();
    }

    function onDOMContentLoaded() {
        debugLog('DOMContentLoaded event fired');
        checkElements();
        initializeEventListeners();
    }

    // Expose previewImage to global scope if needed
    window.previewImage = previewImage;

    debugLog('Script loaded');
} else {
    console.warn('Report script already loaded. Skipping re-initialization.');
}