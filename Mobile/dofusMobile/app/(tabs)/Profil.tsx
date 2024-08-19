import React, { useState, useRef, useEffect } from 'react';
import { StyleSheet, View, ScrollView } from 'react-native';
import Ionicons from '@expo/vector-icons/Ionicons';
import { ThemedText } from '@/components/ThemedText';
import { ThemedView } from '@/components/ThemedView';
import { jwtDecode} from "jwt-decode";
import AsyncStorage from '@react-native-async-storage/async-storage';
import { useProfil } from '../../hooks/useProfil';

const UserProfileScreen = () => {
  const [userId, setUserId] = useState<string | undefined>(undefined);
  const [token, setToken] = useState<string | null>(null);

  useEffect(() => {
    const fetchTokenAndSetUser = async () => {
      try {
        const storedToken = await AsyncStorage.getItem('userToken');
        if (storedToken) {
          const decodedToken = jwtDecode<{ sub: string }>(storedToken);
          setUserId(decodedToken.sub);
          setToken(storedToken);
        }
      } catch (e) {
        console.error('Failed to retrieve or decode the token:', e);
      }
    };
    fetchTokenAndSetUser();
  }, []);

  // Utilisation du hook pour récupérer les informations de l'utilisateur
  const { user, error } = useProfil(token, userId || "");

  if (error) {
    return <ThemedText style={styles.errorText}>{error}</ThemedText>;
  }

  return (
    <ScrollView>
      <View style={styles.headerImageContainer}>
        <Ionicons size={310} name="person-circle-outline" style={styles.headerImage} />
      </View>
      <ThemedView style={styles.container}>
        <ThemedText type="title" style={styles.title}>Profile</ThemedText>
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
              <ThemedText style={styles.label}>Prenom:</ThemedText>
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
          </>
        ) : (
          <ThemedText>Loading...</ThemedText>
        )}
      </ThemedView>
    </ScrollView>
  );
};


const styles = StyleSheet.create({
  headerImageContainer: {
    alignItems: 'center',
    marginVertical: 20,
  },
  headerImage: {
    color: '#808080',
  },
  container: {
    padding: 20,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  infoContainer: {
    flexDirection: 'row',
    marginBottom: 10,
  },
  label: {
    fontWeight: 'bold',
    marginRight: 10,
  },
  value: {
    flex: 1,
    flexWrap: 'wrap',
  },
  adminActionsContainer: {
    marginTop: 20,
  },
  adminActionTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 10,
  },
  adminAction: {
    flexDirection: 'column',
    alignItems: 'flex-start',
    marginBottom: 10,
  },
  button: {
    backgroundColor: '#fff',
    paddingVertical: 10,
    paddingHorizontal: 20,
    borderRadius: 5,
    borderWidth: 1,
    borderColor: '#000',
    marginTop: 10,
  },
  buttonText: {
    color: '#000',
    fontWeight: 'bold',
  },
  textInput: {
    height: 40,
    borderColor: '#000',
    borderWidth: 1,
    borderRadius: 5,
    paddingHorizontal: 10,
    marginBottom: 10,
    width: '90%',
  },
  inputContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    width: '100%',
  },
  listItem: {
    paddingVertical: 10,
    paddingHorizontal: 15,
    borderBottomWidth: 1,
    borderBottomColor: '#ccc',
  },
  listItemText: {
    fontSize: 16,
  },
  errorText: {
    color: 'red',
    marginTop: 10,
  },
});

export default UserProfileScreen;
