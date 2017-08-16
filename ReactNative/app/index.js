import React, { Component } from 'react';

import {ActivityIndicator, ListView, Text, View,StyleSheet,ScrollView, Image } from 'react-native';
import {SideMenu, Header, Tile, List, ListItem ,Icon,Button, Grid, Col } from 'react-native-elements';

import { Root, Tabs } from './config/router';
import { users } from './config/data';

class App extends Component {
   
   constructor () {
    super()
    this.state = {
      isOpen: false
    }
    this.toggleSideMenu = this.toggleSideMenu.bind(this)
   }
  
  onSideMenuChange (isOpen: boolean) {
    this.setState({
      isOpen: isOpen
    })
  }
  
  toggleSideMenu () {
    this.setState({
      isOpen: !this.state.isOpen
    })
  }
  
  render() {
    const MenuComponent = (
    <View style={{flex: 1, backgroundColor: '#ededed', paddingTop: 50}}>
     <List containerStyle={{marginBottom: 20}}>
      {
        users.map((user) => (
          <ListItem
              key={user.login.username}
              title={`${user.name.first.toUpperCase()} ${user.name.last.toUpperCase()}`}
            />
        ))
      }
      </List>
    </View>
  )
  
    return (
      <SideMenu
        isOpen={this.state.isOpen}
        onChange={this.onSideMenuChange.bind(this)}
        menu={MenuComponent}>
        <Root />
      </SideMenu>
    );
  }
}


export default App;
