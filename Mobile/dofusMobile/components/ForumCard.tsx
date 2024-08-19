import React from 'react';
import { View, Text, StyleSheet, Pressable } from 'react-native';

type ForumCardProps = {
    forum_id: string;
    forum_titre: string;
    forum_message: string;
    user_pseudo: string;
    forum_date: string;
    onPress: (forum_id: string) => void;
};

const ForumCard: React.FC<ForumCardProps> = ({
    forum_id,
    forum_titre,
    forum_message,
    user_pseudo,
    forum_date,
    onPress,
}) => {
    return (
        <Pressable style={styles.card} onPress={() => onPress(forum_id)}>
            <Text style={styles.title}>{forum_titre}</Text>
            <Text style={styles.message}>{forum_message}</Text>
            <Text style={styles.info}>
                Posted by: {user_pseudo} on {new Date(forum_date).toLocaleString()}
            </Text>
        </Pressable>
    );
};

const styles = StyleSheet.create({
    card: {
        width: '100%',
        backgroundColor: '#749245',
        borderRadius: 8,
        marginVertical: 10,
        padding: 15,
    },
    title: {
        fontSize: 18,
        fontWeight: 'bold',
        color: '#FFFFFF',
        marginBottom: 5,
    },
    message: {
        fontSize: 14,
        color: '#CCCCCC',
        marginBottom: 10,
    },
    info: {
        fontSize: 12,
        color: '#AAAAAA',
    },
});

export default ForumCard;
