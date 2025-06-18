
fetch("preferiti_fetch.php")
  .then(response => response.json()) 
  .then(data => { 
    const divPreferiti = document.getElementById("preferiti");

    if (data.length === 0) {
      divPreferiti.textContent = "Nessun manga tra i preferiti.";
      return;
    }

    data.forEach(manga => { // Itera su ogni manga nei preferiti
      const div = document.createElement("div");
      div.className = "manga";

      div.innerHTML = `
        <img src="${manga.copertina_url}" alt="${manga.titolo}">
        <h3>${manga.titolo}</h3>
      `;

      divPreferiti.appendChild(div);
    });
  })
  .catch(error => {
    console.error("Errore nel caricamento dei preferiti:", error);
  });
