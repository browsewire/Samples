import React, { Component } from 'react';
import {ActivityIndicator, Text, View,StyleSheet,ScrollView, Image } from 'react-native';
import { Tile, List, ListItem ,Icon,Button, Grid, Col } from 'react-native-elements';
import HTMLView from 'react-native-htmlview';
import CountDownReact from 'react_native_countdowntimer';
//import Video from 'react-html5video';

import Video from 'react-native-video';
import VideoPlayer from 'react-native-video-controls';


class ChannelLive extends Component {
constructor(props) {
    super(props);
    this.state = {
      isLoading: true
    }
  }

  componentDidMount() {
   const { Client } = this.props.navigation.state.params;
  
    return fetch('http://www.vlifetech.com/getclientsevent/'+Client.id)
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
    
    var actionBTN,countdownValHTML;
    var permissiontypesString = this.state.dataSource.Client.permissiontypes_id;
    
    
    if(this.state.dataSource.Liveevent){
    
    
    var countdown  = Date.parse(this.state.dataSource.eventDateTimeStart);
    var ctime = new Date(this.state.dataSource.currentTime);
    var currentDate = new Date();
    var twentyMinutesLater = new Date(currentDate.getTime() + (countdown - ctime));
    ctime = Date.parse(ctime);
    
    
    if(countdown > ctime){
     var countdownVal = (countdown - ctime)/1000;
     countdownValHTML = <View style={{paddingTop:0,}}>
            <View style={styles.cardItem}>
                <Tile
          imageSrc={{ uri: 'http://www.vlifetech.com/img/client/'+this.state.dataSource.Client.image}}
          featured
          title={`${this.state.dataSource.Client.name.toUpperCase()}`}
          caption='Live'
        />
                <View style={styles.cardItemMask}>
                  <View style={styles.cardItemTimer}>
                    
                    <View style={{flexDirection: 'row',alignItems:'baseline'}}>
                      <CountDownReact
                      date={twentyMinutesLater}
                      days={{plural: 'Days ',singular: 'Day '}}
                      hours=' '
                      mins=' '
                      segs=' '
                      />
                  </View>
              </View>
         </View>    
     </View>
     </View> 
    }else{
    var videoSource = this.state.dataSource.Client.iphone_event_url; 
    countdownValHTML = <VideoPlayer style={styles.video}
    source={{uri: videoSource }}
    navigator={ this.props.navigator }
    />
    }
     
     
    }
    
    if (permissiontypesString.indexOf("2") !=-1 && permissiontypesString.indexOf("29") !=-1 ) {
    actionBTN = <Grid>
    <Col><Button  title='On Demand' backgroundColor='#22B3F5' onPress={() => this.onDemand(this.state.dataSource)}/></Col>
    <Col><Button  title='24/7 Streaming' backgroundColor='#22B3F5' onPress={() => this.onStreaming(this.state.dataSource)}/></Col>
    </Grid>;
    }
    
    
    if (permissiontypesString.indexOf("2") ==-1 && permissiontypesString.indexOf("29") !=-1 ) {
    actionBTN = <Grid>
    <Col><Button  title='24/7 Streaming' backgroundColor='#22B3F5' onPress={() => this.onStreaming(this.state.dataSource)}/></Col>
    </Grid>;
    }
    
    if (permissiontypesString.indexOf("2") !=-1 && permissiontypesString.indexOf("29") ==-1 ) {
    actionBTN = <Grid>
    <Col><Button  title='On Demand' backgroundColor='#22B3F5' onPress={() => this.onDemand(this.state.dataSource)}/></Col>
    </Grid>;
    }
    
    
    
    
    
    
    return (
      <ScrollView>
        {countdownValHTML}
        
        
        <View style={styles.descriptioncontainer}>
        
        {actionBTN}
        
        </View>
      </ScrollView>
      
      
    );
  }
  
  
  onPlayStreaming = () => {
   alert('Start Live Now');
  };
  onDemand = (rowData) => {
   this.props.navigation.navigate('ChannelDemand',{ ...rowData });
  };
  onStreaming = (rowData) => {
   this.props.navigation.navigate('ChannelStreaming',{ ...rowData });
  };
  
  
  
}

var styles = StyleSheet.create({
  
 time: {
    paddingHorizontal: 5,
    backgroundColor: '#000',
    marginHorizontal: 5,
    borderRadius: 2,
    color: '#fff',
    },
    
    cardItemMask:{
    position: 'absolute',
    top: 15,
    right:10,
    backgroundColor: 'transparent'
    },
    cardItemTimer:{
    flexDirection: 'row',
    alignItems: 'center'
   },
  
  
  container: {
    backgroundColor: '#000',
    padding: 5,
    borderRadius: 5,
    flexDirection: 'row',
    marginTop:20
  },
  text: {
    fontSize: 30,
    color: '#FFF',
    marginLeft: 7,
  },
  
  descriptioncontainer: {
  marginTop: 5,
  marginBottom:5,
  },
  
  listView: {
    paddingTop: 20,
    backgroundColor: '#fff',
    marginBottom: 10,
  },
});


export default ChannelLive;
