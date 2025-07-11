const uploadArea = document.getElementById('upload-area');
const fileInput = document.getElementById('fileInput');

uploadArea.addEventListener('dragover', (e) => {
e.preventDefault();
uploadArea.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', () => {
uploadArea.classList.remove('dragover');
});

uploadArea.addEventListener('drop', (e) => {
e.preventDefault();
uploadArea.classList.remove('dragover');
const file = e.dataTransfer.files[0];
if (file) {
    fileInput.files = e.dataTransfer.files;
    console.log('Imagem arrastada:', file.name);
}
});

fileInput.addEventListener('change', () => {
const file = fileInput.files[0];
if (file) {
    console.log('Imagem selecionada:', file.name);
}
});