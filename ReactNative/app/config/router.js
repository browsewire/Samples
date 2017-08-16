import React from 'react';
import { TabNavigator, StackNavigator } from 'react-navigation';
import { Icon } from 'react-native-elements';

import Channel from '../screens/Channel';
import ChannelDetail from '../screens/ChannelDetail';
import ChannelLive from '../screens/ChannelLive';
import ChannelDemand from '../screens/ChannelDemand';
import ChannelCategory from '../screens/ChannelCategory';
import ChannelMedia from '../screens/ChannelMedia';

import ChannelStreaming from '../screens/ChannelStreaming';



export const ChannelStack = StackNavigator({
  
  Channel: {
    screen: Channel,
    navigationOptions: {
      title: 'CHURCH LIST',
    },
  },
  
  ChannelDetail: {
    screen: ChannelDetail,
    navigationOptions: ({ navigation }) => ({
     title: `${navigation.state.params.Client.name.toUpperCase()}`,
    }),
  },
  
  ChannelLive: {
    screen: ChannelLive,
    navigationOptions: ({ navigation }) => ({
     title: `${navigation.state.params.Client.name.toUpperCase()}`,
    }),
  },
  ChannelDemand: {
    screen: ChannelDemand,
    navigationOptions: ({ navigation }) => ({
     title: `${navigation.state.params.Client.name.toUpperCase()}`,
    }),
  },
  
  
  ChannelCategory: {
    screen: ChannelCategory,
    navigationOptions: ({ navigation }) => ({
     title: `${navigation.state.params.MediacategoryName.toUpperCase()}`,
    }),
  },
  
  ChannelMedia: {
    screen: ChannelMedia,
    navigationOptions: ({ navigation }) => ({
     title: `${navigation.state.params.MediaName.toUpperCase()}`,
    }),
  },
  
  ChannelStreaming: {
    screen: ChannelStreaming,
    navigationOptions: ({ navigation }) => ({
     title: `${navigation.state.params.Client.name.toUpperCase()}`,
    }),
  },
  
});

export const Tabs = TabNavigator({

  
  Denomination: {
    screen: ChannelStack,
    navigationOptions: {
      tabBarLabel: 'Denomination',
      tabBarIcon: ({ tintColor }) => <Icon name="menu" size={35} color={tintColor} />,
    },
  },
  Location: {
    screen: ChannelStack,
    navigationOptions: {
      tabBarLabel: 'Location',
      tabBarIcon: ({ tintColor }) => <Icon name="list" size={35} color={tintColor} />,
    },
  },
  Favorites: {
    screen: ChannelStack,
    navigationOptions: {
      tabBarLabel: 'Favorites',
      tabBarIcon: ({ tintColor }) => <Icon name="list" size={35} color={tintColor} />,
    },
  },
  
  
});


export const Root = StackNavigator({
  
    Tabs: {
      screen: Tabs,
    }
   }, 
    {
    mode: 'modal',
    headerMode: 'none',
    }
);
