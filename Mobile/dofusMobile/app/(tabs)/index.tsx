import React from "react";
import { Image, StyleSheet, useWindowDimensions } from "react-native";

import { HelloWave } from "@/components/HelloWave";
import ParallaxScrollView from "@/components/ParallaxScrollView";
import { ThemedText } from "@/components/ThemedText";
import { ThemedView } from "@/components/ThemedView";
import { Link } from "expo-router";

const Carousel = [
  {
    id: "image_del",
  },
  {
    id: "image_equip",
  },
  {
    id: "image_forum",
  },
];

export default function HomeScreen() {
  const { width } = useWindowDimensions();
  return (
    <ParallaxScrollView
      headerBackgroundColor={{ light: "#A1CEDC", dark: "#1D3D47" }}
      headerImage={
        <Image
          source={require("@/assets/images/dofushelp_banner.jpg")}
          style={styles.reactLogo}
        />
      }
    >
      <ThemedView style={styles.titleContainer}>
        <ThemedText type="title">Bienvenue sur DofusHelp !</ThemedText>
        <HelloWave />
        <Link
          href={{
            pathname: "/profil",
            // params: { userId: user.id },
          }}
        >
          <Image
            source={require("@/assets/images/profil.png")}
            style={styles.profilLogo}
          />
        </Link>
      </ThemedView>
      <ThemedView></ThemedView>
      <ThemedView style={styles.stepContainer}>
        <ThemedText type="subtitle">
          Sur notre site, vous pourrez tester tout les équipements du jeux avec
          votre personnage ! Essayer vos combinaisons pour optimiser votre perso
          au maximum !
        </ThemedText>
      </ThemedView>
    </ParallaxScrollView>
  );
}

const styles = StyleSheet.create({
  titleContainer: {
    flexDirection: "row",
    alignItems: "center",
    gap: 8,
  },
  stepContainer: {
    gap: 8,
    marginBottom: 8,
  },
  reactLogo: {
    position: "absolute",
    top: 0,
    left: 0,
    width: "100%",
    height: "100%",
    zIndex: -1 /* Pour placer l'image derrière le texte */,
  },
  profilLogo: {
    width: 40, // Taille du conteneur pour l'icône de profil
    height: 40, // Taille du conteneur pour l'icône de profil
    borderRadius: 20, // Pour rendre l'icône ronde (la moitié de la largeur/hauteur)
    overflow: "hidden", // Pour s'assurer que l'image ne dépasse pas du conteneur
    backgroundColor: "#fff", // Optionnel : fond blanc pour l'icône
    shadowColor: "#000", // Optionnel : ombre pour l'icône
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 2,
    elevation: 3, // Nécessaire pour les ombres sur Android
  },
});
