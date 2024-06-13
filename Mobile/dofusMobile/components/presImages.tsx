import { ReactNode } from "react";
import { Pressable, Text } from "react-native";

interface ButtonProps {
    children: ReactNode;
    onPress: () => void;
}
export function PresImages({children, onPress} : ButtonProps) {
    return(        
      <Pressable style={{
        backgroundColor:"green", 
        //height:100, 
        width:50,
        //justifyContent:"center", 
        //alignItems:"center", 
        borderRadius:20,
        marginBottom:10,
      }}
        onPress={onPress}      
      >
        {children}     
       </Pressable>  
    );
}