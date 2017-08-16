import React, { Component } from 'react';
import {
    View,
    Text,
} from 'react-native';
import {Header, Tile, List, ListItem ,Icon,Button, Grid, Col } from 'react-native-elements';
class Stack1 extends Component {


    

    render() {
        return (
            <Header
  leftComponent={{ icon: 'menu', color: '#fff' }}
  centerComponent={{ text: 'MY TITLE', style: { color: '#fff' } }} 
  rightComponent={{ icon: 'home', color: '#fff' }}
/>
        )
    }
}

export default Stack1;
