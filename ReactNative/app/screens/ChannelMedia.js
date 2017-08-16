import React, { Component } from 'react';
import {ActivityIndicator, Text, View,StyleSheet,ScrollView, Image } from 'react-native';
import { Tile, List, ListItem ,Icon,Button, Grid, Col } from 'react-native-elements';
import HTMLView from 'react-native-htmlview';
import Video from 'react-native-video';
import VideoPlayer from 'react-native-video-controls';

class ChannelMedia extends Component {
constructor(props) {
    super(props);
    this.state = {
      isLoading: true
    }
  }

  componentDidMount() {
   const { MediaID,ClientID } = this.props.navigation.state.params;
  
    return fetch('http://www.vlifetech.com/getclientmediadeails/'+MediaID+'/'+ClientID)
      .then((response) => response.json())
      .then((responseJson) => {
        this.setState({
          isLoading: false,
          dataSource: responseJson,
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
    
    
    
     
    
    
    var videoSource = 'http://cdn.vlifetech.com/1.0/'+this.state.dataSource.ClientId+'/'+this.state.dataSource.Media.filename; 
    //+this.state.dataSource.ClientId+'/'+this.state.dataSource.Media.filename;
    
    return (
    <VideoPlayer style={styles.video}
    source={{uri: videoSource }}
    navigator={ this.props.navigator }
    /*
      ref={(ref) => {
         this.player = ref
       }}                                      // Store reference
       rate={1.0}                              // 0 is paused, 1 is normal.
       volume={1.0}                            // 0 is muted, 1 is normal.
       muted={false}                           // Mutes the audio entirely.
       paused={false}                          // Pauses playback entirely.
       repeat={false}                           // Repeat forever.
       playInBackground={false}                // Audio continues to play when app entering background.
       playWhenInactive={false}                // [iOS] Video continues to play when control or notification center are shown.
    */  
    />
      
    );
  }
  
  
 
  
  
  
}

var styles = StyleSheet.create({
  container: {
    flex: 1,
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    
  },
  video: {
    position: 'absolute',
    top: 0,
    left: 0,
    bottom: 0,
    right: 0,
  },
  rowcontainer: {
    flex: 1,
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    marginLeft: 10,
    marginRight: 10,
    marginTop: 5,
    marginBottom: 0,
    
  },
  p:{
  marginLeft: 10,
  marginRight: 10,
  fontSize: 16,
  color:'#000',
  marginBottom: 5,
  },
  descriptioncontainerhtml: {
  marginTop: 5,
  marginBottom:5,
  marginLeft: 10,
  marginRight: 10,
  },
  descriptioncontainer: {
  marginTop: 5,
  marginBottom:5,
  },
  rightContainer: {
    flex: 1,
  },
  title: {
    fontSize: 20,
    textAlign: 'left',
    color:'#000',
  },
  description: {
    fontSize: 16,
    textAlign: 'left',
    marginLeft: 10,
    color:'#000',
    
  },
  year: {
    textAlign: 'center',
  },
  thumbnail: {
    width: 55,
    height: 55,
    marginLeft: 5,
    marginRight: 5,
    marginTop: 5,
    marginBottom: 5,
    borderRadius: 50,
  },
  listView: {
    paddingTop: 20,
    backgroundColor: '#fff',
    marginBottom: 10,
  },
});



export default ChannelMedia;
