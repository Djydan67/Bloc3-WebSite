import { useEffect, useState } from "react";

export const useStuff = (piecesId: string) => {
  const [stuff, setStuff] = useState<any>();
  //console.log(piecesId)
  useEffect(() => {
    fetch(
      "http://192.168.151.113/Bloc3-WebSite/index.php/?ctrl=stuff&action=equipements&pieces=" +
        piecesId
    )
      .then((res) => res.json())
      .then((data) => {
        setStuff(data);
      });
  }, [piecesId]);
  return stuff;
};
