import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, RouterStateSnapshot, Router } from '@angular/router';

import { Observable } from 'rxjs';

import { map } from 'rxjs/operators';
import { AuthenticationService } from '../services/authentication.service';
import { Role } from '@enum/role.enum';

@Injectable({
  providedIn: 'root',
})
export class RoleGuard {

  constructor(
    private authenticationService: AuthenticationService,
    private router: Router,
  ) {}

  canActivate(next: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    return this
      .isAllowed(next.data.allowedRoles)
      .pipe(
        map(isAllowed => {
          if (isAllowed) {
            return true;
          }

          if (next.data.redirection !== undefined) {
            return this.router.createUrlTree([next.data.redirection]);
          }

          return false;
        }),
      )
    ;
  }

  isAllowed(allowedRoles: Role[]): Observable<boolean> {
    return this
      .authenticationService
      .user$
      .pipe(
        map(user => allowedRoles.some(allowedRole => user.roles?.includes(allowedRole))),
      )
    ;
  }
}
