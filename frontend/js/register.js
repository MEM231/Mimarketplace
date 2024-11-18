document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('register-form');
    console.log(form);
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita el comportamiento predeterminado

        const formData = new FormData(form);
        const data = {
            nombre: formData.get('nombre'),
            correo: formData.get('correo'),
            contrasena: formData.get('contrasena'),
            tipo: formData.get('tipo'),
            accion: 'registro'
        };

        fetch('http://localhost/api-rest-composer_V2/public/?route=auth', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'OK') {
                alert('Registro exitoso');
                form.reset();  // Limpiar el formulario después de un registro exitoso
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al conectar con el servidor:', error);
            alert('Error al conectar con el servidor');
        });
    });
});