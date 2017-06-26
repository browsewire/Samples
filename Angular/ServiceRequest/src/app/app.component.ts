import { Component } from '@angular/core';

import { Platform, MenuController, Nav } from 'ionic-angular';

import { StatusBar, Splashscreen } from 'ionic-native';
import { SetupPage } from '../pages/setup/setup';
import { Page1Page } from '../pages/page1/page1';
import { Page2Page } from '../pages/page2/page2';


@Component({
  templateUrl: 'app.html'
})
export class MyApp {
  
  // make HelloIonicPage the root (or first) page
  
  
  rootPage: any;

  constructor(public platform: Platform ) {
    this.initializeApp();
  
  }

  initializeApp() {
    if(localStorage.getItem("login_name") 
    && localStorage.getItem("login_password")
    && localStorage.getItem("host_ip")
    && localStorage.getItem("db_name")
    && localStorage.getItem("language")){
    this.rootPage = Page1Page;
    }else{
    this.rootPage = SetupPage;
    }
    this.platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      //StatusBar.styleDefault();
      Splashscreen.hide();
    });
  }

  
}
