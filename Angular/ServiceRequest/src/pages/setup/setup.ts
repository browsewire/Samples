import { Component} from '@angular/core';
import {NavController, NavParams} from 'ionic-angular';
import { Platform } from 'ionic-angular';
import {Device} from 'ionic-native';
import { AlertController } from 'ionic-angular';
import {Http,Headers, RequestOptions} from '@angular/http';
import 'rxjs/add/operator/map';
import { LoadingController } from 'ionic-angular';

import { Page1Page } from '../page1/page1';
import { Page2Page } from '../page2/page2';




declare var navigator: any;
declare var Connection: any;


@Component({
  selector: 'page-setup',
  templateUrl: 'setup.html'
})

export class SetupPage {

  public translatedText: string;
  public supportedLanguages: any[];
  
 public title: string ;
 public subtitle: string;
 public loginName: string;
 
public login_name: string ;
public login_password: string ;
public host_ip: string ;
public db_name: string;
public language: string;

languageList: any[] = [];
public serverResponce: string;

oploadloader: any = null;
timeoutId: any = null;

public liveapiserver: string = '';

 
 
constructor(private http: Http, public alertController: AlertController,public loadingCtrl: LoadingController,public navCtrl: NavController, public navParams: NavParams, public platform: Platform) {
   
   
    if(localStorage.getItem("login_name")) { this.login_name = localStorage.getItem("login_name") }else{ this.login_name = ''} ;
    if(localStorage.getItem("login_password")) {this.login_password = localStorage.getItem("login_password") }else{this.login_password =  ''} ;
    if(localStorage.getItem("host_ip")) {this.host_ip = localStorage.getItem("host_ip") }else{this.host_ip =  ''} ;
    if(localStorage.getItem("db_name")) {this.db_name =  localStorage.getItem("db_name")}else{ this.db_name = ''} ;
    
    if(localStorage.getItem("language")) {
    this.language = localStorage.getItem("language");
    
    }else{ 
    this.language = 'English';
    
    }


    this.title= "Setup";
    this.subtitle= "User Name :";
    this.loginName= localStorage.getItem("login_name");

     
     if(localStorage.getItem("languageListArray")) {
      this.languageList = JSON.parse(localStorage.getItem("languageListArray"));
     }else{
     
      let alert = this.alertController.create({
      title: 'System',
      subTitle: 'Before using this service request app, you must fill in this setup page and proceed "Update System Data" !',
      buttons: ['Ok']
      });
      alert.present();
            
      this.languageList.push({ value:'English', text: 'English' });
      localStorage.setItem("appLanguage",'en');
     }
     
   
    platform.registerBackButtonAction(function (e) {
      e.preventDefault();
      return false;
      });
      
   this.platform.ready().then(() => {
            
            if(navigator.connection.type == 'none'){
            
            let alert = this.alertController.create({
            title: 'System',
            subTitle: 'No network connection !',
            buttons: ['Ok']
            });
            alert.present();
            }         
             
        });
     
  }




updateSetup() {

if(this.login_name && this.login_password && this.host_ip && this.db_name && this.language ){

/*
if(navigator.connection.type == 'none'){
            
let alert = this.alertController.create({
title: 'System',
subTitle: 'No network connection !',
buttons: ['Ok']
});
alert.present();
}else{
*/
this.timeoutId = setTimeout(() => {
      this.oploadloader.dismiss();
      let alert = this.alertController.create({
      title: 'System',
      subTitle: 'Cannot connect to server !',
      buttons: ['Ok']
      });
alert.present();
}, 20000);

this.oploadloader = this.loadingCtrl.create({
        content: "Please wait..."
});
this.oploadloader.present();
   
    let link = 'http://'+this.host_ip+'/api/service-request/index.php';
    
    
        var data = JSON.stringify(
        {
    		  action: "checkConnection",
    			login_name: this.login_name,
    			login_password: this.login_password,
    			host_ip:this.host_ip,
    			db_name:this.db_name,
    			language:this.language
    		}
        );
        
        this.http.post(link, data)
        .map(res => res.json()).subscribe(data => {
         
    this.serverResponce = data;
       
    
   if(this.serverResponce == '0'){
    if (this.timeoutId != null) {
      clearTimeout(this.timeoutId);
      this.timeoutId = null;
    }
     this.updateCategoryList();
   }else if(this.serverResponce == '22'){
  if (this.timeoutId != null) {
      clearTimeout(this.timeoutId);
      this.timeoutId = null;
    }
  this.oploadloader.dismiss();
  let alert = this.alertController.create({
      title: 'System',
      subTitle: "Server authentication failed !",
      buttons: ['Ok']
    });
    alert.present();
    
  }else{
  if (this.timeoutId != null) {
      clearTimeout(this.timeoutId);
      this.timeoutId = null;
    }
  this.oploadloader.dismiss();
  let alert = this.alertController.create({
      title: 'System',
      subTitle: "Cannot connect to server !",
      buttons: ['Ok']
    });
    alert.present();
    
  
  }
   }, error => {
           this.oploadloader.dismiss();
  let alert = this.alertController.create({
      title: 'System',
      subTitle: "Cannot connect to server !",
      buttons: ['Ok']
    });
    alert.present();
        });
  
//}  
 
}else{
 
 let emptyfiels = '';
let emptyfielssepra = ',';
if(!this.login_name){
emptyfiels = emptyfiels+ 'Login Name';
} 
if(!this.login_password){
if(emptyfiels!=''){
emptyfielssepra = ', ';
}else{
emptyfielssepra = '';
}
emptyfiels = emptyfiels+emptyfielssepra+ 'Password';
}
if(!this.host_ip){
if(emptyfiels!=''){
emptyfielssepra = ', ';
}else{
emptyfielssepra = '';
}
emptyfiels = emptyfiels+emptyfielssepra+ 'Host IP';
} 
if(!this.db_name){
if(emptyfiels!=''){
emptyfielssepra = ', ';
}else{
emptyfielssepra = '';
}
emptyfiels = emptyfiels+emptyfielssepra+ 'DB Name';
} 
if(!this.language){
if(emptyfiels!=''){
emptyfielssepra = ', ';
}else{
emptyfielssepra = '';
}
emptyfiels = emptyfiels+emptyfielssepra+ 'Language';
}  
let alert = this.alertController.create({
      title: 'System',
      subTitle:  'Please Enter:'+' '+emptyfiels,
      buttons: ['Ok']
    });
    alert.present();
}
 
}

handleError(error) {
		console.log(error);
		return error.json().message || 'Server error, please try again later';
	}
updateCategoryList(){
       let link = 'http://'+this.host_ip+'/api/service-request/index.php';
       var data = JSON.stringify(
        {
    		  action: "getCategory",
    			login_name: this.login_name,
    			login_password: this.login_password,
    			host_ip:this.host_ip,
    			db_name:this.db_name,
    			language:this.language
    		}
        );
        
        this.http.post(link, data)
        .map(res => res.json()).subscribe(data => {
        localStorage.setItem("categoryList",JSON.stringify(data));
        this.updateLocationList();
    });

}

updateLocationList(){
      let link = 'http://'+this.host_ip+'/api/service-request/index.php';
       var data = JSON.stringify(
        {
    		  action: "getLocation",
    			login_name: this.login_name,
    			login_password: this.login_password,
    			host_ip:this.host_ip,
    			db_name:this.db_name,
    			language:this.language
    		}
        );
        
        this.http.post(link, data)
        .map(res => res.json()).subscribe(data => {
        localStorage.setItem("locationList",JSON.stringify(data));
        this.updatePriprityList();
        
    });
    
}

updatePriprityList(){
     let link = 'http://'+this.host_ip+'/api/service-request/index.php';
       var data = JSON.stringify(
        {
    		  action: "getPriority",
    			login_name: this.login_name,
    			login_password: this.login_password,
    			host_ip:this.host_ip,
    			db_name:this.db_name,
    			language:this.language
    		}
        );
        
        this.http.post(link, data)
        .map(res => res.json()).subscribe(data => {
        localStorage.setItem("priprityList",JSON.stringify(data));
        this.updateLanguageList();
    });

}

updateLanguageList(){
      let link = 'http://'+this.host_ip+'/api/service-request/index.php';
       var data = JSON.stringify(
        {
    		  action: "getLanguages",
    			login_name: this.login_name,
    			login_password: this.login_password,
    			host_ip:this.host_ip,
    			db_name:this.db_name,
    			language:this.language
    		}
        );
        
        this.http.post(link, data)
        .map(res => res.json()).subscribe(data => {
        localStorage.setItem("languageListArray",JSON.stringify(data));
        this.updateLoginSession();
    });

}

updateLoginSession(){
  let webserverapiURL = 'http://'+this.host_ip+'/api/service-request/index.php';
  let webserverupload = 'http://'+this.host_ip+'/api/service-request/';
  
   localStorage.setItem("login_name",this.login_name );
   localStorage.setItem("login_password",this.login_password );
   localStorage.setItem("host_ip",this.host_ip );
   localStorage.setItem("db_name",this.db_name );
   localStorage.setItem("language",this.language );
   localStorage.setItem("webserviceURL",webserverapiURL)
   localStorage.setItem("webuploadURL",webserverupload );
   
   localStorage.setItem("appLanguage",'en');
   
   
   
   
   this.oploadloader.dismiss();
   let returnPage = localStorage.getItem("returnPage");
   if(returnPage ){
    this.navCtrl.push(Page2Page);
   }else{
   this.navCtrl.push(Page1Page);
   }
   
}



gotToBack() {

let emptyfiels = '';
let emptyfielssepra = ',';
if(!this.login_name){
emptyfiels = emptyfiels+ 'Login Name';
} 
if(!this.login_password){
if(emptyfiels!=''){
emptyfielssepra = ', ';
}else{
emptyfielssepra = '';
}
emptyfiels = emptyfiels+emptyfielssepra+ 'Password';
}
if(!this.host_ip){
if(emptyfiels!=''){
emptyfielssepra = ', ';
}else{
emptyfielssepra = '';
}
emptyfiels = emptyfiels+emptyfielssepra+ 'Host IP';
} 
if(!this.db_name){
if(emptyfiels!=''){
emptyfielssepra = ', ';
}else{
emptyfielssepra = '';
}
emptyfiels = emptyfiels+emptyfielssepra+ 'DB Name';
} 
if(!this.language){
if(emptyfiels!=''){
emptyfielssepra = ', ';
}else{
emptyfielssepra = '';
}
emptyfiels = emptyfiels+emptyfielssepra+ 'Language';
}
if(emptyfiels!=''){
   
   
let subTitleMessage = "If you leave"+' '+emptyfiels+' '+"field(s) empty, system cannot proceed record submission and value list data updating, are you sure to leave ?"

  
let alert = this.alertController.create({
      title: 'System',
      subTitle:  subTitleMessage,//"Are you sure to leave ?",
      buttons: [
      {
        text: 'No',
        role: 'cancel',
        handler: () => {
          
        }
      },
      {
        text: 'Yes',
        handler: () => {
        
         localStorage.setItem("login_name",this.login_name );
         localStorage.setItem("login_password",this.login_password );
         localStorage.setItem("host_ip",this.host_ip );
         localStorage.setItem("db_name",this.db_name );
         localStorage.setItem("language",this.language );
         //localStorage.setItem("categoryList",JSON.stringify(''));
       //  localStorage.setItem("locationList",JSON.stringify(''));
        // localStorage.setItem("priprityList",JSON.stringify(''));
        let webserverapiURL = 'http://'+this.host_ip+'/api/service-request/index.php';
        let webserverupload = 'http://'+this.host_ip+'/api/service-request/';
        
         
        localStorage.setItem("webserviceURL",webserverapiURL)
        localStorage.setItem("webuploadURL",webserverupload );
        let returnPage = localStorage.getItem("returnPage");
       if(returnPage ){
        this.navCtrl.push(Page2Page);
       }else{
       this.navCtrl.push(Page1Page);
       }
        }
      }
    ]
    });
    alert.present();
    
}else{
//this.itemTapped();

         localStorage.setItem("login_name",this.login_name );
         localStorage.setItem("login_password",this.login_password );
         localStorage.setItem("host_ip",this.host_ip );
         localStorage.setItem("db_name",this.db_name );
         localStorage.setItem("language",this.language );
         
         let webserverapiURL = 'http://'+this.host_ip+'/api/service-request/index.php';
         let webserverupload = 'http://'+this.host_ip+'/api/service-request/';
         localStorage.setItem("webserviceURL",webserverapiURL)
         localStorage.setItem("webuploadURL",webserverupload );
         let returnPage = localStorage.getItem("returnPage");
   if(returnPage ){
    this.navCtrl.push(Page2Page);
   }else{
   this.navCtrl.push(Page1Page);
   }
         
         
}
}



}
