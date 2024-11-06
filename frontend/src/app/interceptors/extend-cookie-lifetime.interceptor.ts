import { Injectable } from '@angular/core';
import {
  HttpHandler, HttpEvent, HttpInterceptor, HttpRequest, HttpResponse,
} from '@angular/common/http';
import { CookieService } from '../services/cookie.service';
import { CookieNameEnum } from '../models/enum/cookie-name.enum';

import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

@Injectable()
export class ExtendCookieLifetimeInterceptor implements HttpInterceptor {
  readonly EXPIRATION_TIME = 1800000;

  constructor(
    private cookieService: CookieService,
  ) {}

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(req).pipe(
      tap((event: any) => {
        if (event instanceof HttpResponse) {
          const cookie = this.cookieService.getCookie(CookieNameEnum.JWT_HP);
          if (cookie) {
            this.cookieService.setCookie(CookieNameEnum.JWT_HP, cookie, this.EXPIRATION_TIME);
          }
        }
      }),
    );
  }
}
