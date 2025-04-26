document.addEventListener("DOMContentLoaded", () => {
    const profileForm = document.getElementById('profile-form');
    const mdpForm = document.getElementById("change-password-form");

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
                        afficherMessage(data.message, 'success', 'message-container');
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    } else {
                        afficherMessage('Erreur: ' + data.message, 'error', 'message-container');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    afficherMessage('Une erreur s\'est produite: ' + error.message, 'error', 'message-container');
                });
        });
    }

    if (mdpForm) {
        mdpForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const messageContainer = document.getElementById('password-message-container');
            messageContainer.innerHTML = '';
            messageContainer.style.display = 'none';

            // Validation côté client
            const newPassword = document.getElementById("new_password").value;
            const confirmPassword = document.getElementById("confirm_password").value;

            if (newPassword !== confirmPassword) {
                afficherMessage("Les mots de passe ne correspondent pas", "error", "password-message-container");
                return;
            }

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                const contentType = response.headers.get('content-type');
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error('Erreur réseau: ' + text.substring(0, 100));
                    });
                }
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    return response.text().then(text => {
                        throw new Error('Réponse non-JSON: ' + text.substring(0, 100));
                    });
                }
            })
            .then(data => {
                if (data.success) {
                    afficherMessage(data.message, 'success', 'password-message-container');
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1500);
                    } else {
                        this.reset();
                    }
                } else {
                    afficherMessage(data.message, 'error', 'password-message-container');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                afficherMessage('Une erreur est survenue: ' + error.message, 'error', 'password-message-container');
            });
        });
    }

    function afficherMessage(message, type = "success", containerId = "message-container") {
        const container = document.getElementById(containerId);
        container.textContent = message;
        container.className = `message-container ${type}`;
        container.style.display = 'block';

        setTimeout(() => {
            container.style.display = 'none';
        }, 5000);
    }
});