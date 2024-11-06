// Angular core
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SharedModule } from './shared.module';
import { HomeComponent } from './home/home.component';
import { LoginComponent } from './login/login.component';
import { InitPasswordComponent } from './init-password/init-password.component';
import { RequestPasswordInitComponent } from './request-password-init/request-password-init.component';
import { SecuredLayoutComponent } from './secured-layout/secured-layout.component';
import { UsersModule } from './users/users.module';
import { RouterModule } from '@angular/router';
import { MatMenuModule } from '@angular/material/menu';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { ExtendCookieLifetimeInterceptor } from '../interceptors/extend-cookie-lifetime.interceptor';
import { AuthorizationInterceptor } from '../interceptors/authorization.interceptor';
import { UnauthorizedInterceptor } from '../interceptors/unauthorized.interceptor';
import { InternalServerErrorInterceptor } from '../interceptors/internal-server-error.interceptor';

@NgModule({
  declarations: [
    HomeComponent,
    LoginComponent,
    InitPasswordComponent,
    RequestPasswordInitComponent,
    SecuredLayoutComponent
  ],
  imports: [
    // Angular core
    CommonModule,
    SharedModule,
    UsersModule,
    RouterModule,
    MatMenuModule
  ],
  exports: [
    UsersModule,
    // Our components
    HomeComponent,
    LoginComponent,
    InitPasswordComponent,
    RequestPasswordInitComponent,
    SecuredLayoutComponent,
  ],
  providers: [
    { provide: HTTP_INTERCEPTORS, useClass: ExtendCookieLifetimeInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: AuthorizationInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: UnauthorizedInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: InternalServerErrorInterceptor, multi: true },
  ],
})
export class PagesModule {}
