const params = new URLSearchParams(window.location.search);
const mangaId = params.get("id");

if (!mangaId) {
  document.body.textContent = "ID non valido o mancante.";
} else {
  fetch(`https://api.mangadex.org/manga/${mangaId}?includes[]=cover_art&includes[]=author&includes[]=artist`)
    .then(r => r.json())
    .then(mangaData => {
      const manga = mangaData.data;
      fetch(`https://api.mangadex.org/statistics/manga/${mangaId}`)
        .then(r => r.json())
        .then(statsData => {
          const stats = statsData.statistics[mangaId];
          mostraDettagliManga(manga, stats);
        });
    })
    .catch(error => {
      console.error("Errore nel fetch del manga:", error);
      document.body.textContent = "Errore nel caricamento dei dettagli del manga.";
    });
}

function mostraDettagliManga(manga, stats) {
  const titleObj = manga.attributes.title;
  const titolo = titleObj.en || titleObj.jp || "Titolo sconosciuto";

  const descrizioneObj = manga.attributes.description;
  const descrizione = descrizioneObj.it || descrizioneObj.en || "Nessuna descrizione disponibile.";

  const idCover = manga.relationships.find(r => r.type === "cover_art")?.attributes?.fileName;
  const coverUrl = idCover ? `https://uploads.mangadex.org/covers/${manga.id}/${idCover}.256.jpg` : "";

  const tags = manga.attributes.tags || [];
  const generi = tags
    .filter(t => t.attributes.group === "genre")
    .map(t => t.attributes.name.it || t.attributes.name.en)
    .join(", ") || "Nessun genere specificato";

  const autori = manga.relationships
    .filter(r => r.type === "author")
    .map(r => r.attributes?.name || "Autore sconosciuto")
    .join(", ") || "Autore sconosciuto";

  const artisti = manga.relationships
    .filter(r => r.type === "artist")
    .map(r => r.attributes?.name || "Artista sconosciuto")
    .join(", ") || "Artista sconosciuto";

  const stato = manga.attributes.status || "Stato sconosciuto";
  const linguaOriginale = manga.attributes.originalLanguage || "Sconosciuta";
  const anno = manga.attributes.year || "N/A";

  const rating = stats.rating?.average?.toFixed(1) ?? "N/D";
  const follower = stats.follows ?? 0;

  const container = document.getElementById("dettagli-manga");
  container.innerHTML = "";

  // Titolo principale
  const h1 = document.createElement("h1");
  h1.className = "titolo-manga";
  h1.textContent = titolo;
  container.appendChild(h1);

  // Container principale
  const mangaContainer = document.createElement("div");
  mangaContainer.className = "manga-container";

  // Immagine
  const imgContainer = document.createElement("div");
  const img = document.createElement("img");
  img.src = coverUrl;
  img.alt = titolo;
  img.className = "manga-cover";
  imgContainer.appendChild(img);

  // Info
  const infoContainer = document.createElement("div");
  infoContainer.className = "manga-info";

  const descrLabel = document.createElement("h2");
  descrLabel.textContent = "DESCRIZIONE:";
  descrLabel.className = "descrizione-label";

  const pDescrizione = document.createElement("p");
  pDescrizione.textContent = descrizione;

  const ul = document.createElement("ul");
  ul.innerHTML = `
    <li><strong>Stato:</strong> ${stato}</li>
    <li><strong>Lingua originale:</strong> ${linguaOriginale}</li>
    <li><strong>Anno:</strong> ${anno}</li>
    <li><strong>Rating:</strong> ${rating} / 10 ⭐</li>
    <li><strong>Follower:</strong> ${follower.toLocaleString()}</li>
    <li><strong>Autori:</strong> ${autori}</li>
    <li><strong>Artisti:</strong> ${artisti}</li>
    <li><strong>Generi:</strong> ${generi}</li>
  `;

  infoContainer.appendChild(descrLabel);
  infoContainer.appendChild(pDescrizione);
  infoContainer.appendChild(ul);

  mangaContainer.appendChild(imgContainer);
  mangaContainer.appendChild(infoContainer);
  container.appendChild(mangaContainer);
  
const trailerContainer = document.createElement("div");
trailerContainer.id = "trailer-container";
trailerContainer.textContent = "Caricamento trailer...";
container.appendChild(trailerContainer);

// Fetch da Jikan API per cercare trailer
fetch(`https://api.jikan.moe/v4/anime?q=${encodeURIComponent(titolo)}&limit=1`)
  .then(res => res.json())
  .then(data => {
    if (data.data && data.data.length > 0) {
      const anime = data.data[0];
      const trailerUrl = anime.trailer?.embed_url;

      if (trailerUrl) {
        const iframe = document.createElement("iframe");
        iframe.src = trailerUrl;
        iframe.width = "560";
        iframe.height = "315";
        iframe.frameBorder = "0";
        iframe.allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture";
        iframe.allowFullscreen = true;

        trailerContainer.innerHTML = ""; // svuota il testo "Caricamento..."
        trailerContainer.appendChild(iframe);
      } else {
        trailerContainer.textContent = "Trailer non disponibile.";
      }
    } else {
      trailerContainer.textContent = "Nessun anime trovato.";
    }
  })
  .catch(err => {
    console.error("Errore trailer:", err);
    trailerContainer.textContent = "Errore durante il caricamento del trailer.";
  });

}


  