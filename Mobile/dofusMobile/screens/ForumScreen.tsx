import { jwtDecode } from 'jwt-decode';
import AsyncStorage from '@react-native-async-storage/async-storage';
import React, { useState, useEffect } from "react";
import {
    SafeAreaView,
    View,
    FlatList,
    Text,
    Button,
    TextInput,
    Pressable,
    StyleSheet,
    TouchableOpacity
} from "react-native";
import { useForums } from "../hooks/useForum";
import ForumCard from "../components/ForumCard";
import ResponseCard from "../components/ResponseCard";
import { Picker } from "@react-native-picker/picker";

export const ForumScreen = () => {
    const {
        themes = [],
        forums = [],
        responses = [],
        error,
        fetchForumsByTheme,
        fetchForumResponses,
        handleRefresh,
        createForum,
        createResponse,
    } = useForums();

    const [isDrawerVisible, setDrawerVisible] = useState(false);
    const [isFormVisible, setFormVisible] = useState(false);
    const [isResponseFormVisible, setResponseFormVisible] = useState(false);
    const [forumTitle, setForumTitle] = useState('');
    const [forumMessage, setForumMessage] = useState('');
    const [responseMessage, setResponseMessage] = useState('');
    const [selectedTheme, setSelectedTheme] = useState(themes.length > 0 ? themes[0].theme_id : '');
    const [createForumtext, setCreateForumText] = useState('Create Forum');
    const [createResponseText, setCreateResponseText] = useState('Create Response');
    const [selectedForumId, setSelectedForumId] = useState<string>();


    const [userId, setUserId] = useState<string | undefined>(undefined);
    useEffect(() => {
        const fetchTokenAndSetUser = async () => {
            try {
                const token = await AsyncStorage.getItem('userToken');
                if (token) {
                    const decodedToken = jwtDecode<{ sub: string }>(token);
                    console.log('Decoded token:', decodedToken);
                    setUserId(decodedToken.sub);
                }
            } catch (e) {
                console.error('Failed to retrieve or decode the token:', e);
            }
        };
        fetchTokenAndSetUser();
    }, []);

    useEffect(() => {
        setCreateForumText(isFormVisible ? 'Close' : 'Create Forum');
    }, [isFormVisible]);

    useEffect(() => {
        // Set the default theme to "General" or another specified theme
        const defaultTheme = themes.find(theme => theme.theme_nom === "Général");

        if (defaultTheme) {
            setSelectedTheme(defaultTheme.theme_id);
            handleThemePress(defaultTheme.theme_id); // Automatically fetch forums for the "General" theme
        }
    }, [themes]);

    const handleThemePress = async (themeId: string) => {
        try {
            await fetchForumsByTheme(themeId);
        } catch (e) {
            console.error(e);
        }
    };

    const handleForumPress = async (forumId: string) => {
        try {
            setSelectedForumId(forumId);
            await fetchForumResponses(forumId);
            setDrawerVisible(true);
        } catch (e) {
            console.error(e);
        }
    };

    const handleCreateForum = () => {
        setFormVisible(!isFormVisible);
    };

    const handleCreateResponse = () => {
        setResponseFormVisible(!isResponseFormVisible);
        setCreateResponseText(isResponseFormVisible ? 'Create Response' : 'Close');
    };

    const handleSubmit = async () => {
        if (forumTitle && forumMessage && selectedTheme && userId) {  // Ensure userId is set
            const newForum = {
                forum_titre: forumTitle,
                forum_message: forumMessage,
                user_id: userId,  // Use the extracted user_id from the token
                theme_id: selectedTheme,
            };
            try {
                await createForum(newForum);
                setFormVisible(false);
                await fetchForumsByTheme(selectedTheme); // Refresh the list after creation
            } catch (e) {
                console.error("Failed to create forum:", e);
            }
        } else {
            alert("Please fill out all fields.");
        }
    };

    const handleResponseSubmit = async () => {

        if (responseMessage && userId && selectedForumId) {  // Ensure userId and selectedForumId are set
            const newResponse = {
                reponse_message: responseMessage,
                user_id: userId,  // Use the extracted user_id from the token
                forum_id: selectedForumId,  // Use the selected forum_id
            };
            try {
                await createResponse(newResponse);
                setResponseFormVisible(false);
                setResponseMessage('');
                setCreateResponseText('Create Response');
                await fetchForumResponses(selectedForumId); // Refresh the responses after creation
            } catch (e) {
                console.error("Failed to create response:", e);
            }
        } else {
            alert("Please fill out the response message and select a forum.");
        }
    };


    if (error) {
        return (
            <View style={styles.container}>
                <Text style={styles.errorText}>Error: {error.message}</Text>
            </View>
        );
    }

    return (
        <SafeAreaView style={styles.safeContainer}>
            <View style={styles.container}>
                <View style={styles.themeContainer}>
                    <FlatList
                        data={themes}
                        renderItem={({ item }) => (
                            <Pressable
                                style={[
                                    styles.themeItem,
                                    { backgroundColor: item.theme_color || "#2e2924" },
                                ]}
                                onPress={() => handleThemePress(item.theme_id)}
                            >
                                <Text style={styles.themeText}>{item.theme_nom}</Text>
                            </Pressable>
                        )}
                        horizontal
                        keyExtractor={(item) => item.theme_id}
                    />
                </View>

                {isFormVisible ? (
                    <View style={styles.formContainer}>
                        <Text style={styles.formTitle}>Create a New Forum</Text>
                        <TextInput
                            style={styles.input}
                            placeholder="Title"
                            placeholderTextColor="#aaa"
                            value={forumTitle}
                            onChangeText={setForumTitle}
                        />
                        <TextInput
                            style={styles.input}
                            placeholder="Message"
                            placeholderTextColor="#aaa"
                            multiline
                            value={forumMessage}
                            onChangeText={setForumMessage}
                        />
                        <View style={styles.pickerContainer}>
                            <Text style={styles.pickerLabel}>Choose a theme</Text>
                            <Picker
                                selectedValue={selectedTheme}
                                onValueChange={(itemValue) => setSelectedTheme(itemValue)}
                                style={styles.picker}
                            >
                                {themes.map((theme) => (
                                    <Picker.Item
                                        key={theme.theme_id}
                                        label={theme.theme_nom}
                                        value={theme.theme_id}
                                    />
                                ))}
                            </Picker>
                        </View>
                        <Button title="Submit" onPress={handleSubmit} disabled={!forumTitle || !forumMessage || !selectedTheme || !userId} />
                    </View>
                ) : (
                    <FlatList
                        style={styles.forumListContent}
                        data={forums}
                        renderItem={({ item }) => (
                            <ForumCard
                                forum_id={item.forum_id || ''}
                                forum_titre={item.forum_titre}
                                forum_message={item.forum_message}
                                user_pseudo={item.user_pseudo || ''}
                                forum_date={item.forum_date || ''}
                                onPress={handleForumPress}
                            />
                        )}
                        keyExtractor={(item) => item.forum_id || ''}
                    />
                )}
                {isDrawerVisible && (
                    <View style={styles.responsedrawer}>
                        <TouchableOpacity
                            style={styles.closeButton}
                            onPress={() => setDrawerVisible(false)}
                        >
                            <Text style={styles.closeButtonText}>Close</Text>
                        </TouchableOpacity>



                        <FlatList
                            style={styles.responseListContent}
                            data={responses}
                            renderItem={({ item }) => (
                                <ResponseCard
                                    reponse_message={item.reponse_message}
                                    reponse_date={item.reponse_date || ''}
                                    user_pseudo={item.user_pseudo || ''}
                                />
                            )}
                            keyExtractor={(item) => item.reponse_id || ''}
                        />
                        {isResponseFormVisible && (
                            <View style={styles.formContainer}>
                                <Text style={styles.formTitle}>Create a New Response</Text>
                                <TextInput
                                    style={styles.input}
                                    placeholder="Your response"
                                    placeholderTextColor="#aaa"
                                    multiline
                                    value={responseMessage}
                                    onChangeText={setResponseMessage}
                                />
                                <Button title="Submit" onPress={handleResponseSubmit} disabled={!responseMessage || !userId} />
                            </View>
                        )}
                    </View>
                )}


                {isResponseFormVisible && (
                    <View style={styles.formContainer}>
                        <Text style={styles.formTitle}>Create a New Response</Text>
                        <TextInput
                            style={styles.input}
                            placeholder="Your response"
                            placeholderTextColor="#aaa"
                            multiline
                            value={responseMessage}
                            onChangeText={setResponseMessage}
                        />
                        <Button title="Submit" onPress={handleResponseSubmit} disabled={!responseMessage || !userId} />
                    </View>
                )}

                <View style={styles.buttonContainer} >
                    {!isDrawerVisible && <View style={styles.buttons} >
                        <Button title={createForumtext} onPress={handleCreateForum} />
                    </View>}
                    {isDrawerVisible && <View style={styles.buttons} >
                        <Button title={createResponseText} onPress={handleCreateResponse} />
                    </View>}

                    <View style={styles.buttons}>
                        <Button title="Refresh" onPress={handleRefresh} />
                    </View>
                </View>
            </View>
        </SafeAreaView >
    );
};

