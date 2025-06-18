
fetch("carrello_fetch.php")
  .then(response => response.json()) 
  .then(data => { 
    const divPreferiti = document.getElementById("carrellodiv");

    if (data.length === 0) {
      divPreferiti.textContent = "Nessun manga nel carrello.";
      return;
    }

    data.forEach(manga => {
      const div = document.createElement("div");
      div.className = "manga";

      div.innerHTML = `
        <img src="${manga.copertina_url}" alt="${manga.titolo}">
        <h3>${manga.titolo}</h3>
        <p>${manga.prezzo} €</p>
      `;

      divPreferiti.appendChild(div);
    });
  })
  .catch(error => {
    console.error("Errore nel caricamento del carrello:", error);
  });
