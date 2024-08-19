import {
  Image,
  Text,
  View,
  FlatList,
  StyleSheet,
  Modal,
  Button,
  TouchableOpacity,
} from "react-native";
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
  const [modalVisible, setModalVisible] = useState(false);
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
    <View style={styles.container}>
      <Button
        color="#3c3630"
        title="Filtres"
        onPress={() => setModalVisible(true)}
      />
      <Modal
        animationType="slide"
        transparent={true}
        visible={modalVisible}
        onRequestClose={() => {
          setModalVisible(!modalVisible);
        }}
      >
        <View style={styles.modalContainer}>
          <View style={styles.modalView}>
            <Button
              color="#3c3630"
              title="Fermer"
              onPress={() => setModalVisible(false)}
            />
            {items.map((item) => (
              <TouchableOpacity
                key={item.id}
                onPress={() => {
                  setPieceId(item.id);
                  setModalVisible(false);
                }}
                style={styles.filterButton}
              >
                <Image
                  source={{ uri: item.image }}
                  style={{ width: 50, height: 50 }}
                />
                <Text style={styles.filterText}>{item.id}</Text>
              </TouchableOpacity>
            ))}
          </View>
        </View>
      </Modal>
      <FlatList
        data={stuff}
        keyExtractor={(item, index) => item.stuff_name + index}
        renderItem={({ item }) => (
          <View style={styles.card}>
            <View style={styles.cardHeader}>
              <Text style={styles.cardTitle}>{item.stuff_name}</Text>
              <Image
                source={{
                  uri: "http://192.168.151.113/" + item.stuff_imgPathMobile,
                }}
                style={styles.cardImage}
              />
            </View>
            <View style={styles.cardHeader}>
              <Text style={styles.cardLevel}>
                Niveau : {item.stuff_setType}
              </Text>
              <Text style={styles.cardLevel}>Niveau : {item.stuff_level}</Text>
            </View>
            <View
              style={{
                borderBottomColor: "#fff",
                borderBottomWidth: StyleSheet.hairlineWidth,
              }}
            />
            <View>
              <Text style={styles.cardText}>{item.stuff_description}</Text>
            </View>
          </View>
        )}
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    //flex: 1,
    //flexDirection: "row",
    backgroundColor: "#2e2924",
  },
  background: {
    //backgroundColor: "#2e2924",
    //flex: 1,
    paddingTop: 20,
  },
  modalContainer: {
    flex: 1,
    //justifyContent: "center",
    alignItems: "center",
    backgroundColor: "rgba(0,0,0,0.5)",
  },
  modalView: {
    //margin: 100,
    width: "50%",
    marginTop: "10%",
    //maxHeight: "80%",
    //flex: 1,
    //justifyContent: "center",
    //alignItems: "center",
    //backgroundColor: "rgba(0,0,0,0.5)",
  },
  filterButton: {
    flexDirection: "row",
    alignItems: "center",
    padding: 10,
    backgroundColor: "#749245",
    marginBottom: 10,
    borderRadius: 5,
    height: 60,
  },
  filterText: {
    marginLeft: 10,
    fontSize: 16,
  },
  card: {
    width: "90%",
    marginLeft: "5%",
    marginTop: 20,
    marginBottom: 20,
    backgroundColor: "#3c3630",
    borderRadius: 8,
    overflow: "hidden",
    shadowColor: "#000",
    shadowOpacity: 0.1,
    shadowRadius: 10,
    elevation: 5,
  },
  cardHeader: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between",
  },
  cardImage: {
    width: 50,
    height: 50,
    //flex: 1,
    alignSelf: "flex-end",
  },
  cardTitle: {
    fontSize: 16,
    //fontWeight: "bold",
    marginLeft: 10,
    //margin: 10,
    color: "#fff",
  },
  cardLevel: {
    fontSize: 14,
    marginHorizontal: 10,
    marginBottom: 10,
    color: "#fff",
  },
  cardText: {
    margin: 10,
    color: "#fff",
  },
});
