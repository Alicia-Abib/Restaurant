document.addEventListener('DOMContentLoaded', () => {
    // Chargement des plats du menu
    fetch('/api/menu')  // URL de ton API pour récupérer les plats
        .then(response => response.json())
        .then(data => {
            const platsContainer = document.getElementById('plats-container');
            data.forEach(plat => {
                const platElement = document.createElement('div');
                platElement.classList.add('plat');
                platElement.innerHTML = `
                    <h3>${plat.nom}</h3>
                    <p>${plat.description}</p>
                    <p>Prix: ${plat.prix} €</p>
                    <p>Catégorie: ${plat.category_name}</p>
                `;
                platsContainer.appendChild(platElement);
            });
        })
        .catch(error => {
            console.error('Erreur lors du chargement du menu:', error);
        });
});
