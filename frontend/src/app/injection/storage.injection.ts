import { InjectionToken } from '@angular/core';

export const STORAGE = new InjectionToken<Storage>(
  'Storage service',
  {
    providedIn: 'root',
    factory: () => localStorage,
  },
);
