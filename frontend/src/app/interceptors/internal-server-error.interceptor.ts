import { Injectable } from '@angular/core';
import { HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { NotificationService } from '../services/notification.service';
import { marker as _ } from '@ngneat/transloco-keys-manager/marker';

@Injectable({
  providedIn: 'root',
})
export class InternalServerErrorInterceptor implements HttpInterceptor {

  constructor(
    private notificationService: NotificationService,
  ) {}

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(req)
      .pipe(
        catchError((error: HttpErrorResponse) => {
          if (error.status === 500) {
            this.notificationService.error(_('Error.Default'));
          }

          return throwError(() => error);
        }),
      );
  }
}
