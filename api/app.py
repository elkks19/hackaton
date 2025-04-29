from flask import Flask, request, send_from_directory, jsonify
from flask_cors import CORS
import os
import subprocess
from werkzeug.utils import secure_filename

app = Flask(__name__)
CORS(app, resources={r"/*": {"origins": "http://localhost:8000"}})

UPLOAD_FOLDER = 'uploads'
AUDIO_FOLDER = os.path.join(UPLOAD_FOLDER, 'audio')
PDF_FOLDER = os.path.join(UPLOAD_FOLDER, 'pdfs')

# Crear carpetas si no existen
os.makedirs(AUDIO_FOLDER, exist_ok=True)
os.makedirs(PDF_FOLDER, exist_ok=True)

@app.route('/audios/<filename>', methods=['GET'])
def download_audio(filename):
    return send_from_directory(AUDIO_FOLDER, filename, as_attachment=True)

@app.route('/upload', methods=['POST'])
def upload_pdf():
    if 'file' not in request.files:
        return jsonify({"error": "No file part in the request"}), 400
    
    file = request.files['file']
    if file.filename == '':
        return jsonify({"error": "No file selected"}), 400

    filename = secure_filename(file.filename)
    pdf_path = os.path.join(PDF_FOLDER, filename)
    file.save(pdf_path)

    # Generar ruta del archivo .txt a crear
    base_filename = os.path.splitext(filename)[0]
    txt_output_path = os.path.join(PDF_FOLDER, f"{base_filename}.txt")

    # Ejecutar ocrmypdf con la opción --sidecar
    try:
        subprocess.run([
            "ocrmypdf", "--sidecar", txt_output_path, pdf_path, "/dev/null"
        ], check=True)
    except subprocess.CalledProcessError as e:
        return jsonify({"error": "OCR failed", "details": str(e)}), 500

    return jsonify({"message": "PDF uploaded and processed", "text_file": f"{base_filename}.txt"}), 200

if __name__ == '__main__':
    app.run(debug=True)
