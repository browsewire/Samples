import { Component} from '@angular/core';
import {NavController, NavParams} from 'ionic-angular';
import { MediaPlugin } from 'ionic-native';
import { Platform } from 'ionic-angular';
import {BarcodeScanner} from 'ionic-native';
import {Device} from 'ionic-native';
import { AlertController } from 'ionic-angular';
import {Http, Headers, RequestOptions} from '@angular/http';
import {Transfer} from 'ionic-native';
import { LoadingController } from 'ionic-angular';

import { Page1Page } from '../page1/page1';
import { AnnotationPage } from '../annotation/annotation';
import { SetupPage } from '../setup/setup';


declare var navigator: any;
declare var Connection: any;
@Component({
  selector: 'page-page2',
  templateUrl: 'page2.html'
})

export class Page2Page {

 FileTransfer:any;

 media: MediaPlugin;
 beepmedia: MediaPlugin;
 public annotatedImage = localStorage.getItem("annotatedImage");
 public annotatedImageUrl: string = '';
 public photoOrigional = localStorage.getItem("base64ImageOrigional");
 public photoOrigionalUrl: string = '';
 public audioFileUrl: string = '';
 public title: string ;
 public subtitle: string;
 public loginName: string;
 public lastrecird: string;
 public createClass: string = 'active';
 public checkmarkClass: string = '';


 public mediafile: string;
 public beepsound: string;
 public mediastatus: string;
 public isrecording:boolean;
 public isplaying:boolean;
 public serverResponce: string;
 

 timeoutId: any = null;
 timeoutId2: any = null;
 timeoutIdSub: any = null;
 intervalId: any = null;
 intervalId2: any = null;
 oploadloader: any = null;

 tduration =parseInt(localStorage.getItem("tduration"));
 lduration =0;
 validationerror = true;
 timeper =0;
 scanDetails: any = null;

