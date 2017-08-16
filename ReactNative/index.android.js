import { AppRegistry } from 'react-native';
import App from './app/index';
console.disableYellowBox = true; // hide all warning from app
AppRegistry.registerComponent('FirstLook', () => App);
