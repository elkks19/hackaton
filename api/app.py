import subprocess
import os
import sys
import re
import uuid
import shutil
import pyttsx3

def clean_and_flatten_text(text):
    text = text.replace('\n', ' ')
    text = re.sub(r'\s+', ' ', text)
    text = ''.join(c for c in text if 32 <= ord(c) <= 126 or c in 'áéíóúÁÉÍÓÚñÑüÜ ')
    return text.strip()

def process_pdf_to_audio(pdf_path):
    # Crear carpeta única
    unique_id = str(uuid.uuid4())
    output_dir = os.path.join("uploads", unique_id)
    os.makedirs(output_dir, exist_ok=True)

    # Rutas de archivo
    original_pdf_path = os.path.join(output_dir, "documento.pdf")
    output_txt_path = os.path.join(output_dir, "salida.txt")
    dummy_pdf_path = os.path.join(output_dir, "output_dummy.pdf")
    output_mp3_path = os.path.join(output_dir, "salida.mp3")

    # Copiar el PDF original
    shutil.copyfile(pdf_path, original_pdf_path)

    # OCR: Generar archivo de texto
    try:
        subprocess.run([
            "ocrmypdf", "--sidecar", output_txt_path, original_pdf_path, dummy_pdf_path
        ], check=True)
    except subprocess.CalledProcessError:
        print("ERROR: Falló el OCR.")
        sys.exit(1)

    # Leer y limpiar texto
    if not os.path.exists(output_txt_path):
        print("ERROR: No se generó el archivo de texto.")
        sys.exit(1)

    with open(output_txt_path, 'r', encoding='utf-8') as f:
        raw_text = f.read()

    cleaned_text = clean_and_flatten_text(raw_text)

    with open(output_txt_path, 'w', encoding='utf-8') as f:
        f.write(cleaned_text)

    # Generar audio
    engine = pyttsx3.init()
    engine.save_to_file(cleaned_text, output_mp3_path)
    engine.runAndWait()

    # Imprimir la ruta final del MP3 (relativa a PHP)
    print(output_mp3_path)

if __name__ == "__main__":
    if len(sys.argv) != 1 + 1:
        print("Uso: python app.py archivo.pdf")
        sys.exit(1)

    process_pdf_to_audio(sys.argv[1])
