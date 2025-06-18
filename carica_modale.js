document.addEventListener('DOMContentLoaded', function () {
    function caricaCarrello() {
        fetch('modale_carrello.php')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('carrello-content');
                container.innerHTML = '';
                
                if (data.error) {
                    container.innerHTML = `<p>Errore userId</p>`;
                    document.getElementById('accedi').addEventListener('click', () => {
                        window.location.href = 'login.php';
                    });
                    return;
                }

                if (data.items.length === 0) {
                    container.innerHTML = '<p>Il tuo carrello è vuoto</p>';
                    return;
                }

                data.items.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'item-carrello';
                    div.innerHTML = `
                        <img src="${item.copertina_url}" width="50">
                        <span>${item.titolo}</span>
                        <span class="prezzo">${item.prezzo} €</span>
                    `;
                    container.appendChild(div);
                });
            })
            .catch(error => {
                console.error('Errore:', error);
                document.getElementById('carrello-content').innerHTML = 
                    '<p>Errore nel caricamento del carrello</p>';
            });
    }
    document.getElementById("carrello21").onclick = function () {
        window.location.href = "carrello.php";
      }

    document.getElementById('carrello-header').addEventListener('click', function(e) {
        if (e.target === this) { 
            caricaCarrello();
        }
    });
    document.getElementById('carrello').addEventListener('click', function(e) {
        if (e.target === this) { 
            caricaCarrello();
        }
    });
    
});

