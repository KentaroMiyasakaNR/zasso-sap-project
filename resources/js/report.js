// DOM elements

const preview = document.getElementById('preview');
const imagePreview = document.getElementById('imagePreview');
const uploadForm = document.getElementById('uploadForm');
const resultDiv = document.getElementById('result');
const photoInput = document.getElementById('photo');

// Function to preview the selected image
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            imagePreview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Function to analyze the image
function analyzeImage() {
    console.log('同定分析analyzeImage called');
    const formData = new FormData(uploadForm);
    const analyzeUrl = uploadForm.dataset.analyzeUrl;
    console.log('1');
    fetch(analyzeUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('2');
        if (data && data.choices && data.choices[0] && data.choices[0].message) {
            resultDiv.innerHTML = `<p>${data.choices[0].message.content}</p>`;
        } else {
            console.error('Unexpected data structure:', data);
            resultDiv.innerHTML = '<p>予期しないデータ構造です。管理者に連絡してください。</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        resultDiv.innerHTML = '<p>エラーが発生しました。もう一度お試しください。</p>';
    });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const selectPhotoBtn = document.getElementById('selectPhotoBtn');
    const photoInput = document.getElementById('photo');

    if (selectPhotoBtn && photoInput) {
        selectPhotoBtn.addEventListener('click', function() {
            photoInput.click();
        });
    }

    photoInput.addEventListener('change', () => previewImage(photoInput));
    document.getElementById('analyzeBtn').addEventListener('click', analyzeImage);
});

// Expose previewImage to global scope if needed
window.previewImage = previewImage;