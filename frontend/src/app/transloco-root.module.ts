import { HttpBackend, HttpClient } from '@angular/common/http';
import {
  TRANSLOCO_LOADER,
  Translation,
  TranslocoLoader,
  TRANSLOCO_CONFIG,
  translocoConfig,
  TranslocoModule,
} from '@ngneat/transloco';
import { Injectable, NgModule } from '@angular/core';
import { environment } from '../environments/environment';

@Injectable({ providedIn: 'root' })
export class TranslocoHttpLoader implements TranslocoLoader {
  private http: HttpClient;
  constructor(httpBackend: HttpBackend) {
    this.http = new HttpClient(httpBackend);
  }

  getTranslation(lang: string) {
    return this.http.get<Translation>(`/assets/i18n/${lang}.json?version=${environment.version}`);
  }
}

@NgModule({
  exports: [ TranslocoModule ],
  providers: [
    {
      provide: TRANSLOCO_CONFIG,
      useValue: translocoConfig({
        availableLangs: ['fr'],
        defaultLang: 'fr',
        reRenderOnLangChange: false, // Passer cette option à true si l'utilisateur peut changer de langue à la volée
        prodMode: environment.production,
      }),
    },
    { provide: TRANSLOCO_LOADER, useClass: TranslocoHttpLoader },
  ],
})
export class TranslocoRootModule {}
