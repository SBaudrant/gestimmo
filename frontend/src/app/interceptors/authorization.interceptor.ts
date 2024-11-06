import { Injectable } from '@angular/core';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ParametersService } from '../services/parameters.service';

@Injectable({
  providedIn: 'root',
})
export class AuthorizationInterceptor implements HttpInterceptor {

  constructor(
    private parametersService: ParametersService,
  ) {
  }

  public intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const apiHost = this.parametersService.getApiHost();
    if (apiHost && req.url?.startsWith(apiHost)) {
      req = req.clone({
        withCredentials: true,
      });
    }

    return next.handle(req);
  }
}
