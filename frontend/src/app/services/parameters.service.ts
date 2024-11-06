import { Injectable } from '@angular/core';
import { HttpBackend, HttpClient } from '@angular/common/http';

class Parameters {
  apiBaseUrl: string | null = null;
}

@Injectable({
  providedIn: 'root',
})
export class ParametersService {

  private parameters: Parameters;
  private http: HttpClient;

  constructor(httpBackend: HttpBackend) {
    this.http = new HttpClient(httpBackend);
  }

  public load(url: string): Promise<void> {
    return new Promise((resolve) => {
      this.http.get(url)
        .subscribe((parameters: Parameters) => {
          this.parameters = parameters;
          resolve();
        });
    });
  }

  public getApiHost(): string | null {
    return this.parameters.apiBaseUrl;
  }
}
