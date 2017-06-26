import { Component, ViewChild } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { SignaturePad } from 'angular2-signaturepad/signature-pad';
import { ScreenOrientation } from 'ionic-native';

import { Platform } from 'ionic-angular';
import { Page2Page } from '../page2/page2';
import { Page1Page } from '../page1/page1';


@Component({
  selector: 'page-annotation',
  templateUrl: 'annotation.html'
})
export class AnnotationPage {

  signature = '';
  isDrawing = false;
  orientation:any;
  
  notes: any = [];
  
 
  @ViewChild(SignaturePad) signaturePad: SignaturePad;
  
  private signaturePadOptions: Object = { 
    'minWidth': 2,
    'canvasWidth': screen.width,
    'canvasHeight': screen.height,
    'backgroundColor': '#000',
    'penColor': localStorage.getItem("penColor"),
    'backgroundImg': localStorage.getItem("base64Image")
  };
 
  constructor(public navCtrl: NavController, public navParams: NavParams,public platform: Platform) {
   this.notes.push(localStorage.getItem("base64Image"));
   
   let base64ImageCached  = JSON.parse(localStorage.getItem("base64ImageCached"));
   if(base64ImageCached){
   this.notes = base64ImageCached;
   }
      
 
    if(window.orientation == 0){
    ScreenOrientation.lockOrientation('portrait');
    }else{
    ScreenOrientation.lockOrientation('landscape');
    }
  
    platform.registerBackButtonAction(function (e) {
      e.preventDefault();
      return false;
    }); 
   
   
    
  }
 
 
   chooseColor(color) {
    this.signaturePad.set('penColor', color);
   }
  
  
  drawComplete() {
    this.isDrawing = false;
  }
 
  drawStart() {
    this.notes.push(this.signaturePad.toDataURL());
    this.isDrawing = true;
  }
 
  savePad() {
   
    localStorage.setItem("annotatedImage", this.signaturePad.toDataURL());
    localStorage.setItem("base64Image",this.signaturePad.toDataURL());
    localStorage.setItem("base64ImageCached",JSON.stringify(this.notes));
    if(this.notes.length > 0){
    localStorage.setItem("base64ImageOrigional", this.notes[0]);
    }
    //let baseImg = this.signaturePad.toDataURL();
    ScreenOrientation.unlockOrientation();
    this.navCtrl.push(Page2Page);
    //this.uploadimg(baseImg);
  }
 
  clearPad() {
  
    if(this.notes.length > 0){
    
      let newbgimg = this.notes[this.notes.length-1];
      this.signaturePad.set('backgroundImg', newbgimg);
      this.signaturePad.clear();
      this.notes.pop();
    
    }
  
  }
  
  goToStep1() {
    ScreenOrientation.unlockOrientation();
    this.navCtrl.push(Page1Page);
    
  }
  
  
  
  

}
