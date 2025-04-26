document.addEventListener('DOMContentLoaded', () => {
    const menuGrid = document.getElementById('menu-grid');
    const categorieSelect = document.getElementById('select-categorie');
    
    // Charger initialement tout le menu
    loadMenuData();

    // Écouter les changements de catégorie
    categorieSelect.addEventListener('change', () => {
        loadMenuData(categorieSelect.value);
    });

    function loadMenuData(categorieId = '') {
        let url = '?url=Menu/apiMenu';
        if (categorieId) url += `&cat=${categorieId}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                updateCategorieFilter(data.categories);
                renderMenu(data.plats);
            })
            .catch(error => {
                console.error('Erreur:', error);
                menuGrid.innerHTML = '<p>Erreur lors du chargement du menu</p>';
            });
    }

    function updateCategorieFilter(categories) {
        // Garder la sélection actuelle
        const currentValue = categorieSelect.value;
        
        // Reconstruire les options
        categorieSelect.innerHTML = `
            <option value="">Toutes les catégories</option>
            ${categories.map(cat => `
                <option value="${cat.id}" ${cat.id == currentValue ? 'selected' : ''}>
                    ${cat.nom}
                </option>
            `).join('')}
        `;
    }

    function renderMenu(plats) {
        menuGrid.innerHTML = plats.map(plat => `
            <div class="menu-item">
                ${plat.image_url ? `<img src="${plat.image_url}" alt="${plat.nom}">` : ''}
                <div class="item-info">
                    <h3>${plat.nom}</h3>
                    <p class="description">${plat.description}</p>
                    <p class="prix">${plat.prix.toFixed(2)} €</p>
                </div>
            </div>
        `).join('');
    }

});