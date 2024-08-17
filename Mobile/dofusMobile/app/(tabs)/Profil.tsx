import React, { useState, useRef } from 'react';
import { StyleSheet, View, TouchableOpacity, TextInput, FlatList, ScrollView, TouchableWithoutFeedback, Text } from 'react-native';
import Ionicons from '@expo/vector-icons/Ionicons';
import { ThemedText } from '@/components/ThemedText';
import { ThemedView } from '@/components/ThemedView';
import { useLogin } from "../../hooks/useLogin";
import { useModerationUsers } from "../../hooks/useProfil"; // Import du nouveau hook

const UserProfileScreen = () => {
  const [selectedUserId, setSelectedUserId] = useState<number | null>(null);
  const [selectedUsername, setSelectedUsername] = useState('');
  const [filteredUsers, setFilteredUsers] = useState<{ userId: number, username: string }[]>([]);
  const [isListVisible, setIsListVisible] = useState(false);
  const [isError, setIsError] = useState(false);
  const inputRef = useRef<TextInput>(null);
  const { token, error: loginError, login } = useLogin();
  const { users: moderationUsers, error: moderationError } = useModerationUsers(token);

  const handleUserSearch = (text: string) => {
    const filteredList = moderationUsers.filter((user) =>
      user.username.toLowerCase().includes(text.toLowerCase())
    );
    setFilteredUsers(filteredList.slice(0, 3)); // Limite à 3 résultats
    setSelectedUsername(text);
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

  const handleUserSelect = (user: { userId: number, username: string }) => {
    setSelectedUserId(user.userId);
    setSelectedUsername(user.username);
    setIsListVisible(false);
  };

  const handleActionClick = async (action: 'ban' | 'addModerator') => {
    if (!selectedUserId) {
      setIsError(true);
      return;
    }

    try {
      const response = await fetch(
        "http://localhost:8888/blog/dofusweb/Bloc3-WebSite/index.php/?ctrl=User&action=panneauModeration",
        {
          method: "POST",
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `action=${action}&userId=${selectedUserId}`,
        }
      );

      if (!response.ok) {
        throw new Error("Failed to perform the action");
      }

      // Optionnel : gestion des retours après l'action
      const result = await response.json();
      console.log(result);
    } catch (error) {
      console.error(error);
    }
  };

  const renderAdminActions = () => {
    if (moderationError) {
      return <Text style={styles.errorText}>Erreur: {moderationError}</Text>;
    }

    if (moderationUsers.length > 0) {
      return (
        <View style={styles.adminActionsContainer}>
          <Text style={styles.adminActionTitle}>Admin Actions</Text>
          <TouchableWithoutFeedback onPress={handleOutsidePress}>
            <View>
              <View style={styles.inputContainer}>
                <TextInput
                  ref={inputRef}
                  style={styles.textInput}
                  placeholder="Select or type a username"
                  value={selectedUsername}
                  onChangeText={handleUserSearch}
                  onFocus={handleTextInputFocus}
                />
              </View>
              {isListVisible && (
                <FlatList
                  data={filteredUsers}
                  keyExtractor={(item) => item.userId.toString()}
                  renderItem={({ item }) => (
                    <TouchableOpacity
                      style={styles.listItem}
                      onPress={() => handleUserSelect(item)}
                    >
                      <Text style={styles.listItemText}>{item.username}</Text>
                    </TouchableOpacity>
                  )}
                  scrollEnabled={false} // Désactive le défilement de FlatList
                />
              )}
            </View>
          </TouchableWithoutFeedback>
          <View style={styles.adminAction}>
            <TouchableOpacity style={styles.button} onPress={() => handleActionClick('ban')}>
              <Text style={styles.buttonText}>Ban for 7 days</Text>
            </TouchableOpacity>
          </View>
          <View style={styles.adminAction}>
            <TouchableOpacity style={styles.button} onPress={() => handleActionClick('addModerator')}>
              <Text style={styles.buttonText}>Add as Moderator</Text>
            </TouchableOpacity>
          </View>
          {isError && (
            <Text style={styles.errorText}>Please select a user before performing an action</Text>
          )}
        </View>
      );
    }
    return null;
  };

  return (
    <ScrollView>
      {/* Reste de votre interface */}
      {renderAdminActions()}
    </ScrollView>
  );
};

// Définition des styles
const styles = StyleSheet.create({
  adminActionsContainer: {
    padding: 16,
    backgroundColor: '#f5f5f5',
    borderRadius: 8,
    marginVertical: 10,
  },
  adminActionTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 10,
  },
  inputContainer: {
    marginBottom: 10,
    borderColor: '#ccc',
    borderWidth: 1,
    borderRadius: 8,
    paddingHorizontal: 8,
    paddingVertical: 4,
  },
  textInput: {
    fontSize: 16,
    padding: 8,
  },
  listItem: {
    padding: 8,
    borderBottomWidth: 1,
    borderBottomColor: '#ccc',
  },
  listItemText: {
    fontSize: 16,
  },
  adminAction: {
    marginVertical: 5,
  },
  button: {
    backgroundColor: '#007BFF',
    padding: 10,
    borderRadius: 5,
    alignItems: 'center',
  },
  buttonText: {
    color: '#fff',
    fontSize: 16,
  },
  errorText: {
    color: 'red',
    marginTop: 10,
  },
});

export default UserProfileScreen;
