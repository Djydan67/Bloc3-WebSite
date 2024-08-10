import { Image, Text, View, FlatList } from "react-native";
import { useState } from "react";
import { PresImages } from "@/components/presImages";
import { useStuff } from "@/hooks/useStuff";

// Définir le type pour les items
interface Item {
  id: string;
  image: string;
}

export function HomeScreen() {
  const [piecesId, setPieceId] = useState<string | undefined>(undefined);
  const stuff = useStuff(piecesId);

  const items: Item[] = [
    {
      id: "Amulette",
      image: "https://actu-gaming.tech/Assets/Images/logo-amulette.png",
    },
    {
      id: "Ceinture",
      image: "https://actu-gaming.tech/Assets/Images/logo-ceinture.png",
    },
    {
      id: "Dofus",
      image: "https://actu-gaming.tech/Assets/Images/logo-dofus_(2).png",
    },
    {
      id: "Bottes",
      image: "https://actu-gaming.tech/Assets/Images/logo-botte.png",
    },
    {
      id: "Cape",
      image: "https://actu-gaming.tech/Assets/Images/logo-cape.png",
    },
    {
      id: "Chapeau",
      image: "https://actu-gaming.tech/Assets/Images/logo-chapeau.png",
    },
    {
      id: "Anneau",
      image: "https://actu-gaming.tech/Assets/Images/logo-anneaux.png",
    },
    {
      id: "Trophee",
      image: "https://actu-gaming.tech/Assets/Images/logo-trophee.png",
    },
    {
      id: "Bouclier",
      image: "https://actu-gaming.tech/Assets/Images/logo-bouclier.png",
    },
    {
      id: "Armes",
      image: "https://actu-gaming.tech/Assets/Images/logo-arme.png",
    },
  ];

  return (
    <View
      style={{
        flex: 1,
        marginTop: "25%",
        flexDirection: "row",
      }}
    >
      <View>
        {items.map((item) => (
          <PresImages
            key={item.id} // Ajout de la clé ici
            onPress={() => {
              setPieceId(item.id);
            }}
          >
            <Image
              source={{ uri: item.image }}
              style={{ width: 50, height: 50 }}
            />
          </PresImages>
        ))}
      </View>
      <FlatList
        data={stuff}
        keyExtractor={(item, index) => item.stuff_name + index}
        renderItem={({ item }) => (
          <View>
            <Image
              source={{
                uri: "http://192.168.151.113/" + item.stuff_imgPathMobile,
              }}
              style={{
                width: 50,
                height: 50,
              }}
            />
            <Text
              style={{
                margin: 10,
              }}
            >
              {item.stuff_name} {item.stuff_setType}
            </Text>
          </View>
        )}
      />
    </View>
  );
}
