import { useEffect, useState } from "react";

export const useStuff = (piecesId: string | undefined) => {
  const [stuff, setStuff] = useState<any[]>([]); // Stocker un tableau d'objets
  const [filteredStuff, setFilteredStuff] = useState<any[]>([]); // Stocker le tableau filtré

  useEffect(() => {
    const url =
      "http://192.168.177.113/Bloc3-WebSite/index.php/?ctrl=stuff&action=getEquipementsJson";
    console.log("Fetching data from:", url);

    fetch(url)
      .then((res) => {
        if (!res.ok) {
          throw new Error(`HTTP error! Status: ${res.status}`);
        }
        return res.json();
      })
      .then((data) => {
        setStuff(data); // Stocke toutes les données dans `stuff`
      })
      .catch((error) => {
        console.error("There was an error!", error);
      });
  }, []); // Le hook ne se déclenche qu'au montage du composant

  useEffect(() => {
    if (piecesId) {
      const filtered = stuff.filter((item) => item.stuff_pieces === piecesId);
      setFilteredStuff(filtered); // Met à jour le tableau filtré
    } else {
      setFilteredStuff(stuff); // Si aucun `piecesId`, retourne toutes les données
    }
  }, [piecesId, stuff]); // Le hook se déclenche lorsque `piecesId` ou `stuff` changent

  return filteredStuff;
};
