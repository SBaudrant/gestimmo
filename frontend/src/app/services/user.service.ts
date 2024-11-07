import { Injectable } from '@angular/core';

import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { HttpService } from './http.service';
import { Role } from '@enum/role.enum';
import { UserFilters } from '@filter/user-filters.class';
import { User } from '@entity/user.class';
import { Clazz } from '@models/type/clazz.type';

@Injectable({
  providedIn: 'root',
})
export class UserService extends HttpService<User, UserFilters> {
  public getClass(): Clazz<User> {
    return User;
  }

  public resourcePath(): string {
    return '/users';
  }

  public getRoles(): Role[] {
    return Object.values(Role);
  }

  public updatePassword(user: User, passwords: { oldPassword: string; newPassword: string }): Observable<User> {
    return this
      .http
      .patch<User>(
      this.resourceUrl(user) + '/change_password',
      passwords,
    )
      .pipe(
        map(updated => this.denormalize(updated)),
      )
    ;
  }
}
