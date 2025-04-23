document.addEventListener("DOMContentLoaded", () => {
    const aujourdhui = new Date().toISOString().split('T')[0];
    document.getElementById("date-reservation").value = aujourdhui;
    document.getElementById("date-reservation").min = aujourdhui;

    // Vérifier les disponibilitées pour aujoutd'hui
    checkAvailability(aujourdhui);

    document.getElementById("check-dispo").addEventListener("click", (e) => {
        e.preventDefault();
        const dateSelectionne =  document.getElementById("date-reservation").value;
        checkAvailability(dateSelectionne);
    });

    // fonction pour vérifier les disponibilités 
    function checkAvailability(date) {
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

    // fonction pour activer les liens de réservation
    function activerLiensReservations(date){
        // supprimer les anciens écouteurs
        const oldLinks = document.querySelectorAll('.book-btn');
        oldLinks.forEach(link => {
            link.replaceWith(link.cloneNode(true));
        });
        // ajouter les nouveaux écouteurs
        document.querySelectorAll('.book-btn').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const heure = this.getAttribute('data-time');
                const table = this.getAttribute('data-table');
                const tableId = table.replace(/\D/g, '');

                console.log("Sélection :", {date, heure, tableId}); // Debug

                // Remplir les champs du formulaire
                document.getElementById('date').value = date;
                document.getElementById('heure').value = heure;

                const tableField = document.getElementById('id_table');
                
                const newOption = new Option(`Table ${tableId}`, tableId, true, true);
                tableField.add(newOption);

                // Activer les champs
                document.getElementById('date').disabled = false;
                document.getElementById('heure').disabled = false;
                tableField.disabled = false;

                
                // Mettre à jour le récapitulatif
                document.getElementById('recap-date').textContent = formatDate(date);
                document.getElementById('recap-time').textContent = heure;
                document.getElementById('recap-table').textContent = table;

                
                // Faire défiler jusqu'au formulaire
                document.getElementById('reservation-form').scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    }
     // fonction pour formater la date
     function formatDate(dateString){
        if (!dateString) return 'Non sélectionnée';
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;
        
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('fr-FR', options);
    }

    // envoie des détails de réservation vers la base de données 
    document.getElementById('booking-form').addEventListener('submit', function(e) {
        e.preventDefault();

        
        const formData = new FormData(this);
        
        fetch('?url=Reservation/store', {
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
                // Recharger les disponibilités
                checkAvailability(document.getElementById('date-reservation').value);
                
                // Redirection vers la page de confirmation
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    // Réinitialisation du formulaire si pas de redirection
                    this.reset();
                    document.getElementById('recap-date').textContent = 'Non sélectionnée';
                    document.getElementById('recap-time').textContent = 'Non sélectionnée';
                    document.getElementById('recap-table').textContent = 'Non sélectionnée';
                }
            } else {
                afficherMessage("Erreur: "+ data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            afficherMessage("Une erreure réseau s\'est produite", 'error');
        });
    });

    // pour afficher les messages et ne pas utiliser des alerts
    function afficherMessage(message, type = "success"){
        const container = document.getElementById("message-container");
        container.textContent = message;
        container.className = `message-container ${type}`;

        setTimeout(() => {
            container.style.display = 'none'
        }, 5000);
    }

    // fonction pour vérifier si le créneau est valide
    function isCreneauValide(date, heure){
        const maint = new Date();
        const [heures, minutes] = heure.split(":").map(Number);
        const dateResa = new Date(date);
        dateResa.setHours(heures, minutes);
        return dateResa >= maint;
    }
})