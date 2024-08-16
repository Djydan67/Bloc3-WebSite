import React, { useState, useRef } from 'react';
import { StyleSheet, View, TouchableOpacity, TextInput, FlatList, ScrollView, TouchableWithoutFeedback, Text } from 'react-native';
import Ionicons from '@expo/vector-icons/Ionicons';
import { ThemedText } from '@/components/ThemedText';
import { ThemedView } from '@/components/ThemedView';

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
    const filteredList = usersList.filter((user) =>
      user.toLowerCase().includes(text.toLowerCase())
    );
    setFilteredUsers(filteredList.slice(0, 3)); // Limite à 3 résultats
    setSelectedUser(text);
    setIsError(false);
    setIsListVisible(true);
  };

  const handleTextInputFocus = () => {
    setIsListVisible(true);
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
      // Logique pour bannir l'utilisateur
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
                <FlatList
                  data={filteredUsers}
                  keyExtractor={(item) => item}
                  renderItem={({ item }) => (
                    <TouchableOpacity
                      style={styles.listItem}
                      onPress={() => {
                        setSelectedUser(item);
                        setIsListVisible(false);
                      }}
                    >
                      <Text style={styles.listItemText}>{item}</Text>
                    </TouchableOpacity>
                  )}
                  scrollEnabled={false} // Désactive le défilement de FlatList
                />
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
    <ScrollView>
      <View style={styles.headerImageContainer}>
        <Ionicons size={310} name="person-circle-outline" style={styles.headerImage} />
      </View>
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
