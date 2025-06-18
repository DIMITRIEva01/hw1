function caricaManga(containerId, apiUrl) {
  const mangaContainer = document.getElementById(containerId);

  fetch(apiUrl)
    .then(res => res.json())
    .then(data => {
      if (!data.data || data.data.length === 0) {
        mangaContainer.textContent = "Nessun manga trovato.";
        return;
      }

      mangaContainer.innerHTML = "";

      data.data.forEach(manga => {
        const attr = manga.attributes;
        const title = attr.title.en || Object.values(attr.title)[0] || "Senza titolo";
        const id = manga.id;

        let coverUrl = "img/no_cover.jpg";
        const rel = manga.relationships;
        for (let i = 0; i < rel.length; i++) {
          if (rel[i].type === "cover_art") {
            const fileName = rel[i].attributes.fileName;
            coverUrl = `https://uploads.mangadex.org/covers/${id}/${fileName}.256.jpg`;
            break;
          }
        }

        const div = document.createElement("div");
        div.className = "articolo";

        const cuore = document.createElement("div");
        cuore.className = "heart-icon";
        cuore.textContent = "🤍";
        cuore.addEventListener("click", () => {
          alert("Devi accedere per aggiungere ai preferiti!");
        });

        const img = document.createElement("img");
        img.src = coverUrl;
        img.alt = title;
        img.width = 200;
        img.dataset.id_manga = id;
        img.onclick = function () {
          const url = `dettagli.php?id=${encodeURIComponent(id)}`;
          //console.log("Sto per reindirizzare a:", url);
          window.location.href = url;
        };
        

        const titolo = document.createElement("div");
        titolo.className = "titolo-articolo";
        titolo.textContent = title;

        const numero = Math.round((Math.random() * (15 - 5) + 5) * 100) / 100;

        const prezzo = document.createElement("div");
        prezzo.className = "prezzo-articolo";
        prezzo.textContent = numero + " €";

        const btnCarrello = document.createElement("div");
        btnCarrello.className = "button";
        btnCarrello.textContent = "Aggiungi al carrello";
        btnCarrello.addEventListener("click", () => {
          alert("Devi accedere per aggiungere al carrello!");
        });

        div.appendChild(cuore);
        div.appendChild(img);
        div.appendChild(titolo);
        div.appendChild(prezzo);
        div.appendChild(btnCarrello);

        mangaContainer.appendChild(div);
      });
    })
    .catch(err => {
      console.error("Errore nella richiesta:", err);
      mangaContainer.textContent = "Errore durante il caricamento.";
    });
}

caricaManga(
  "manga-container",
  "https://api.mangadex.org/manga?limit=12&includes[]=cover_art&order[followedCount]=desc"
);

caricaManga(
  "manga-container2",
  "https://api.mangadex.org/manga?limit=12&includes[]=cover_art&order[latestUploadedChapter]=desc"
);
caricaManga(
  "manga-container3",
  "https://api.mangadex.org/manga?limit=12&order[rating]=desc&includes[]=cover_art"
);


