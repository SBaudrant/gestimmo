// Angular core
import { CommonModule, registerLocaleData } from '@angular/common';
import { LOCALE_ID, NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import localeFr from '@angular/common/locales/fr';

// Our modules
import { AppRoutingModule } from './app-routing.module';
import { PagesModule } from './pages/pages.module';


// Our components
import { AppComponent } from './app.component';
import { provideHttpClient, withInterceptorsFromDi } from '@angular/common/http';
import { SharedModule } from './pages/shared.module';
import { TranslocoRootModule } from './transloco-root.module';

registerLocaleData(localeFr);

@NgModule({ declarations: [
        AppComponent,
    ],
    bootstrap: [AppComponent], imports: [CommonModule,
        AppRoutingModule,
        BrowserAnimationsModule,
        BrowserModule,
        PagesModule,
        SharedModule,
        TranslocoRootModule], providers: [
        {
            provide: LOCALE_ID,
            useValue: 'fr-FR',
        },
        provideHttpClient(withInterceptorsFromDi()),
    ] })
export class AppModule { }
