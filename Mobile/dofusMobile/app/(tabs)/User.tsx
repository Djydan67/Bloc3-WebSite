import Ionicons from "@expo/vector-icons/Ionicons";
import { Button, Pressable, StyleSheet } from "react-native";
import { View, Text, TextInput } from "react-native";
import * as React from "react";
import { Link } from "expo-router";

export default function TabTwoScreen() {
  const [email, onChangeEmail] = React.useState("");
  const [password, onChangePassword] = React.useState("");

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
        onPress={() => alert("welcome to the futur !")}
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
});
