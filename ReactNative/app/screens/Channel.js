import React, { Component } from 'react';
import {ActivityIndicator, ListView, Text, View,StyleSheet,ScrollView, Image } from 'react-native';
import {Tile, List, ListItem ,Icon,Button, Grid, Col } from 'react-native-elements';


class Channel extends Component {

constructor(props) {
    super(props);
    this.state = {
      isLoading: true,
      
    }
    
  }
  componentDidMount() {
    return fetch('http://www.vlifetech.com/getclientlist/')
      .then((response) => response.json())
      .then((responseJson) => {
        let ds = new ListView.DataSource({rowHasChanged: (r1, r2) => r1 !== r2});
        this.setState({
          isLoading: false,
          dataSource: ds.cloneWithRows(responseJson),
        }, function() {
          // do something with new state
        });
      })
      .catch((error) => {
        console.error(error);
      });
  }

  render() {
    
    if (this.state.isLoading) {
      return (
      
        <View style={{flex: 1, paddingTop: 20}}>
          <ActivityIndicator />
        </View>
      );
    }

    return (
    
      
      <ScrollView>
        <List>
          <ListView dataSource={this.state.dataSource}
            renderRow={this.renderMovie.bind(this)}
          />
      </List> 
      </ScrollView>
      
      
      
    );
  }
  
  renderMovie(rowData) {
    return (
            <ListItem
              key={rowData.Client.email}
              roundAvatar
              avatar={{ uri: 'http://www.vlifetech.com/img/client/logo/'+rowData.Client.logo }}
              title={`${rowData.Client.name.toUpperCase()}`}
              onPress={() => this.onLearnMore(rowData)}
            />
    );
  }
  
  
  onLearnMore = (rowData) => {
   this.props.navigation.navigate('ChannelDetail',{ ...rowData });
  };
}




export default Channel;