 /*form data*/
 public locationText = localStorage.getItem("locationText");
 public serviceLocation = localStorage.getItem("serviceLocation") ;
 public locationId = localStorage.getItem("locationId") ;
 public servicePriority= localStorage.getItem("servicePriority") ;
 public serviceCategory = localStorage.getItem("serviceCategory") ;
 public serviceRemarks = localStorage.getItem("serviceRemarks") ;
 public webserviceURL = localStorage.getItem("webserviceURL");
 public webuploadURL = localStorage.getItem("webuploadURL");
 
 
 priprityList: any[] = [];
 locationList: any[] = [];
 categoryList: any[] = [];





constructor(private http: Http, public alertController: AlertController,public loadingCtrl: LoadingController,public navCtrl: NavController, public navParams: NavParams, public platform: Platform) {

      this.mediafile = localStorage.getItem("mediafile");
      this.media = new MediaPlugin(this.mediafile);
      
      
      
       
    
    platform.registerBackButtonAction(function (e) {
      e.preventDefault();
      return false;
    });
    
    this.categoryList = JSON.parse(localStorage.getItem("categoryList"));
    this.locationList = JSON.parse(localStorage.getItem("locationList"));
    this.priprityList = JSON.parse(localStorage.getItem("priprityList"));
    
    this.title= "SERVICE REQUEST";
    this.subtitle= "User Name :";
    this.loginName= localStorage.getItem("login_name");


    this.beepsound = '/android_asset/www/img/beep-06.mp3';
    this.beepmedia = new MediaPlugin(this.beepsound);

    
  }


    
onChange(){

let cLocation =  this.locationList.filter(location => location.Location_ID == this.serviceLocation)[0];
if(cLocation){
this.locationText = cLocation.Location_Name;
this.locationId = this.serviceLocation;
}else{
this.locationId = '';
this.locationText = '';
this.serviceLocation = '';
let alert = this.alertController.create({
      title: 'System',
      subTitle: 'Location ID is not recognized !',
      buttons: ['Ok']
    });
    alert.present();
}
}

onChange2(){

if(this.locationId.length > 0){
let cLocation =  this.locationList.filter(location => location.Location_ID == this.locationId)[0];
if(cLocation){
this.locationText = cLocation.Location_Name;
this.serviceLocation = this.locationId;
}else{
this.locationId = '';
this.locationText = '';
this.serviceLocation = '';
let alert = this.alertController.create({
      title: 'System',
      subTitle: 'Location ID is not recognized !',
      buttons: ['Ok']
    });
    alert.present();
}
}else{
this.locationId = '';
this.locationText = '';
this.serviceLocation = '';
}

}

startScan() {


    BarcodeScanner.scan()
    .then((result) => {
    if (!result.cancelled) {

     if(result.text){

     let cLocation =  this.locationList.filter(location => location.Location_ID == result.text)[0];
     if(cLocation){
     this.beepmedia.play();
     this.locationText = cLocation.Location_Name;
     this.serviceLocation = result.text;
     this.locationId = result.text;
     }else{
      this.locationId = '';
      this.locationText = '';
      this.serviceLocation = '';
      let alert = this.alertController.create({
      title: 'System',
      subTitle: 'Location ID is not recognized !',
      buttons: ['Ok']
      });
      alert.present();
     }
     }else{
      this.locationId = '';
      this.locationText = '';
      this.serviceLocation = '';
      let alert = this.alertController.create({
      title: 'System',
      subTitle: 'Location ID is not recognized !',
      buttons: ['Ok']
      });
      alert.present();
     }
    }
    })
    .catch((err) => {

      this.locationId = '';
      this.locationText = '';
      this.serviceLocation = '';
      let alert = this.alertController.create({
        title: 'System',
        subTitle: 'Location ID is not recognized !',
        buttons: ['Ok']
      });
      alert.present();
    })

}


startRecording() {

   this.mediafile = "cdvfile://localhost/temporary/recording.wav";

   this.media = new MediaPlugin(this.mediafile);
   this.media.startRecord();

   this.tduration=0;
   this.isrecording =true;
   this.isplaying =false;

   this.intervalId = setInterval(() => {
   this.tduration++;
   }, 1000);

   this.timeoutId = setTimeout(() => {
     this.media.stopRecord();

      this.timeoutId = null;
      this.isrecording =false;
      if (this.intervalId != null) {
      clearInterval(this.intervalId);
      this.intervalId = null;
      }
}, 31000);

}

stopRecording() {

this.isrecording =false;


if (this.timeoutId != null) {
      clearTimeout(this.timeoutId);
      this.timeoutId = null;
}

if (this.intervalId != null) {
      clearInterval(this.intervalId);
      this.intervalId = null;
}

this.media.stopRecord();
}

startPlayback() {

  this.isplaying =true;
  this.media.play();

  this.lduration = 0;
  this.timeper = 0;

    this.intervalId2 = setInterval(() => {
       this.timeper++;
       this.lduration = this.timeper/this.tduration*100;
    }, 1000);

    let delayTime = (this.tduration*1000)+1000;
    this.timeoutId2 = setTimeout(() => {

      this.timeoutId2 = null;
      this.isplaying =false;

      if (this.intervalId2 != null) {
      clearInterval(this.intervalId2);
      this.intervalId2 = null;
      }

    }, delayTime);

}

stopPlayback() {

this.isplaying =false;
this.media.stop();

}

annotateAgain() {
this.saveformdata();
this.navCtrl.push(AnnotationPage);
}

backTapped() {
if(this.isplaying){
this.stopPlayback();
}

if(this.isrecording){
this.stopRecording();
}

this.navCtrl.push(Page1Page);
}



checkserverconnection(){
this.timeoutIdSub = setTimeout(() => {
      this.oploadloader.dismiss();
      let alert = this.alertController.create({
      title: 'System',
      subTitle: 'No network connection !',
      buttons: ['Ok']
      });
alert.present();
}, 50000);
    this.oploadloader = this.loadingCtrl.create({
        content: "Please wait..."
      });
   this.oploadloader.present();
   
    let link = this.webserviceURL
     
        var data = JSON.stringify(
        {
    		  action: "checkConnection",
    			login_name: localStorage.getItem("login_name"),
    			login_password: localStorage.getItem("login_password"),
    			host_ip:localStorage.getItem("host_ip"),
    			db_name:localStorage.getItem("db_name"),
    			language:localStorage.getItem("language")
    		}
        );
        
        this.http.post(link, data)
        .map(res => res.json()).subscribe(data => {
    this.serverResponce = data;
    
    if(this.serverResponce == '0'){
    localStorage.setItem("returnPage",'');
    
    if (this.timeoutIdSub != null) {
      clearTimeout(this.timeoutIdSub);
      this.timeoutIdSub = null;
    }
    this.uploadImg(this.annotatedImage);
   
    }else if(this.serverResponce == '22'){
    if (this.timeoutIdSub != null) {
      clearTimeout(this.timeoutIdSub);
      this.timeoutIdSub = null;
    }
    this.oploadloader.dismiss();
  let alert = this.alertController.create({
      title: 'System',
      subTitle: "Server authentication failed !",
      buttons: [
                      {
                        text: 'Ok',
                        role: 'cancel',
                        handler: () => {
                          localStorage.setItem("returnPage",'Page2Page');
                          this.navCtrl.push(SetupPage);
                        }
                      }
                    ]
    });
    alert.present();
    
  }else{
  if (this.timeoutIdSub != null) {
      clearTimeout(this.timeoutIdSub);
      this.timeoutIdSub = null;
    }
  this.oploadloader.dismiss();
  let alert = this.alertController.create({
      title: 'System',
      subTitle: "Cannot connect to server !",
       buttons: [
                      {
                        text: 'Ok',
                        role: 'cancel',
                        handler: () => {
                          localStorage.setItem("returnPage",'Page2Page');
                          this.navCtrl.push(SetupPage);
                        }
                      }
                    ]
    });
  alert.present();
  
  }
  
  });  
}
submitForm() {

if(!this.locationId || !this.servicePriority || !this.serviceCategory){
this.validationerror = false;
let alert = this.alertController.create({
      title: 'System',
      subTitle: 'Location, Category and Priority are mandatory !',
      buttons: ['Ok']
    });
    alert.present();
}else{
this.validationerror = true;
}
if(this.validationerror){

if(this.serviceRemarks || this.annotatedImage || this.tduration){
this.validationerror = true;
}else{
this.validationerror = false;
let alert = this.alertController.create({
      title: 'System',
      subTitle: 'Must submit either Photo or Voice Memo, or enter Remarks !',
      buttons: ['Ok']
    });
    alert.present();
}

}
if(this.validationerror){
   
   this.saveformdata(); 
   
   if(navigator.connection.type == 'none'){
            
let alert = this.alertController.create({
title: 'System',
subTitle: 'No network connection !',
buttons: ['Ok']
});
alert.present();
}else{
   this.checkserverconnection();
   }
  
}



}


saveformdata(){

localStorage.setItem("mediafile",this.mediafile);
localStorage.setItem("tduration",this.tduration.toString());
localStorage.setItem("locationText",this.locationText);
localStorage.setItem("locationId",this.locationId);
localStorage.setItem("serviceLocation",this.serviceLocation);
localStorage.setItem("servicePriority",this.servicePriority);
localStorage.setItem("serviceCategory",this.serviceCategory);
localStorage.setItem("serviceRemarks",this.serviceRemarks);
     
}


uploadImg = (image: string) : void => {
  if(image){
  
        let ft = new Transfer();
        let url = this.webuploadURL+'uploadphoto.php';
        let filename = "p.jpg";
        let options = {
            fileKey: 'file',
            fileName: filename,
            mimeType: 'image/jpeg',
            chunkedMode: false,
            headers: {
                'Content-Type' : undefined
            },
            params: {
                fileName: filename,
                host_ip:localStorage.getItem("host_ip"),
                
            }
          };

        ft.upload(image, url, options, false)
        .then((result: any) => {
        console.log(result);
       // alert(result.response);
         this.annotatedImageUrl= result.response;
        
        this.uploadImg2(this.photoOrigional);
        }).catch((error: any) => {
        console.log(error);
            this.oploadloader.dismiss();
            let alert = this.alertController.create({
            title: 'System',
            subTitle: 'Can not uplaod Photo',
            buttons: ['Ok']
            });
            alert.present();
        });
        
    }else{
     this.uploadImg2(this.photoOrigional);
    }


}


uploadImg2 = (image2: string) : void => {

  if(image2){
 
    
        let ft = new Transfer();
        let url = this.webuploadURL+'uploadphoto.php';
        let filename = "p.jpg";
        let options = {
            fileKey: 'file',
            fileName: filename,
            mimeType: 'image/jpeg',
            chunkedMode: false,
            headers: {
                'Content-Type' : undefined
            },
            params: {
                fileName: filename,
                host_ip:localStorage.getItem("host_ip")
                
            }
          };

        ft.upload(image2, url, options, false)
        .then((result: any) => {
        console.log(result);
       // alert(result.response);
        this.photoOrigionalUrl= result.response;
        
        this.uploadAudio(this.mediafile);
        }).catch((error: any) => {
        console.log(error);
            this.oploadloader.dismiss();
            
            let alert = this.alertController.create({
            title: 'System',
            subTitle: 'Can not upload Drawing',
            buttons: ['Ok']
            });
            alert.present();
        });
        
    }else{
    this.uploadAudio(this.mediafile);
    }


}

uploadAudio = (audio: any) : void => {
  if(this.tduration > 1){
           
    
        let ft = new Transfer();
        let url = this.webuploadURL+'uplaodaudio.php';
        let filename = "a.wav";
        let mimeType = 'audio/wav';
          
        let options = {
            fileKey: 'file',
            fileName: filename,
            mimeType: mimeType,
            chunkedMode: false,
            headers: {
                'Content-Type' : undefined
            },
            params: {
                fileName: filename,
                host_ip:localStorage.getItem("host_ip"),
                
            }
          };

        ft.upload(audio, url, options, false)
        .then((result: any) => {
        console.log(result);
       // alert(result.response);
         this.audioFileUrl= result.response;
        
        this.saveformdatatofm();
        }).catch((error: any) => {
        console.log(error);
            this.oploadloader.dismiss();
            
            let alert = this.alertController.create({
            title: 'System',
            subTitle: 'Can not upload audio file',
            buttons: ['Ok']
            });
            alert.present();
        });
        
    }else{
     this.saveformdatatofm();
    }


}

saveformdatatofm(){

        let link = this.webserviceURL
     
        var data = JSON.stringify(
        {
    		  action: "addnew",
    			login_name: localStorage.getItem("login_name"),
    			login_password: localStorage.getItem("login_password"),
    			host_ip:localStorage.getItem("host_ip"),
    			db_name:localStorage.getItem("db_name"),
    			language:localStorage.getItem("language"),
    			locationText:this.locationText,
    			locationId:this.locationId,
    			servicePriority:this.servicePriority,
    			serviceCategory:this.serviceCategory,
    			serviceRemarks:this.serviceRemarks,
    			photoUrl:this.photoOrigionalUrl,
    			annotatedImageUrl:this.annotatedImageUrl,
    			audioFileUrl:this.audioFileUrl
    	 });
        
        this.http.post(link, data)
        .map(res => res.json()).subscribe(data => {
        console.log(data);
        this.lastrecird = data;
         this.oploadloader.dismiss();
         
          this.createClass =  '';
          this.checkmarkClass = 'active';
        let alert = this.alertController.create({
            title: 'System',
            subTitle: 'The new service request has been submitted sucessfully, please mark down ticket number'+' ['+this.lastrecird+'] '+'for your records !',
            buttons: [
                      {
                        text: 'Ok',
                        role: 'cancel',
                        handler: () => {
                          this.navCtrl.push(Page1Page);
                        }
                      }
                    ]
    
    
            });
        alert.present();
            
         
        });
        
   
}

}
