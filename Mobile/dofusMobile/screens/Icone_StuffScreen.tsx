import { Image, Pressable, Text, Touchable, View } from "react-native";
import { Link } from "expo-router";
import { PresImages } from "@/components/presImages";

export function HomeScreen() {
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
        flexDirection: "row",
        flexWrap: "wrap",
        justifyContent: "space-between",
        alignItems: "center",
      }}
    >
      {items.map((item) => {
        //console.log(item.id)
        return (
          <Link asChild
            href={{
              pathname: "/stuff/[stuffId]",
              params: { piecesId: item.id },
            }}
          >
            <PresImages onPress={() => {}}>
              <Image
                source={item.image}
                style={{
                  height: 100,
                  width: 100,
                }}
              />
            </PresImages>
          </Link>
        );
      })}
    </View>
  );
}
