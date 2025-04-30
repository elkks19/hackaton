import sys
import os
import subprocess
from gtts import gTTS

def extraer_texto_de_pdf(pdf_path, sidecar_txt):
    """Intenta extraer texto usando OCR; si ya hay texto, usa pdftotext."""
    try:
        # Ejecuta ocrmypdf normalmente
        subprocess.run([
            "ocrmypdf",
            "--sidecar", sidecar_txt,
            "--skip-text",  # Evita sobreescribir si ya tiene texto
            pdf_path,
            os.devnull  # Ignoramos el PDF de salida
        ], check=True)
    except subprocess.CalledProcessError as e:
        if e.returncode == 6:
            # El código 6 indica que ya tenía texto
            print("El PDF ya tiene texto, extrayendo sin OCR...")
            try:
                subprocess.run([
                    "pdftotext",
                    "-layout",  # Mantiene un mejor formato
                    pdf_path,
                    sidecar_txt
                ], check=True)
            except subprocess.CalledProcessError as e2:
                print("Error extrayendo texto del PDF:", e2)
                sys.exit(1)
        else:
            print("Error ejecutando ocrmypdf:", e)
            sys.exit(1)

def convertir_pdf_a_audio(pdf_path):
    if not os.path.exists(pdf_path):
        print("PDF no encontrado.")
        sys.exit(1)

    base_name = os.path.splitext(pdf_path)[0]
    sidecar_txt = base_name + "_ocr.txt"
    salida_mp3 = base_name + ".mp3"

    extraer_texto_de_pdf(pdf_path, sidecar_txt)

    # Leer el texto extraído
    try:
        with open(sidecar_txt, 'r', encoding='utf-8') as f:
            texto = f.read()
    except Exception as e:
        print("Error leyendo el archivo de texto:", e)
        sys.exit(1)

    if not texto.strip():
        print("El texto extraído está vacío.")
        sys.exit(1)

    # Convertir texto a audio
    try:
        tts = gTTS(text=texto, lang='es')
        tts.save(salida_mp3)
    except Exception as e:
        print("Error al generar audio:", e)
        sys.exit(1)

    print("Audio generado:", salida_mp3)

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Uso: python3 app.py archivo.pdf")
        sys.exit(1)

    convertir_pdf_a_audio(sys.argv[1])
