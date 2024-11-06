import { Injectable } from '@angular/core';
import {
  HttpContextToken,
  HttpErrorResponse,
  HttpEvent,
  HttpHandler,
  HttpInterceptor,
  HttpRequest,
} from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { AuthenticationService } from '../services/authentication.service';

export const DISABLE_UNAVAILABLE_INTERCEPTOR = new HttpContextToken(() => false);

@Injectable({
  providedIn: 'root',
})
export class UnauthorizedInterceptor implements HttpInterceptor {

  constructor(
    private authenticationService: AuthenticationService,
  ) {}

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(req)
      .pipe(
        catchError((error: HttpErrorResponse) => {
          if (req.context.get(DISABLE_UNAVAILABLE_INTERCEPTOR) === true) {
            return throwError(() => error);
          }
          if (error.status === 401) {
            this.authenticationService.logout();
          }

          return throwError(() => error);
        }),
      );
  }

}
