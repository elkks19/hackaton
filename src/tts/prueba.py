import pyttsx3
import os

# Crear el motor de voz
engine = pyttsx3.init()

# Buscar la voz de "Microsoft Sabina"
voices = engine.getProperty('voices')
for voice in voices:
    if "Helena" in voice.name:
        engine.setProperty('voice', voice.id)
        break

# Texto que quieres convertir
texto = input("Escribe el texto que quieres convertir a audio:\n")

# --- TU RUTA FIJA ---
ruta_guardado = r"C:\Users\HP\Desktop\HAKA\repo\hackaton\src\tts\audios"

# Nombre del archivo
nombre_archivo = "audio_generado"

# Crear carpeta si no existe
if not os.path.exists(ruta_guardado):
    os.makedirs(ruta_guardado)

# Construir ruta completa
ruta_completa = os.path.join(ruta_guardado, nombre_archivo + ".wav")

# Configurar velocidad y volumen
engine.setProperty('rate', 150)
engine.setProperty('volume', 1.0)

# Guardar el audio
engine.save_to_file(texto, ruta_completa)

# Ejecutar y cerrar
engine.runAndWait()

print(f"¡Audio guardado en: {ruta_completa}!")
