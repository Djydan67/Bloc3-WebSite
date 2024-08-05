import { useEffect, useState } from "react";

export const useLogin = () => {
  const [login, setLogin] = useState<any>();
  //console.log(piecesId)
  useEffect(() => {
    fetch(
      "http://172.20.10.10:8082/Bloc3-WebSite/index.php/?ctrl=Jwt&action=Jwt"
    )
      .then((res) => res.json())
      .then((data) => {
        setLogin(data);
      });
  }, []);
  return login;
};
