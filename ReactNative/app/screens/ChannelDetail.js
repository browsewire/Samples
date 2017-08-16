import React, { Component } from 'react';
import {ActivityIndicator, Text, View,StyleSheet,ScrollView, Image } from 'react-native';
import { Tile, List, ListItem ,Icon,Button, Grid, Col } from 'react-native-elements';
import HTMLView from 'react-native-htmlview';

class ChannelDetail extends Component {
constructor(props) {
    super(props);
    this.state = {
      isLoading: true
    }
  }

  componentDidMount() {
   const { Client } = this.props.navigation.state.params;
  
    return fetch('http://www.vlifetech.com/getclientdetail/'+Client.id)
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
    
    var emailHTML, phoneHTML, addressHTML,actionBTN;
    var permissiontypesString = this.state.dataSource.Client.permissiontypes_id;
   
    
    if (permissiontypesString.indexOf("2") !=-1 && permissiontypesString.indexOf("29") !=-1 ) {
    actionBTN = <Grid>
    <Col><Button  title='Live Streaming' backgroundColor='#22B3F5' onPress={() => this.onLive(this.state.dataSource)}/></Col>
    <Col><Button  title='On Demand' backgroundColor='#22B3F5' onPress={() => this.onDemand(this.state.dataSource)}/></Col>
    <Col><Button  title='24/7 Streaming' backgroundColor='#22B3F5' onPress={() => this.onStreaming(this.state.dataSource)}/></Col>
    </Grid>;
    }
    
    
    if (permissiontypesString.indexOf("2") ==-1 && permissiontypesString.indexOf("29") !=-1 ) {
    actionBTN = <Grid>
    <Col><Button  title='Live Streaming' backgroundColor='#22B3F5' onPress={() => this.onLive(this.state.dataSource)}/></Col>
    <Col><Button  title='24/7 Streaming' backgroundColor='#22B3F5' onPress={() => this.onStreaming(this.state.dataSource)}/></Col>
    </Grid>;
    }
    
    if (permissiontypesString.indexOf("2") !=-1 && permissiontypesString.indexOf("29") ==-1 ) {
    actionBTN = <Grid>
    <Col><Button  title='Live Streaming' backgroundColor='#22B3F5' onPress={() => this.onLive(this.state.dataSource)}/></Col>
    <Col><Button  title='On Demand' backgroundColor='#22B3F5' onPress={() => this.onDemand(this.state.dataSource)}/></Col>
    </Grid>;
    }
    
    if (permissiontypesString.indexOf("2") ==-1 && permissiontypesString.indexOf("29") ==-1 ) {
    actionBTN = <Grid>
    <Col><Button  title='Live Streaming' backgroundColor='#22B3F5' onPress={() => this.onLive(this.state.dataSource)}/></Col>
    </Grid>;
    }
    
    
    if(this.state.dataSource.Client.email){
      emailHTML = <View style={styles.rowcontainer}>
        <Icon name='email' color='#22B3F5' />
        <View style={styles.rightContainer}>
          <Text style={styles.description}>{this.state.dataSource.Client.email}</Text>
        </View>
       </View>;
    }
    
    
    if(this.state.dataSource.Client.phone){
      phoneHTML = <View style={styles.rowcontainer}>
        <Icon name='phone' color='#22B3F5' />
        <View style={styles.rightContainer}>
          <Text style={styles.description}>{this.state.dataSource.Client.phone}</Text>
        </View>
       </View>;
    }
    
    if(this.state.dataSource.Client.address_1){
      addressHTML =<View style={styles.rowcontainer}>
        <Icon name='my-location' color='#22B3F5' />
        <View style={styles.rightContainer}>
          <Text style={styles.description}>{this.state.dataSource.Client.address_1}  {this.state.dataSource.Client.zip_code}</Text>
        </View>
       </View>;
    }
    
    return (
      <ScrollView>
       <Tile
          imageSrc={{ uri: 'http://www.vlifetech.com/img/client/'+this.state.dataSource.Client.image}}
          featured
          title={`${this.state.dataSource.Client.name.toUpperCase()}`}
          caption={this.state.dataSource.Client.website_url}
        /> 
       
       {emailHTML}
       {phoneHTML}
       {addressHTML} 
        
        <View style={styles.descriptioncontainerhtml}>
          <HTMLView value={'<p>'+this.state.dataSource.Client.description+'</p>'} stylesheet={styles} />
        </View>
        
        <View style={styles.descriptioncontainer}>
        
        {actionBTN}
        
        </View>
      </ScrollView>
      
      
      
    );
  }
  
  
  onLive = (rowData) => {
   this.props.navigation.navigate('ChannelLive',{ ...rowData });
  };
  onDemand = (rowData) => {
   this.props.navigation.navigate('ChannelDemand',{ ...rowData });
  };
  onStreaming = (rowData) => {
   this.props.navigation.navigate('ChannelStreaming',{ ...rowData });
  };
  
  
  
}

var styles = StyleSheet.create({
  container: {
    flex: 1,
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    
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


export default ChannelDetail;
