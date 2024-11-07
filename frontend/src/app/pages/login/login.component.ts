import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormBuilder, Validators } from '@angular/forms';
import { HttpErrorResponse } from '@angular/common/http';
import { REDIRECT_URL_PARAMETER } from '@models/const/redirect-url-parameter.const';
import { AuthenticationService } from '../../services/authentication.service';
import { NotificationService } from '../../services/notification.service';
import { finalize } from 'rxjs/operators';
import { marker as _ } from '@ngneat/transloco-keys-manager/marker';
import { PagesModule } from '../pages.module';
import { SharedModule } from '../shared.module';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {

  public redirectUrl = '/';
  public isLoading = false;

  public form = this.formBuilder.nonNullable.group({
    username: ['', Validators.required],
    password: ['', Validators.required],
  });

  constructor(
    private authService: AuthenticationService,
    private router: Router,
    private route: ActivatedRoute,
    private formBuilder: FormBuilder,
    private notification: NotificationService,
  ) {
  }

  ngOnInit() {
    if (this.route.snapshot.queryParams[REDIRECT_URL_PARAMETER]) {
      this.redirectUrl = this.route.snapshot.queryParams[REDIRECT_URL_PARAMETER];
    }
  }

  onSubmit() {
    if (this.form.invalid) {
      return;
    }

    this.isLoading = true;

    const formRawValue = this.form.getRawValue();
    this.authService
      .login(formRawValue.username, formRawValue.password)
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        next: () => {
          this.router.navigate([this.redirectUrl]);
        },
        error: (error: HttpErrorResponse) => {
          if (error.status === 401) {
            this.notification.error(_('Login.Credentials.Error'), _('Action.Ok'), { verticalPosition: 'top' });
          }
        },
      })
    ;
  }

}
