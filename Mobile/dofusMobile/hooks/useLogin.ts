import { useState } from "react";
import AsyncStorage from '@react-native-async-storage/async-storage';

export const useLogin = () => {
  const [token, setToken] = useState<string | null>(null);
  const [error, setError] = useState<string | null>(null);

  const login = async (email: string, password: string) => {
    try {
      const response = await fetch(
        "http://192.168.1.88/Bloc3-WebSite/index.php/?ctrl=User&action=loginMobile",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `mail=${encodeURIComponent(email)}&mdp=${encodeURIComponent(
            password
          )}`,
        }
      );

      const textResponse = await response.text();
      const data = JSON.parse(textResponse);
      console.log("Parsed response data:", data);
      if (data.status === "success") {
        await AsyncStorage.setItem('userToken', data.token); // Stocke le token
        setToken(data.token);

        setError(null);

        // Save token to AsyncStorage
        await AsyncStorage.setItem("userToken", data.token);
        console.log("Token saved to AsyncStorage");
      } else {
        setError(data.message);
        setToken(null);
      }
    } catch (err: any) {
      setError("Erreur de connexion. Veuillez réessayer.");
      setToken(null);
    }
  };

  return { token, error, login };
};
