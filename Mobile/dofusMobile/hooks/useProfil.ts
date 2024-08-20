import { useState, useEffect } from "react";

type User = {
  userId: string;
  userPrenom: string;
  userNom: string;
  userPseudo: string;
  userMail: string;
  userCreation: string;
};

export const useProfil = (token: string | null, user_id: string) => {
  const [user, setUser] = useState<User | null>(null);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchUser = async () => {
      if (!token) {
        setError("Vous devez être connecté pour voir votre profil");
        return;
      }

      try {
        const response = await fetch(
          `http://192.168.177.113//Bloc3-WebSite/index.php/?ctrl=User&action=InfoUserMobile&user_id=${user_id}`,
          {
            method: "GET",
            headers: {
              Authorization: `Bearer ${token}`,
              "Content-Type": "application/json",
            },
          }
        );

        if (!response.ok) {
          throw new Error("Failed to fetch user data");
        }

        const data = await response.json();
        setUser({
          userId: data.user_id,
          userPrenom: data.user_prenom,
          userNom: data.user_nom,
          userPseudo: data.user_pseudo,
          userMail: data.user_mail,
          userCreation: data.user_datecreation,
        });
        setError(null);
      } catch (err: any) {
        setError(err.message);
      }
    };

    fetchUser();
  }, [token, user_id]);

  return { user, error };
};
