document.addEventListener('DOMContentLoaded', async function () {
    const logoutButton = document.getElementById('logout');

    // Verificar si el token está disponible en localStorage
    const token = localStorage.getItem('authToken');
    if (!token) {
        console.error("Token no encontrado. Redirigiendo al login...");
        window.location.href = 'login.html';
        return;
    }

    try {
        // Realizar petición al backend para obtener los datos del usuario
        const response = await fetch('http://localhost/api-rest-composer_V2/public/?route=auth', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`, // Enviar el token como header
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            console.error("Error al obtener los datos del usuario. Redirigiendo al login...");
            window.location.href = 'login.html';
            return;
        }

        const userData = await response.json();

        // Mostrar la información del usuario en el dashboard
        document.getElementById('user-name').textContent = userData.nombre || "No disponible";
        document.getElementById('user-email').textContent = userData.correo || "No disponible";
        document.getElementById('user-type').textContent = userData.tipo || "No disponible";

    } catch (error) {
        console.error("Error al procesar la petición:", error);
        window.location.href = 'login.html';
    }

    // Configurar el botón de cerrar sesión
    if (logoutButton) {
        logoutButton.addEventListener('click', function () {
            localStorage.removeItem('authToken'); // Eliminar el token
            console.log("Token eliminado, redirigiendo al login...");
            window.location.href = 'login.html'; // Redirigir al login
        });
    } else {
        console.log("Botón de logout no encontrado");
    }
});