import { Injectable } from '@angular/core';
import { CookieNameEnum } from '../models/enum/cookie-name.enum';
import { JwtPayload } from '../models/interface/jwt-payload.interface';

@Injectable({
  providedIn: 'root',
})
export class CookieService {

  private lastDecodedCookie: string;
  private jwtPayload: JwtPayload;

  constructor() { }

  public getJwtPayload(): JwtPayload | null {
    if (document.cookie === this.lastDecodedCookie && this.jwtPayload) {
      return this.jwtPayload;
    }

    const payload = this.getCookie(CookieNameEnum.JWT_HP)
      ?.split('.')?.[1]
    ;

    if (!payload) {
      return null;
    }

    this.jwtPayload = JSON.parse(decodeURIComponent(escape(window.atob((payload)))));
    this.lastDecodedCookie = document.cookie;

    return this.jwtPayload;
  }

  setCookie(name: string, val: string, expirationDuration: number) {
    const date = new Date();
    const value = val;

    date.setTime(date.getTime() + (expirationDuration));

    document.cookie = name + '=' + value + '; expires=' + date.toUTCString() + '; path=/';
  }

  getCookie(name: string): string | undefined {
    return document.cookie
      .split('; ')
      .find(cookie => cookie.startsWith(name + '='))
      ?.split('=')?.[1];
  }

  deleteCookie(name: string): void {
    const expiresDate = new Date('Thu, 01 Jan 1970 00:00:01 GMT');

    document.cookie = name + '=; expires=' + expiresDate.toUTCString() + '; path=/';
  }
}
