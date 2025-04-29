<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>APRECIA - Apoyo para Niños con Discapacidad Visual</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'naranja': {
              100: '#FFF0E6',
              200: '#FFD9BF',
              300: '#FFC299',
              400: '#FFAB73',
              500: '#FF944D',
              600: '#FF7D26',
              700: '#FF6600',
              800: '#CC5200',
              900: '#993D00'
            }
          }
        }
      }
    }
  </script>
</head>

<body class="bg-gray-50 text-gray-800">
  <!-- Header -->
  <header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <!-- Iniciar sesión -->
      <a href="login.php" class="text-naranja-700 font-semibold hover:text-naranja-800 transition">Iniciar sesión</a>
      <!-- Logo o nombre -->
      <h1 class="text-2xl font-bold text-naranja-700">APRECIA</h1>
      <!-- Espacio derecho (puedes poner un botón más adelante) -->
      <div class="text-naranja-700 hover:text-naranja-800">
        <a href="src/inicio.php">Juegos</a>
      </div>
    </div>
  </header>

  <!-- Hero -->
  <section class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
    <div>
      <h2 class="text-4xl font-bold text-naranja-700 mb-4">Transformando vidas a través de nuevas perspectivas</h2>
      <p class="text-lg text-gray-600 mb-6">
        En APRECIA creemos que cada niño merece descubrir el mundo a su manera. Ofrecemos apoyo especializado para niños con discapacidad visual, ayudándoles a desarrollar todo su potencial.
      </p>
      <a href="#servicios" class="bg-naranja-600 text-white px-6 py-3 rounded-xl shadow hover:bg-naranja-700 transition">Conoce nuestros programas</a>
    </div>
    <div class="flex justify-center">
      <!-- LOGO DE APRECIA - REEMPLAZA LA RUTA POR LA TUYA -->
      <img 
        src="src/img/logo-aprecia.png" 
        alt="Logo APRECIA" 
        class="h-48 object-contain"
      >
    </div>
  </section>

  <!-- Información Motivadora -->
  <section id="servicios" class="bg-naranja-100 py-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h3 class="text-3xl font-bold text-naranja-800 mb-12">Descubriendo un mundo de posibilidades</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-t-4 border-naranja-500">
          <h4 class="text-xl font-semibold mb-2 text-naranja-700">Más allá de la vista</h4>
          <p class="text-gray-600">La discapacidad visual no es un límite, sino una invitación a explorar el mundo a través de otros sentidos, desarrollando habilidades únicas y valiosas.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-t-4 border-naranja-500">
          <h4 class="text-xl font-semibold mb-2 text-naranja-700">Aprendizaje inclusivo</h4>
          <p class="text-gray-600">Cada niño tiene un ritmo y estilo de aprendizaje propio. Nuestros métodos adaptados potencian sus capacidades y celebran sus logros individuales.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-t-4 border-naranja-500">
          <h4 class="text-xl font-semibold mb-2 text-naranja-700">Comunidad y apoyo</h4>
          <p class="text-gray-600">Creamos espacios donde familias y niños comparten experiencias, celebran avances y construyen juntos un futuro lleno de oportunidades.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Programas -->
  <section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
      <h3 class="text-3xl font-bold text-naranja-700 mb-10 text-center">Nuestros Programas</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div class="flex gap-4">
          <div class="text-naranja-600 text-4xl font-bold">01</div>
          <div>
            <h4 class="text-xl font-semibold mb-2 text-naranja-700">Estimulación temprana</h4>
            <p class="text-gray-600">Trabajamos con bebés y niños pequeños para desarrollar sus habilidades sensoriales desde las primeras etapas, estableciendo bases sólidas para su desarrollo.</p>
          </div>
        </div>
        <div class="flex gap-4">
          <div class="text-naranja-600 text-4xl font-bold">02</div>
          <div>
            <h4 class="text-xl font-semibold mb-2 text-naranja-700">Lectoescritura Braille</h4>
            <p class="text-gray-600">Enseñamos el sistema Braille de manera divertida y adaptada a cada edad, abriendo las puertas al mundo de la literatura y el conocimiento.</p>
          </div>
        </div>
        <div class="flex gap-4">
          <div class="text-naranja-600 text-4xl font-bold">03</div>
          <div>
            <h4 class="text-xl font-semibold mb-2 text-naranja-700">Orientación y movilidad</h4>
            <p class="text-gray-600">Desarrollamos técnicas que permiten a los niños desplazarse con seguridad y autonomía, explorando su entorno con confianza.</p>
          </div>
        </div>
        <div class="flex gap-4">
          <div class="text-naranja-600 text-4xl font-bold">04</div>
          <div>
            <h4 class="text-xl font-semibold mb-2 text-naranja-700">Tecnología adaptativa</h4>
            <p class="text-gray-600">Introducimos herramientas tecnológicas que facilitan el aprendizaje y la comunicación, preparando a los niños para un mundo cada vez más digital.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonio -->
  <section class="bg-naranja-600 text-white py-16">
    <div class="max-w-3xl mx-auto px-6 text-center">
      <div class="text-5xl font-serif mb-6">"</div>
      <p class="text-xl italic mb-8">Ver el mundo a través del tacto, el oído y el corazón les ha dado a nuestros niños una perspectiva única y valiosa. No se trata de lo que no pueden ver, sino de todo lo que pueden sentir.</p>
      <p class="font-semibold">Laura Méndez, Directora de APRECIA</p>
    </div>
  </section>    
    </div>
  </footer>
</body>
</html>
