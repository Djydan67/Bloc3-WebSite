import { Tabs } from "expo-router";
import React from "react";

import { TabBarIcon } from "@/components/navigation/TabBarIcon";
import { Colors } from "@/constants/Colors";
import { useColorScheme } from "@/hooks/useColorScheme";
import FontAwesome6 from "@expo/vector-icons/build/FontAwesome6";

export default function TabLayout() {
  const colorScheme = useColorScheme();

  return (
    <Tabs
      screenOptions={{
        tabBarActiveTintColor: Colors[colorScheme ?? "light"].tint,
        headerShown: false,
      }}
    >
      <Tabs.Screen
        name="index"
        options={{
          title: "Home",
          tabBarIcon: ({ color, focused }) => (
            <TabBarIcon
              name={focused ? "home" : "home-outline"}
              color={color}
            />
          ),
        }}
      />
      <Tabs.Screen
        name="stuff"
        options={{
          title: "Stuff",
          headerTitle: "Encyclopedie",
          headerShown: true,
          tabBarIcon: ({ color, focused }) => (
            <TabBarIcon
              name={focused ? "book" : "book-outline"}
              color={color}
            />
          ),
        }}
      />
      <Tabs.Screen
        name="explore"
        options={{
          title: "Explore",
          tabBarIcon: ({ color, focused }) => (
            <TabBarIcon
              name={focused ? "code-slash" : "code-slash-outline"}
              color={color}
            />
          ),
        }}
      />
      <Tabs.Screen
        name="Profil"
        options={{
          title: "Profil",
          tabBarIcon: ({ color, focused }) => (
            <FontAwesome6 name="circle-user" size={24} color={color} />
          ),
        }}
      />

      <Tabs.Screen
        name="forum"
        options={{
          title: "Forum",
          tabBarIcon: ({ color, focused }) => (
            <TabBarIcon name={"chatbubbles"} color={color} />
          ),
        }}
      />

      <Tabs.Screen
        name="Connexion"
        options={{
          title: "Connexion",
          tabBarIcon: ({ color, focused }) => (
            <FontAwesome6 name="user" size={24} color={color} />
          ),
        }}
      />
    </Tabs>
  );
}
