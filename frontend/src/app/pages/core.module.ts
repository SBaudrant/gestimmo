// Angular core
import { NgModule, Optional, SkipSelf } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { RouterModule } from '@angular/router';

// Our interceptors
import { AuthorizationInterceptor } from '../interceptors/authorization.interceptor';
import { ExtendCookieLifetimeInterceptor } from '../interceptors/extend-cookie-lifetime.interceptor';
import { UnauthorizedInterceptor } from '../interceptors/unauthorized.interceptor';
import { InternalServerErrorInterceptor } from '../interceptors/internal-server-error.interceptor';

// Out components
import { LoginComponent } from './login/login.component';
import { SecuredLayoutComponent } from './secured-layout/secured-layout.component';
import { InitPasswordComponent } from './init-password/init-password.component';
import { RequestPasswordInitComponent } from './request-password-init/request-password-init.component';
import { MatMenuModule } from '@angular/material/menu';


@NgModule({
  imports: [
    CommonModule,
    RouterModule,
    MatMenuModule,
  ],
  declarations: [
    LoginComponent,
    SecuredLayoutComponent,
    InitPasswordComponent,
    RequestPasswordInitComponent,
  ],
  providers: [
    { provide: HTTP_INTERCEPTORS, useClass: ExtendCookieLifetimeInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: AuthorizationInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: UnauthorizedInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: InternalServerErrorInterceptor, multi: true },
  ],
})
export class CoreModule {

  constructor(@Optional() @SkipSelf() parentModule: CoreModule) {
    if (parentModule) {
      throw new Error(`${parentModule} has already been loaded. Import Core module in the AppModule only.`);
    }
  }

}
