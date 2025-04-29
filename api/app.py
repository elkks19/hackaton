import subprocess
import os
import sys
import uuid
from gtts import gTTS

def process_pdf(pdf_path):
    output_id = str(uuid.uuid4())
    work_dir = os.path.join("uploads", output_id)
    os.makedirs(work_dir, exist_ok=True)

    input_pdf = os.path.join(work_dir, "input.pdf")
    output_txt = os.path.join(work_dir, "text.txt")
    output_dummy_pdf = os.path.join(work_dir, "dummy.pdf")
    output_mp3 = os.path.join(work_dir, "audio.mp3")

    # Copiar PDF a carpeta
    os.rename(pdf_path, input_pdf)

    try:
        subprocess.run(["ocrmypdf", "--sidecar", output_txt, input_pdf, output_dummy_pdf], check=True)
    except Exception as e:
        print(f"OCR error: {e}", file=sys.stderr)
        sys.exit(1)

    if not os.path.exists(output_txt):
        print("OCR no generó texto", file=sys.stderr)
        sys.exit(1)

    with open(output_txt, "r", encoding="utf-8") as f:
        text = f.read().strip()

    if not text:
        print("Texto vacío", file=sys.stderr)
        sys.exit(1)

    try:
        tts = gTTS(text, lang='es')
        tts.save(output_mp3)
    except Exception as e:
        print(f"gTTS error: {e}", file=sys.stderr)
        sys.exit(1)

    print(os.path.abspath(output_mp3))

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Uso: python3 app.py archivo.pdf", file=sys.stderr)
        sys.exit(1)

    process_pdf(sys.argv[1])
