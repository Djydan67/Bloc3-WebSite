import React, { useState, useEffect, useRef } from 'react';
import { StyleSheet, View, TouchableOpacity, TextInput, FlatList, TouchableWithoutFeedback } from 'react-native';
import Ionicons from '@expo/vector-icons/Ionicons';
import { ThemedText } from '@/components/ThemedText';
import { ThemedView } from '@/components/ThemedView';
import ParallaxScrollView from '@/components/ParallaxScrollView';
import { Picker } from '@react-native-picker/picker';

const UserProfileScreen = () => {
  const [selectedUser, setSelectedUser] = useState('');
  const [filteredUsers, setFilteredUsers] = useState<string[]>([]);
  const [isListVisible, setIsListVisible] = useState(false);
  const [isError, setIsError] = useState(false);
  const inputRef = useRef<TextInput>(null);

  const user = {
    username: 'hiro',
    email: 'blabla@example.com',
    firstName: 'adrien',
    lastName: 'cazala',
    birthDate: '1999-11-21',
    role: 3, // 1 = utilisateur, 2 = modérateur, 3 = administrateur
  };

  const usersList = ['frero', 'hiro', 'adamail', 'darksasukedu42', 'ventCodeAudio'];

  const handleUserSearch = (text: string) => {
    const filteredList = usersList.filter((user) => user.toLowerCase().includes(text.toLowerCase()));
    setFilteredUsers(filteredList.slice(0, 3)); // Afficher uniquement les trois premières propositions
    setSelectedUser(text);
    setIsError(false);
    setIsListVisible(true); // Afficher la liste dès que l'utilisateur commence à écrire
  };

  const handleTextInputFocus = () => {
    setIsListVisible(true);
  };

  const handlePickerValueChange = (itemValue: string | number, itemIndex: number) => {
    setSelectedUser(itemValue as string);
    setIsListVisible(false);
  };

  const handleOutsidePress = () => {
    if (inputRef.current) {
      inputRef.current.blur();
    }
    setIsListVisible(false);
  };

  const handleBanClick = () => {
    if (!usersList.includes(selectedUser)) {
      setIsError(true);
    } else {
      setIsError(false);
      // Ajouter ici la logique pour bannir l'utilisateur
    }
  };

  const renderAdminActions = () => {
    if (user.role >= 2) {
      return (
        <View style={styles.adminActionsContainer}>
          <ThemedText style={styles.adminActionTitle}>Admin Actions</ThemedText>
          <TouchableWithoutFeedback onPress={handleOutsidePress}>
            <View>
              <View style={styles.inputContainer}>
                <TextInput
                  ref={inputRef}
                  style={styles.textInput}
                  placeholder="Select or type a username"
                  value={selectedUser}
                  onChangeText={handleUserSearch}
                  onFocus={handleTextInputFocus}
                />

              </View>
              {isListVisible && (
                <View style={styles.pickerContainer}>
                  <Picker
                    selectedValue={selectedUser}
                    style={styles.picker}
                    onValueChange={handlePickerValueChange}
                  >
                    {filteredUsers.map((user) => (
                      <Picker.Item label={user} value={user} key={user} />
                    ))}
                  </Picker>
                </View>
              )}
            </View>
          </TouchableWithoutFeedback>
          <View style={styles.adminAction}>
            <TouchableOpacity style={styles.button} onPress={handleBanClick}>
              <ThemedText style={styles.buttonText}>Ban for 7 days</ThemedText>
            </TouchableOpacity>
          </View>
          {user.role >= 3 && (
            <View style={styles.adminAction}>
              <TouchableOpacity style={styles.button} onPress={handleBanClick}>
                <ThemedText style={styles.buttonText}>Ban permanently</ThemedText>
              </TouchableOpacity>
            </View>
          )}
          {isError && (
            <ThemedText style={styles.errorText}>User does not exist</ThemedText>
          )}
        </View>
      );
    }
    return null;
  };

  return (
    <ParallaxScrollView
      headerBackgroundColor={{ light: '#D0D0D0', dark: '#353636' }}
      headerImage={<Ionicons size={310} name="person-circle-outline" style={styles.headerImage} />}
    >
      <ThemedView style={styles.container}>
        <ThemedText type="title" style={styles.title}>Profile</ThemedText>
        <View style={styles.infoContainer}>
          <ThemedText style={styles.label}>Username:</ThemedText>
          <ThemedText style={styles.value}>{user.username}</ThemedText>
        </View>
        <View style={styles.infoContainer}>
          <ThemedText style={styles.label}>Email:</ThemedText>
          <ThemedText style={styles.value}>{user.email}</ThemedText>
        </View>
        <View style={styles.infoContainer}>
          <ThemedText style={styles.label}>First Name:</ThemedText>
          <ThemedText style={styles.value}>{user.firstName}</ThemedText>
        </View>
        <View style={styles.infoContainer}>
          <ThemedText style={styles.label}>Last Name:</ThemedText>
          <ThemedText style={styles.value}>{user.lastName}</ThemedText>
        </View>
        <View style={styles.infoContainer}>
          <ThemedText style={styles.label}>Date of Birth:</ThemedText>
          <ThemedText style={styles.value}>{user.birthDate}</ThemedText>
        </View>
        {renderAdminActions()}
      </ThemedView>
    </ParallaxScrollView>
  );
};

const styles = StyleSheet.create({
  headerImage: {
    color: '#808080',
    bottom: -90,
    left: -35,
    position: 'absolute',
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
  searchIcon: {
    marginLeft: 10,
  },
  pickerContainer: {
    position: 'relative',
    width: '100%',
  },
  picker: {
    height: 40,
    width: '100%',
    color: '#fff', // Texte de la liste en blanc
    backgroundColor: '#000', // Fond de la liste en noir
  },
  errorText: {
    color: 'red',
    marginTop: 10,
  },
});

export default UserProfileScreen;
