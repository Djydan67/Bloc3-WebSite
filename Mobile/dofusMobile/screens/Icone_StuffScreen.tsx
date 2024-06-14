import {
  Image,
  Pressable,
  Text,
  Touchable,
  View,
  FlatList,
} from "react-native";
import { Link, useNavigation } from "expo-router";
import { Drawer } from "expo-router/drawer";
import { PresImages } from "@/components/presImages";
import { useStuff } from "@/hooks/useStuff";
import { useState } from "react";

export function HomeScreen() {
  const [piecesId, setPieceId] = useState<string>();
  const stuff = useStuff(piecesId);

  const items = [
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
        {items.map((item) => {
          return (
            <PresImages
              onPress={() => {
                setPieceId(item.id);
              }}
            >
              <Image
                source={{ uri: item.image }}
                style={{ width: 50, height: 50 }}
              />
            </PresImages>
          );
        })}
      </View>
      <FlatList
        data={stuff}
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
