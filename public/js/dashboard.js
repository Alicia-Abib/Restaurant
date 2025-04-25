document.addEventListener("DOMContentLoaded", () => {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const reservationId = button.getAttribute('data-id');
            const form = button.closest('form');

            // Créer un model de confirmation
            const modalOverlay = document.createElement('div');
            modalOverlay.className = 'modal-overlay';
            modalOverlay.innerHTML = `
                <div class="modal">
                    <h3>Confirmer la suppression</h3>
                    <p>Êtes-vous sûr de vouloir supprimer cette réservation ? Cette action est irréversible.</p>
                    <div class="modal-buttons">
                        <button class="modal-btn modal-btn-cancel">Annuler</button>
                        <button class="modal-btn modal-btn-confirm">Confirmer</button>
                    </div>
                </div>
            `;

            // Ajout du model
            document.body.appendChild(modalOverlay);

            // Animation de l'affichage
            setTimeout(() => {
                modalOverlay.classList.add('show');
            }, 10);

            // Gérer le bouton d'annulation
            modalOverlay.querySelector('.modal-btn-cancel').addEventListener('click', () => {
                modalOverlay.classList.remove('show');
                setTimeout(() => {
                    modalOverlay.remove();
                }, 300);
            });

            // envoit de la confirmation
            modalOverlay.querySelector('.modal-btn-confirm').addEventListener('click', () => {
                form.submit();
            });

            // Fermer le model après selection
            modalOverlay.addEventListener('click', (e) => {
                if (e.target === modalOverlay) {
                    modalOverlay.classList.remove('show');
                    setTimeout(() => {
                        modalOverlay.remove();
                    }, 300);
                }
            });
        });
    });

    // logique menu
    const menuToggle = document.querySelector(".toggle");
    const menuDrop = document.querySelector(".menu-drop");

    if(menuDrop && menuToggle){
        menuToggle.addEventListener('click', (e) => {
            e.preventDefault();
            menuDrop.classList.toggle("show");
        });

        // fermer le menu en cas de clique dehors
        document.addEventListener("click", (e) => {
            if(!menuToggle.contains(e.target) && !menuDrop.contains(e.target)){
                menuDrop.classList.remove("show");
            }
        });

        // fermer lors du clique sur un item
        menuDrop.querySelectorAll(".menu-item").forEach(item => {
            item.addEventListener("click", () => {
                menuDrop.classList.remove("show");
            });
        })
    }

});