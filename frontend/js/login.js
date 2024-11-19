document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita que el formulario se envíe de forma tradicional

    const correo = document.getElementById('correo').value;
    const contrasena = document.getElementById('contrasena').value;

    // Configuración del cuerpo de la solicitud (JSON)
    const data = {
        correo: correo,
        contrasena: contrasena,
        accion: 'login'
    };

    // Realizar la solicitud POST al backend
    fetch('http://localhost/api-rest-composer_V2/public/?route=auth', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            // Puedes añadir la cabecera Authorization si es necesario
            // 'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'ERROR') {
            document.getElementById('error-message').textContent = data.message;
            document.getElementById('error-message').style.display = 'block';
        } else {
            // El login fue exitoso, guarda el token o haz algo con él
            const token = data.data.token;
            localStorage.setItem('authToken', token); // Guarda el token en el almacenamiento local
            alert(data.message); // Muestra un mensaje de éxito
            window.location.href = 'dashboard.html'; // Redirige a la página de dashboard (ajusta según tu estructura)
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
    });
});