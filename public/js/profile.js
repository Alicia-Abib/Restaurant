document.addEventListener("DOMContentLoaded", ()=> {
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('?url=Client/update', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Response Status:', response.status);
                    console.log('Content-Type:', response.headers.get('content-type'));
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error('Erreur réseau: ' + text.substring(0, 100));
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        afficherMessage(data.message, 'success');
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    } else {
                        afficherMessage('Erreur: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    afficherMessage('Une erreur s\'est produite: ' + error.message, 'error');
                });
        });
    }

    function afficherMessage(message, type = "success") {
        const container = document.getElementById("message-container");
        container.textContent = message;
        container.className = `message-container ${type}`;
        container.style.display = 'block';

        setTimeout(() => {
            container.style.display = 'none';
        }, 5000);
    }
});