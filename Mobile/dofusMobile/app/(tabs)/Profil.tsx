import React, { useState, useEffect } from "react";
import { StyleSheet, View, ScrollView, Pressable, Alert } from "react-native";
import Ionicons from "@expo/vector-icons/Ionicons";
import { ThemedText } from "@/components/ThemedText";
import { ThemedView } from "@/components/ThemedView";
import { jwtDecode } from "jwt-decode";
import AsyncStorage from "@react-native-async-storage/async-storage";
import { useProfil } from "../../hooks/useProfil";
import { useLogin } from "../../hooks/useLogin";
import { useNavigation } from "@react-navigation/native";

const UserProfileScreen = () => {
  const [userId, setUserId] = useState<string | undefined>(undefined);
  const [token, setToken] = useState<string | null>(null);
  const { logout } = useLogin(); // Importez la fonction logout
  const navigation = useNavigation(); // Pour naviguer après déconnexion

  useEffect(() => {
    const fetchTokenAndSetUser = async () => {
      try {
        const storedToken = await AsyncStorage.getItem("userToken");
        if (storedToken) {
          const decodedToken = jwtDecode<{ sub: string }>(storedToken);
          setUserId(decodedToken.sub);
          setToken(storedToken);
        }
      } catch (e) {
        console.error("Failed to retrieve or decode the token:", e);
      }
    };
    fetchTokenAndSetUser();
  }, []);

  // Utilisation du hook pour récupérer les informations de l'utilisateur
  const { user, error } = useProfil(token, userId || "");

  const handleLogout = async () => {
    await logout();
    Alert.alert("Déconnexion réussie", "Vous avez été déconnecté.");
    navigation.navigate("LoginScreen" as never); // Redirigez vers l'écran de connexion ou autre
  };

  if (error) {
    return <ThemedText style={styles.errorText}>{error}</ThemedText>;
  }

  return (
    <ScrollView style={styles.scrollContainer}>
      <View style={styles.headerImageContainer}>
        <Ionicons
          size={310}
          name="person-circle-outline"
          style={styles.headerImage}
        />
      </View>
      <ThemedView style={styles.card}>
        <ThemedText type="title" style={styles.title}>
          Profil
        </ThemedText>
        {user ? (
          <>
            <View style={styles.infoContainer}>
              <ThemedText style={styles.label}>Pseudo:</ThemedText>
              <ThemedText style={styles.value}>{user.userPseudo}</ThemedText>
            </View>
            <View style={styles.infoContainer}>
              <ThemedText style={styles.label}>Email:</ThemedText>
              <ThemedText style={styles.value}>{user.userMail}</ThemedText>
            </View>
            <View style={styles.infoContainer}>
              <ThemedText style={styles.label}>Prénom:</ThemedText>
              <ThemedText style={styles.value}>{user.userPrenom}</ThemedText>
            </View>
            <View style={styles.infoContainer}>
              <ThemedText style={styles.label}>Nom de famille:</ThemedText>
              <ThemedText style={styles.value}>{user.userNom}</ThemedText>
            </View>
            <View style={styles.infoContainer}>
              <ThemedText style={styles.label}>Date de création:</ThemedText>
              <ThemedText style={styles.value}>{user.userCreation}</ThemedText>
            </View>
            <Pressable style={styles.button} onPress={handleLogout}>
              <ThemedText style={styles.buttonText}>Déconnexion</ThemedText>
            </Pressable>
          </>
        ) : (
          <ThemedText>Chargement...</ThemedText>
        )}
      </ThemedView>
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  scrollContainer: {
    backgroundColor: "#2e2924",
  },
  headerImageContainer: {
    alignItems: "center",
    marginVertical: 20,
  },
  headerImage: {
    color: "#808080",
  },
  card: {
    backgroundColor: "#749245",
    borderRadius: 10,
    padding: 20,
    margin: 20,
    alignItems: "center",
  },
  title: {
    color: "white",
    fontSize: 24,
    fontWeight: "bold",
    marginBottom: 20,
  },
  infoContainer: {
    flexDirection: "row",
    marginBottom: 10,
    width: "100%",
  },
  label: {
    color: "white",
    fontWeight: "bold",
    marginRight: 10,
    flex: 1,
  },
  value: {
    color: "white",
    flex: 2,
    flexWrap: "wrap",
  },
  button: {
    backgroundColor: "#2e2924",
    paddingVertical: 12,
    paddingHorizontal: 20,
    borderRadius: 5,
    marginTop: 20,
    width: "100%",
    maxWidth: 400,
    alignItems: "center",
  },
  buttonText: {
    color: "white",
    fontSize: 16,
    fontWeight: "bold",
  },
  errorText: {
    color: "red",
    marginTop: 10,
  },
});

export default UserProfileScreen;
