import Ionicons from "@expo/vector-icons/Ionicons";
import { Button, Pressable, StyleSheet, Alert } from "react-native";
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
      // Vous pouvez maintenant utiliser le token pour les requêtes futures
      navigation.navigate("Profil");
      console.log("Token:", token);
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.text}>Connection</Text>
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
      <Link
        style={styles.text}
        href={{
          pathname: "/screens/SignUp",
        }}
      >
        Inscription
      </Link>
      {token && <Text style={styles.tokenText}>Token: {token}</Text>}
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    marginTop: "50%",
    alignItems: "center",
  },
  text: {
    color: "white",
  },
  input: {
    height: 40,
    margin: 12,
    borderWidth: 1,
    padding: 10,
    width: "80%",
    borderRadius: 5,
    backgroundColor: "white",
  },
  button: {
    backgroundColor: "#007AFF",
    padding: 10,
    borderRadius: 5,
    marginBottom: 10,
  },
  buttonPressed: {
    backgroundColor: "#005BBB",
  },
  buttonText: {
    color: "white",
    fontSize: 16,
    textAlign: "center",
  },
  tokenText: {
    marginTop: 20,
    color: "white",
  },
});
