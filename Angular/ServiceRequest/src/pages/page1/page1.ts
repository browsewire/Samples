import { Component } from '@angular/core';
import {NavController, NavParams } from 'ionic-angular';
import { Platform, Events } from 'ionic-angular';
import { NgZone } from "@angular/core";
import {Device} from 'ionic-native';

import { Camera } from 'ionic-native';
import { SetupPage } from '../setup/setup';
import { Page2Page } from '../page2/page2';
import { AnnotationPage } from '../annotation/annotation';





@Component({
  selector: 'page-page1',
  templateUrl: 'page1.html',
  
})

export class Page1Page {
  
  
    
  public title: string ;
  public subtitle: string;
  public loginName: string; 
  public base64Image: string;
  public base64ImageOrigional: string;
  notes: any = [];
  
  
  constructor(public navCtrl: NavController, public navParams: NavParams, public platform: Platform,) {
    
   
    //localStorage.clear();
    this.title= "SERVICE REQUEST";
    this.subtitle= "User Name :";
    this.loginName= localStorage.getItem("login_name");
    
    localStorage.setItem("locationText",'');
    localStorage.setItem("locationId",'');
    localStorage.setItem("serviceLocation",'');
    localStorage.setItem("servicePriority",'');
    localStorage.setItem("serviceCategory",'');
    localStorage.setItem("serviceRemarks",'');
    localStorage.setItem("mediafile",'');
    
    
    let number = 0;
    localStorage.setItem("tduration",number.toString());
    localStorage.setItem("penColor", '#ff0000');
    
     platform.registerBackButtonAction(function (e) {
      e.preventDefault();
      return false;
      });

    
      
  }

    
    
   

 
takePicture(){

  
  
   Camera.getPicture({
        quality : 50,
        sourceType: 1,
        correctOrientation: true,
        targetWidth:screen.width,
        targetHeight:screen.height, 
        saveToPhotoAlbum: false,
    }).then((imageData) => {
        localStorage.setItem("base64Image", imageData);
        localStorage.setItem("base64ImageOrigional", imageData);
        localStorage.setItem("base64ImageCached",JSON.stringify(this.notes));
        this.movetoannotation();
    }, (err) => {
        console.log(err);
    });
 
  }
  
selectPicture(){

   
    Camera.getPicture({
        quality : 50,
        sourceType: 0,
        correctOrientation: true,
         targetWidth:screen.width,
        targetHeight:screen.height,
        saveToPhotoAlbum: false,
        
    }).then((imageData) => {
        localStorage.setItem("base64Image", imageData);
        localStorage.setItem("base64ImageOrigional", imageData);
        localStorage.setItem("base64ImageCached",JSON.stringify(this.notes));
        this.movetoannotation();
    }, (err) => {
        
        //console.log(err);
    });
 
  }
  
movetoannotation(){
      this.navCtrl.push(AnnotationPage);

}  
itemTapped() {
    localStorage.setItem("base64Image", '');
    localStorage.setItem("annotatedImage", '');
    localStorage.setItem("base64ImageOrigional", '');
    localStorage.setItem("base64ImageCached",'');
    this.navCtrl.push(Page2Page);
  }
  
itemTappedSetup(){
 this.navCtrl.push(SetupPage);
}
}

