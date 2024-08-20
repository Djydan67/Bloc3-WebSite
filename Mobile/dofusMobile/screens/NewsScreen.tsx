import React, { useEffect, useState } from "react";
import { FlatList, Image, StyleSheet, Text, View } from "react-native";

type Article = {
  article_title: string;
  user_id: number;
  article_id: number;
  article_message: string;
  article_ImgID: string;
  T_article: string;
  article_datecreation: string;
};

const NewsScreen: React.FC = () => {
  const [articles, setArticles] = useState<Article[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchArticles = async () => {
      try {
        const response = await fetch(
          "http://192.168.177.113/Bloc3-WebSite/index.php?ctrl=article&action=Articles"
        );
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();

        // Mapping des données
        setArticles(data);
      } catch (error) {
        setError("Erreur lors de la récupération des articles.");
        console.error("Erreur lors de la récupération des articles:", error);
      } finally {
        setLoading(false);
      }
    };

    fetchArticles();
  }, []);

  const renderItem = ({ item }: { item: Article }) => (
    <View style={styles.articleContainer}>
      <Image source={{ uri: item.article_ImgID }} style={styles.articleImage} />
      <Text style={styles.articleTitle}>{item.article_title}</Text>
      <Text style={styles.articleDate}>{item.article_datecreation}</Text>
      <Text style={styles.articleMessage}>{item.article_message}</Text>
    </View>
  );

  if (loading) {
    return (
      <View style={styles.container}>
        <Text>Loading articles...</Text>
      </View>
    );
  }

  if (error) {
    return (
      <View style={styles.container}>
        <Text>{error}</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <FlatList
        data={articles}
        renderItem={renderItem}
        keyExtractor={(item) => item.article_id.toString()}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
    backgroundColor: "#fff",
  },
  articleContainer: {
    marginBottom: 20,
    borderBottomWidth: 1,
    borderBottomColor: "#ccc",
    paddingBottom: 10,
  },
  articleImage: {
    width: "100%",
    height: 200,
    marginBottom: 10,
    borderRadius: 8,
  },
  articleTitle: {
    fontSize: 18,
    fontWeight: "bold",
    marginBottom: 5,
  },
  articleDate: {
    fontSize: 12,
    color: "#777",
    marginBottom: 10,
  },
  articleMessage: {
    fontSize: 16,
    lineHeight: 22,
  },
});

export default NewsScreen;
