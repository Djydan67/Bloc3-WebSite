import { HelloWave } from "@/components/HelloWave";
import ParallaxScrollView from "@/components/ParallaxScrollView";
import { ThemedText } from "@/components/ThemedText";
import { ThemedView } from "@/components/ThemedView";
import { Link } from "expo-router";
import React, { useEffect, useRef } from "react";
import {
  FlatList,
  Image,
  Linking,
  Pressable,
  StyleSheet,
  View,
  useWindowDimensions,
} from "react-native";

const carousel = [
  {
    id: "image_del",
    openinapp: false,
    //source: require("AssetsImagesdldofus.png"),
    href: "https://www.dofus.com/fr/mmorpg/telecharger",
  },
  {
    id: "image_equip",
    source: require("@/assets/images/stuff.png"),
    openinapp: true,
    href: "/stuff",
  },
  {
    id: "image_forum",
    source: require("@/assets/images/forum.png"),
    href: "/forum",
    openinapp: true,
  },
];

export default function HomeScreen() {
  const { width } = useWindowDimensions();
  const flatListRef = useRef(null);
  let currentIndex = 0;
  useEffect(() => {
    const interval = setInterval(() => {
      currentIndex = (currentIndex + 1) % carousel.length;
      flatListRef.current.scrollToIndex({
        animated: true,
        index: currentIndex,
      });
    }, 5000); // Change every 5 seconds

    return () => clearInterval(interval);
  }, []);
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
      <ThemedView>
        <FlatList
          ref={flatListRef}
          horizontal
          data={carousel}
          renderItem={({ item }) => {
            if (item.openinapp) {
              return (
                <View style={[styles.carouselItem, { width: width * 0.8 }]}>
                  <Image source={item.source} style={styles.carouselImage} />
                </View>
              );
            }
            return (
              <Pressable
                style={[styles.carouselItem, { width: width * 0.8 }]}
                onPress={() => {
                  Linking.openURL(
                    "https://www.dofus.com/fr/mmorpg/telecharger"
                  );
                }}
              >
                <Image source={item.source} style={styles.carouselImage} />
              </Pressable>
            );
          }}
          keyExtractor={(item) => item.id}
          pagingEnabled
          snapToInterval={width * 0.8 + 20}
          snapToAlignment="center"
          showsHorizontalScrollIndicator={false}
          decelerationRate="fast"
          getItemLayout={(data, index) => ({
            length: width * 0.8 + 20,
            offset: (width * 0.8 + 20) * index,
            index,
          })}
        />
      </ThemedView>
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
  carouselContainer: {
    marginVertical: 10,
  },
  carouselItem: {
    justifyContent: "center",
    alignItems: "center",
    padding: 10,
  },
  carouselImage: {
    width: "100%",
    height: 180,
    borderRadius: 10,
    resizeMode: "cover",
  },
});
function source(arg0: string) {
  throw new Error("Function not implemented.");
}
