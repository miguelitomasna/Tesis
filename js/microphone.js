// Función para reconocimiento de comandos de navegación
(function() {
  const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
  if (SpeechRecognition) {
      const navigationRecognition = new SpeechRecognition();
      navigationRecognition.lang = "es-ES";
      navigationRecognition.continuous = false;

      document.getElementById("microphone").addEventListener("click", () => {
          navigationRecognition.start();
      });

      navigationRecognition.onresult = (event) => {
          const command = event.results[0][0].transcript.toLowerCase();
          if (command.includes("dashboard")) {
              window.location.href = "dashboard.php";
          } else if (command.includes("registrar usuario")) {
              window.location.href = "register_user.php";
          } else if (command.includes("reportes")) {
              window.location.href = "report_assistant.php";
          } else if (command.includes("solicitudes")) {
              window.location.href = "manage_requests.php";  // Redirigir a la página de solicitudes
          } else {
              playVoiceMessage("Lamentablemente, la página que ha solicitado no se encuentra disponible.");
          }
      };

      navigationRecognition.onerror = (event) => {
          console.error("Error en reconocimiento de voz de navegación:", event.error);
      };
  }

  function playVoiceMessage(message) {
      const speech = new SpeechSynthesisUtterance();
      speech.text = message;
      speech.lang = "es-ES";
      speech.pitch = 1;
      speech.rate = 1.2; // Ajuste de velocidad
      speech.volume = 1;
      speech.voice = speechSynthesis.getVoices().find(voice => voice.lang === "es-ES" && voice.name.includes("Female"));
      speechSynthesis.speak(speech);
  }
})();
