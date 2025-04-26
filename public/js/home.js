document.addEventListener("DOMContentLoaded", () => {
    loadMenuItems();

    animationScroll();

    effetsHover();

    function loadMenuItems(){
        fetch('?url=Menu/apiMenu')
        .then(response => response.json())
        .then(data => {
            const menuContainer = document.getElementById('menu-preview');
            
            // Prendre 3 plats aléatoires (ou les 3 premiers si moins de 3)
            const featuredItems = data.plats.slice(0, 3);
            
            menuContainer.innerHTML = featuredItems.map(item => `
                <div class="menu-item">
                    ${item.image_url ? `<img src="${item.image_url}" alt="${item.nom}">` : ''}
                    <div class="item-info">
                        <h3>${item.nom}</h3>
                        <p class="description">${item.description}</p>
                        <p class="prix">${item.prix} €</p>
                        <p class="categorie">${item.category_name}</p>
                    </div>
                </div>
            `).join('');
        })
        .catch(error => {
            console.error("Erreur lors du chargement du menu:", error);
            document.getElementById('menu-preview').innerHTML = `
                <p class="error-message">Nous rencontrons des difficultés pour charger notre menu. Veuillez réessayer plus tard.</p>
            `;
        });
    }

    function animationScroll(){
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });
    
        document.querySelectorAll('.hist, .quote, .menu-preview').forEach(section => {
            observer.observe(section);
        });
    }

    function effetsHover(){
        document.addEventListener('mouseover', (e) => {
            if (e.target.closest('.menu-item')) {
                const item = e.target.closest('.menu-item');
                item.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)';
                item.querySelector('img').style.transform = 'scale(1.05)';
            }
        });
    
        document.addEventListener('mouseout', (e) => {
            if (e.target.closest('.menu-item')) {
                const item = e.target.closest('.menu-item');
                item.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
                item.querySelector('img').style.transform = 'scale(1)';
            }
        });
    }
  
});