// Inicializar reconocimiento de voz
const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
const recognition = new SpeechRecognition();
recognition.lang = 'es-ES';
recognition.continuous = false;
recognition.interimResults = false;

let currentUser = ''; // Nombre del usuario
let currentRecipient = ''; // Destinatario (Técnico, Sistemas, Base de Datos)
let currentProblem = ''; // Problema descrito
let problemType = ''; // Tipo de problema (Técnico, MPFN2, BD)
let uploadedImage = null; // Imagen subida
let recipientEmail = ''; // Correo del destinatario

// Función para iniciar el reconocimiento de voz
function startRecognition() {
    recognition.start();

    recognition.onstart = function() {
        console.log("Reconocimiento de voz iniciado");
    };

    recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        console.log("Reconocido: ", transcript);

        // Manejar el caso de capturar nombre del usuario
        if (currentUser === '') {
            currentUser = transcript;
            sendMessage(`Hola ${currentUser}, ¿a quién quieres enviar el mensaje? (Técnico, Sistemas o Base de Datos)`);
        }
        // Manejar el caso de capturar el destinatario
        else if (currentRecipient === '') {
            currentRecipient = transcript.toLowerCase();
            if (currentRecipient === 'técnico') {
                problemType = 'Técnico'; // Asignar tipo de problema
                recipientEmail = 'atenciodelacruzmiguelangel@gmail.com'; // Correo del destinatario
                sendMessage(`El mensaje se enviará al Técnico. Su correo es ${recipientEmail}. Ahora, por favor, dime tu problema.`);
            } else if (currentRecipient === 'sistemas') {
                problemType = 'MPFN2'; // Asignar tipo de problema
                recipientEmail = 'mpfnlima96@gmail.com'; // Correo del destinatario
                sendMessage(`El mensaje se enviará a Sistemas. Su correo es ${recipientEmail}. Ahora, por favor, dime tu problema.`);
            } else if (currentRecipient === 'base de datos') {
                problemType = 'BD'; // Asignar tipo de problema
                recipientEmail = 'ingenierobasedato@gmail.com'; // Correo del destinatario
                sendMessage(`El mensaje se enviará a Base de Datos. Su correo es ${recipientEmail}. Ahora, por favor, dime tu problema.`);
            } else {
                sendMessage("No reconozco a ese destinatario, por favor, di: Técnico, Sistemas o Base de Datos.");
                currentRecipient = ''; // Reintentar
            }
        }
        // Manejar el caso de capturar el problema
        else if (currentProblem === '') {
            currentProblem = transcript;
            sendMessage(`Tu problema es: ${currentProblem}.`, true); // Primero enviar el problema

            // Mostrar el tipo de problema capturado
            sendMessage(`El tipo de problema detectado es: ${problemType}.`, true);

            // Leer en voz alta el análisis del problema
            speakMessage(`Analizando tu problema, veo que es de tipo "${problemType}".`, true);

            // Luego, leer en voz alta la instrucción sobre la imagen
            speakMessage("Esto sería todo, si deseas adjuntar una imagen, puedes hacerlo desde el ícono de adjuntar archivo.", false);
        }
        // Si se menciona la imagen
        else if (uploadedImage === null) {
            sendMessage("Por favor, adjunta una imagen si lo deseas.");
        }
    };

    recognition.onerror = function(event) {
        console.log("Error de reconocimiento: ", event.error);
    };
}

// Función para enviar mensajes al chat
function sendMessage(message, skipSpeech = false) {
    const chatBox = document.querySelector('.chat-box');
    const newMessage = document.createElement('div');
    newMessage.classList.add('chat-message');
    newMessage.innerHTML = `<strong>IA:</strong> ${message}`;
    chatBox.appendChild(newMessage);
    chatBox.scrollTop = chatBox.scrollHeight;

    if (!skipSpeech) {
        speakMessage(message);
    }
}