const styles = StyleSheet.create({
    responseListContent: {
        flex: 1,  // Allows it to grow and fill available space
    },
    safeContainer: {
        flex: 1,
        backgroundColor: "#f0f0f0",
    },
    container: {
        flex: 1,
        backgroundColor: "#3c3630",
    },
    responsedrawer: {
        position: "absolute",
        top: 30,
        left: 0,
        right: 0,
        height: "88%",
        backgroundColor: "#2e2924",
        padding: 15,
        borderTopLeftRadius: 10,
        borderTopRightRadius: 10,
        zIndex: 2,
    },
    closeButton: {
        alignSelf: 'flex-end',
        marginBottom: 10,
        paddingHorizontal: 15,
        paddingVertical: 8,
        backgroundColor: '#ff5c5c',
        borderRadius: 5,
        marginTop: 20,
    },
    closeButtonText: {
        color: '#fff',
        fontWeight: 'bold',
        fontSize: 16,
    },
    themeContainer: {
        paddingTop: 33,
        backgroundColor: "#3c3630",
        paddingVertical: 10,
        elevation: 5,
        zIndex: 1,
    },
    flatListContent: {
        paddingHorizontal: 10,
    },
    themeItem: {
        marginHorizontal: 5,
        paddingVertical: 10,
        paddingHorizontal: 20,
        minWidth: 100,
        height: 40,
        borderRadius: 10,
        justifyContent: "center",
        alignItems: "center",
    },
    themeText: {
        fontSize: 16,
        color: "#FFFFFF",
        textAlign: "center",
    },
    forumListContent: {
        padding: 10,
        paddingBottom: 60,
        flex: 1,  // Allows it to grow and fill available space
    },
    buttonContainer: {
        position: "absolute",
        bottom: 0,
        left: 0,
        right: 0,
        backgroundColor: "#3c3630",
        padding: 10,
        alignItems: "center",
        justifyContent: "center",
        flexDirection: "row",
        height: 60,  // Ensure it has a fixed height
    },
    buttons: {
        marginHorizontal: 10,
    },
    errorText: {
        textAlign: "center",
        margin: 20,
    },
    formContainer: {
        padding: 20,
        backgroundColor: '#3c3630',
        borderRadius: 10,
        margin: 10,
    },
    formTitle: {
        fontSize: 18,
        color: '#fff',
        marginBottom: 10,
    },
    input: {
        backgroundColor: '#fff',
        borderRadius: 5,
        padding: 10,
        marginBottom: 10,
    },
    pickerContainer: {
        marginBottom: 10,
    },
    pickerLabel: {
        color: '#fff',
        marginBottom: 5,
    },
    picker: {
        backgroundColor: '#fff',
        borderRadius: 5,
    },
});

export default ForumScreen;
