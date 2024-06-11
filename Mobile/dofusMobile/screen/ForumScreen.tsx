import { FlatList, Text, View, StyleSheet } from "react-native";
import { Link, Stack, router } from "expo-router";

type Theme = {
    id: string;
    title: string;
};

const themes: Theme[] = [
    {
        id: 'bd7acbea-c1b1-46c2-aed5-3ad53abb28ba',
        title: 'First Item',
    },
    {
        id: '3ac68afc-c605-48d3-a4f8-fbd91aa97f63',
        title: 'Second Item',
    },
    {
        id: '58694a0f-3da1-471f-bd96-145571e29d72',
        title: 'Third Item',
    },
    {
        id: 'bd7acbea-c1b1-46c2-aed5-3ad53abb28ba',
        title: 'First Item',
    },
    {
        id: '3ac68afc-c605-48d3-a4f8-fbd91aa97f63',
        title: 'Second Item',
    },
    {
        id: '58694a0f-3da1-471f-bd96-145571e29d72',
        title: 'Third Item',
    },
    {
        id: 'bd7acbea-c1b1-46c2-aed5-3ad53abb28ba',
        title: 'First Item',
    },
    {
        id: '3ac68afc-c605-48d3-a4f8-fbd91aa97f63',
        title: 'Second Item',
    },
    {
        id: '58694a0f-3da1-471f-bd96-145571e29d72',
        title: 'Third Item',
    },
];

export const ForumScreen = () => {
    return (
        <View style={styles.container}>
            <FlatList
                data={themes}
                renderItem={({ item }) => (
                    <View style={styles.themeItem} key={item.id}>
                        <Text style={styles.themeText}>{item.title}</Text>
                    </View>
                )}
                horizontal
                showsHorizontalScrollIndicator={false}
                keyExtractor={(item) => item.id}
                contentContainerStyle={styles.flatListContent}

            />
            <View style={styles.content}>

                <Text style={styles.contentText}>Forum Page Content</Text>
            </View>
        </View>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    flatListContent: {
        paddingVertical: 10,
    },
    themeItem: {
        marginHorizontal: 10,
        padding: 10,
        backgroundColor: 'green',
        borderRadius: 10,
    },
    themeText: {
        fontSize: 16,
    },
    content: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
        padding: 50,
    },
    contentText: {
        fontSize: 18,
    },
});

export default ForumScreen;