// Función para leer el mensaje con voz femenina
function speakMessage(message, isImmediate = false) {
    const speech = new SpeechSynthesisUtterance(message);
    speech.lang = 'es-ES';
    speech.voice = speechSynthesis.getVoices().find(voice => voice.name === 'Google español femenino');
    if (isImmediate) {
        speechSynthesis.speak(speech); // Inmediatamente habla el mensaje
    } else {
        setTimeout(() => {
            speechSynthesis.speak(speech); // Hablar después de un pequeño retardo
        }, 1000); // Retardo de 1 segundo para que el mensaje sea claro
    }
}

// Función para manejar la carga de archivos
function uploadFile() {
    const fileInput = document.getElementById('attachFile');
    const file = fileInput.files[0];
    
    if (file) {
        const chatBox = document.querySelector('.chat-box');
        uploadedImage = file; // Guardamos la imagen

        // Obtener el tamaño del archivo en bytes
        const fileSize = file.size; // Tamaño del archivo en bytes
        const maxSize = 10 * 1024 * 1024; // 10 MB en bytes

        // Verificar si el tamaño del archivo es mayor al máximo permitido
        if (fileSize > maxSize) {
            // Si el archivo es demasiado grande, mostrar un mensaje de error
            sendMessage("Error: La imagen es demasiado grande. El tamaño máximo permitido es de 10 MB.");
            uploadedImage = null; // Limpiar la variable de la imagen
            return; // Detener el procesamiento del archivo
        }

        // Crear contenedor de mensaje para mostrar el archivo
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('d-flex', 'align-items-center', 'my-2');

        // Comprobar tipo de archivo y crear vista previa
        const fileType = file.type;
        const fileName = file.name;
        const fileSizeKB = (fileSize / 1024).toFixed(2); // Convertir tamaño a KB

        let filePreview = '';
        if (fileType.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                filePreview = `<img src="${e.target.result}" alt="${fileName}" class="img-thumbnail" style="max-width: 100px;">`;
                messageContainer.innerHTML = `<div class="me-2">${filePreview}</div><span>${fileName} (${fileSizeKB} KB)</span>`;
                chatBox.appendChild(messageContainer);
            };
            reader.readAsDataURL(file);
        }

        chatBox.scrollTop = chatBox.scrollHeight;
    }
}

function sendData(event) {
    event.preventDefault();

    // Crear un nuevo FormData para enviar los datos por POST
    let formData = new FormData();
    formData.append('nombre_usuario', currentUser);  // Suponiendo que 'currentUser' ya tiene el valor
    formData.append('destinatario', currentRecipient);  // Suponiendo que 'currentRecipient' tiene el valor
    formData.append('tipo_problema', problemType);  // Suponiendo que 'problemType' tiene el valor
    formData.append('problema_descrito', currentProblem);  // Suponiendo que 'currentProblem' tiene el valor
    formData.append('correo_destinatario', recipientEmail);  // Suponiendo que 'recipientEmail' tiene el valor

    // Verificar si se ha cargado una imagen adjunta
    if (uploadedImage) {
        formData.append('imagen_adjunto', uploadedImage);  // 'uploadedImage' debe ser un archivo (File)
    }

    // Enviar los datos a M_Send_Problem.php usando fetch
    fetch('../models/M_Send_Problem.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())  // Obtener la respuesta del servidor como texto
    .then(data => {
        console.log(data);  // Mostrar la respuesta (puedes mostrar un mensaje al usuario si es necesario)
        sendMessage("Problema registrado correctamente.");  // Mostrar un mensaje de éxito
    })
    .catch(error => {
        console.error('Error al enviar el problema:', error);  // Manejar cualquier error
        sendMessage("Hubo un error al enviar el problema. Por favor, intenta de nuevo.");
    });
}

function reloadPage() {
    window.location.reload();  // Recarga la página sin que se vea el proceso
}

// Evento para iniciar el reconocimiento de voz
const micButton = document.querySelector('.bi-mic');
micButton.addEventListener('click', () => {
    startRecognition();
});

// Agregar mensaje inicial al chat pidiendo el nombre de usuario
sendMessage('Por favor, di tu nombre de usuario.', true);
