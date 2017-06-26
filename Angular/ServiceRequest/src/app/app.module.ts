import { NgModule, ErrorHandler } from '@angular/core';
import { IonicApp, IonicModule, IonicErrorHandler } from 'ionic-angular';
import { MyApp } from './app.component';
import { SetupPage } from '../pages/setup/setup';
import { Page1Page } from '../pages/page1/page1';
import { Page2Page } from '../pages/page2/page2';
import { AnnotationPage } from '../pages/annotation/annotation';
import { SignaturePadModule } from 'angular2-signaturepad';


@NgModule({
  declarations: [
    MyApp,
    SetupPage,
    AnnotationPage,
    Page1Page,
    Page2Page
  ],
  imports: [
    IonicModule.forRoot(MyApp),
    SignaturePadModule
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    SetupPage,
    AnnotationPage,
    Page1Page,
    Page2Page
    
  ],
  providers: []
})
export class AppModule {}
