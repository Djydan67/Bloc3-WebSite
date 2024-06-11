import { useStuff } from "@/hooks/useStuff";
import { useLocalSearchParams, useNavigation } from "expo-router";
import { Pressable, Text, Touchable, View, FlatList } from "react-native";

export function StuffScreen() {
    const {piecesId} = useLocalSearchParams();
    const stuff = useStuff(piecesId as string);
    const navigation = useNavigation();
    //console.log(stuff.stuff_name);
    // navigation.setOptions({
    //   title:  stuffName || "",
    // });

    if (stuff) {
      return (
        <View
          style={{
            flex: 1,
            justifyContent: "center",
            alignItems: "center",
          }}
        >
            <FlatList
              data={stuff}
              renderItem={({item}) =>               
                <Text>{item.stuff_name}</Text>
              }
            />
        </View>
      );
    }
    //console.log(userId)

//   return (
//     <View
//       style={{
//         flex: 1,
//         justifyContent: "center",
//         alignItems: "center",
//       }}
//     >
//         <Text style={{
//           fontSize:50,
//         }}>{counter}</Text>
//         <Text>User {userId}</Text>
//         <Text>{user.firstName} {user.lastName}</Text>
//     </View>
  //);
}
