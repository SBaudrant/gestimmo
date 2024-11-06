import { Inject, Injectable } from '@angular/core';
import { HttpClient, HttpContext } from '@angular/common/http';
import { CookieNameEnum } from '../models/enum/cookie-name.enum';
import { Observable, of, ReplaySubject, Subject } from 'rxjs';
import { catchError, mergeMap, take, tap } from 'rxjs/operators';
import { ParametersService } from '../services/parameters.service';
import { STORAGE } from '../injection/storage.injection';
import { REDIRECT_URL_PARAMETER } from '../models/const/redirect-url-parameter.const';
import { User } from '../models/entity/user.class';
import { Router } from '@angular/router';
import { UserService } from '../services/user.service';
import { CookieService } from '../services/cookie.service';
import { JwtPayload } from '../models/interface/jwt-payload.interface';
import { DISABLE_UNAVAILABLE_INTERCEPTOR } from '../interceptors/unauthorized.interceptor';

@Injectable({
  providedIn: 'root',
})
export class AuthenticationService {
  protected static readonly USER_KEY = 'user';

  public readonly user$: Observable<User>;
  private userSubject: Subject<User>;

  constructor(
    @Inject(STORAGE) protected readonly storage: Storage,
    protected readonly router: Router,
    protected readonly http: HttpClient,
    protected readonly userService: UserService,
    protected readonly parametersService: ParametersService,
    private readonly cookieService: CookieService,
  ) {
    this.userSubject = new ReplaySubject<User>(1);
    this.user$ = this.userSubject.asObservable();

    this.initUserValue();
  }

  public updateCurrentUser(user: Partial<User>): void {
    this
      .user$
      .pipe(
        take(1),
      )
      .subscribe(oldUser => {
        const fullUser = Object.assign(
          oldUser,
          user,
        );

        this.storage.setItem(AuthenticationService.USER_KEY, JSON.stringify(fullUser));

        this.userSubject.next(fullUser);
      })
    ;
  }

  public login(username: string, password: string): Observable<User> {
    this.purgeStorage();
    const endpoint = this.userService.resourceUrl() + '/login';

    return this
      .http
      .post(
        endpoint,
        { username, password },
      )
      .pipe(
        mergeMap(() => this.userService.findById((this.cookieService.getJwtPayload() as JwtPayload).id)),
        tap(user => this.updateCurrentUser(user)),
      )
    ;
  }

  public purgeStorage(): void {
    this.storage.clear();
  }

  public logout(redirectUrl?: string): void {
    this.http.post(
      `${this.userService.resourceUrl()}/logout`,
      {},
      {
        context: new HttpContext().set(DISABLE_UNAVAILABLE_INTERCEPTOR, true),
      },
    )
      .pipe(
        catchError(() => {
          this.cookieService.deleteCookie(CookieNameEnum.JWT_HP);
          return of(null);
        }),
      )
      .subscribe({
        complete: () => {
          this.purgeStorage();
          this.initUserValue();

          const navigationExtras = { queryParams: {} };

          if (redirectUrl !== undefined) {
            navigationExtras.queryParams[REDIRECT_URL_PARAMETER] = redirectUrl;
          }

          this.router.navigate(
            ['/login'],
            navigationExtras,
          );
        },
      });
  }

  public requestPasswordInit(email: string): Observable<void> {
    const endpoint = this.userService.resourceUrl() + '/init_password';

    return this
      .http
      .post<void>(
      endpoint,
      { email },
    )
    ;
  }

  public initPasswordWithToken(token: string, password: string): Observable<void> {
    const endpoint = this.userService.resourceUrl() + '/init_password/' + token;

    return this
      .http
      .post<void>(
      endpoint,
      { password },
    )
    ;
  }

  private initUserValue(): void {
    const storedUser = this.storage.getItem(AuthenticationService.USER_KEY);

    if (storedUser) {
      this.userSubject.next(this.userService.denormalize(JSON.parse(storedUser)));
    } else {
      // if no user is logged in, put an anonymous user
      this.userSubject.next(new User());
    }
  }
}
