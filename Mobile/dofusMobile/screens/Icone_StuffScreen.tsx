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
      image: require("@/assets/images/stuff-icone/logo-amulette.png"),
    },
    {
      id: "Ceinture",
      image: require("@/assets/images/stuff-icone/logo-ceinture.png"),
    },
    {
      id: "Dofus",
      image: require("@/assets/images/stuff-icone/logo-dofus_(2).png"),
    },
    {
      id: "Bottes",
      image: require("@/assets/images/stuff-icone/logo-botte.png"),
    },
    {
      id: "Cape",
      image: require("@/assets/images/stuff-icone/logo-cape.png"),
    },
    {
      id: "Chapeau",
      image: require("@/assets/images/stuff-icone/logo-chapeau.png"),
    },
    {
      id: "Anneau",
      image: require("@/assets/images/stuff-icone/logo-anneaux.png"),
    },
    {
      id: "Trophee",
      image: require("@/assets/images/stuff-icone/logo-trophee.png"),
    },
    {
      id: "Bouclier",
      image: require("@/assets/images/stuff-icone/logo-bouclier.png"),
    },
    {
      id: "Armes",
      image: require("@/assets/images/stuff-icone/logo-arme.png"),
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
              <Image source={item.image} style={{}} />
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
