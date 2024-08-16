import React from 'react';
import { View, Text, StyleSheet } from 'react-native';

type ResponseCardProps = {
    reponse_message: string;
    reponse_date: string;
    user_pseudo: string;
};

const ResponseCard: React.FC<ResponseCardProps> = ({
    reponse_message,
    reponse_date,
    user_pseudo,
}) => {
    return (
        <View style={styles.card}>
            <Text style={styles.message}> {user_pseudo} :</Text>
            <Text style={styles.message}>{reponse_message}</Text>
            <Text style={styles.info}>
                Le {new Date(reponse_date).toLocaleString()}
            </Text>
        </View>
    );
};

const styles = StyleSheet.create({
    card: {
        marginTop: 10,
        backgroundColor: '#3c3630',
        padding: 15,
        borderRadius: 10,
        marginBottom: 10,
    },
    message: {
        fontSize: 14,
        color: '#CCCCCC',
        marginBottom: 5,
    },
    info: {
        fontSize: 12,
        color: '#AAAAAA',
    },
});

export default ResponseCard;
