import Ionicons from "@expo/vector-icons/Ionicons";
import { Pressable, StyleSheet, Alert } from "react-native";
import { View, Text, TextInput } from "react-native";
import * as React from "react";
import { Link } from "expo-router";
import { useLogin } from "../../hooks/useLogin";
import { useNavigation } from "@react-navigation/native";

export default function TabTwoScreen() {
  const navigation = useNavigation();
  const [email, onChangeEmail] = React.useState("");
  const [password, onChangePassword] = React.useState("");
  const { token, error, login } = useLogin();

  const handleLogin = async () => {
    await login(email, password);
    if (error) {
      Alert.alert("Erreur de connexion", error);
    } else if (token) {
      Alert.alert("Connexion réussie", "Bienvenue !");
      navigation.navigate("Profil" as never);
      console.log("Token:", token);
    }
  };

  return (
    <View style={styles.container}>
      <View style={styles.card}>
        <Text style={styles.text}>Connexion</Text>
        <TextInput
          style={styles.input}
          onChangeText={onChangeEmail}
          value={email}
          placeholder="Enter your email"
          keyboardType="email-address"
          autoCapitalize="none"
        />
        <TextInput
          style={styles.input}
          onChangeText={onChangePassword}
          value={password}
          placeholder="Enter your password"
          secureTextEntry={true}
          autoCapitalize="none"
        />
        <Pressable
          style={({ pressed }) => [
            styles.button,
            pressed && styles.buttonPressed,
          ]}
          onPress={handleLogin}
        >
          <Text style={styles.buttonText}>Connexion</Text>
        </Pressable>
        {token && <Text style={styles.tokenText}>Vous êtes connecté</Text>}
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
    backgroundColor: "#2e2924",
    padding: 20,
  },
  card: {
    backgroundColor: "#749245",
    borderRadius: 10,
    padding: 20,
    width: "100%",
    maxWidth: 400,
    alignItems: "center",
  },
  text: {
    color: "white",
    fontSize: 24,
    marginBottom: 20,
  },
  input: {
    height: 40,
    marginVertical: 12,
    borderWidth: 1,
    paddingHorizontal: 10,
    width: "100%",
    borderRadius: 5,
    backgroundColor: "white",
    fontSize: 16,
  },
  button: {
    backgroundColor: "#2e2924",
    paddingVertical: 12,
    paddingHorizontal: 20,
    borderRadius: 5,
    marginTop: 20,
    width: "100%",
    alignItems: "center",
  },
  buttonPressed: {
    backgroundColor: "#1f1b16",
  },
  buttonText: {
    color: "white",
    fontSize: 16,
    fontWeight: "bold",
  },
  linkText: {
    color: "white",
    fontSize: 16,
    marginTop: 20,
  },
  tokenText: {
    marginTop: 20,
    color: "white",
    fontSize: 14,
  },
});
