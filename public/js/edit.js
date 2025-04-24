document.addEventListener("DOMContentLoaded", () => {
    const aujourdhui = new Date().toISOString().split('T')[0];
    document.getElementById("date-reservation").value = aujourdhui;
    document.getElementById("date-reservation").min = aujourdhui;

    checkAvailability(aujourdhui);

    document.getElementById("check-dispo").addEventListener("click", (e) => {
        e.preventDefault();
        const dateSelectionne =  document.getElementById("date-reservation").value;
        checkAvailability(dateSelectionne);
    });

    function checkAvailability(date) {
        if (!date) return;
        fetch(`?url=Reservation/disponibilites&date=${date}`)
        .then(response => response.text())
        .then(html => {
            // afficher les dispos en fonction de la réponse
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const table = doc.querySelector('table');

            if(table) {
                document.getElementById("resultats-dispos").innerHTML = `
                <h3>Disponibilités pour le ${formatDate(date)}</h3>
                ${table.outerHTML}
                `;

                // activer les liens de réservation
                activerLiensReservations(date);
            }else{
                document.getElementById("resultats-dispos").innerHTML = `
                 <p>Aucune disponibilité trouvée pour cette date.</p>
                `; 
            }
        })
        .catch(error => {
            console.error("Errueur:", error);
            document.getElementById("resultats-dispos").innerHTML = `<p>Une erreur s'est produite lors de la récupération des disponibilités.</p>`;
        });
    }

    function activerLiensReservations(date) {
        const oldButtons = document.querySelectorAll('.book-btn');
        oldButtons.forEach(btn => {
            btn.replaceWith(btn.cloneNode(true));
        });

        document.querySelectorAll('.book-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const heure = this.getAttribute('data-time');
                const table = this.getAttribute('data-table');
                const tableId = `${table}`;

                // Ajouter le créneau au formulaire
                document.getElementById('date').value = date;
                document.getElementById('heure').value = heure;
                const tableField = document.getElementById('id_table');
                tableField.innerHTML = '';
                const newOption = new Option(`Table ${tableId}`, tableId, true, true);
                tableField.add(newOption);


                document.getElementById('date').disabled = false;
                document.getElementById('heure').disabled = false;
                tableField.disabled = false;

                document.getElementById('edit-form').scrollIntoView({ behavior: 'smooth' });
            });
        });
    }

    function formatDate(dateString) {
        if (!dateString) return 'Non sélectionnée';
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('fr-FR', options);
    }

    document.getElementById('edit-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('?url=Reservation/update', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau');
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
                    afficherMessage("Erreur: " + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                afficherMessage("Une erreur réseau s'est produite", 'error');
            });
    });

    // Fonction pour afficher les messages
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