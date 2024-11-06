import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, Router, RouterStateSnapshot } from '@angular/router';
import { REDIRECT_URL_PARAMETER } from '../models/const/redirect-url-parameter.const';
import { CookieService } from '../services/cookie.service';

@Injectable({
  providedIn: 'root',
})
export class AuthGuard {

  constructor(
    private router: Router,
    private cookieService: CookieService,
  ) { }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    const jwtPayload = this.cookieService.getJwtPayload();

    if (!jwtPayload || new Date(jwtPayload.exp * 1000) < new Date()) {
      return this.router.createUrlTree(['/login'], { queryParams: { [REDIRECT_URL_PARAMETER]: state.url } });
    }

    return true;
  }
}
